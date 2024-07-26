<?php
include "../settings/sql_queries.php"; // Include database connection configuration

// Define the logging function
function writeToLog($message) {
    error_log(date('Y-m-d H:i:s') . ": " . $message . "\n", 3, '../logs/build_result.log');
}

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the form data
        $build_id = isset($_POST['build_id']) ? $_POST['build_id'] : null; // Get the build_id from POST data
        $file = isset($_FILES['file']) ? $_FILES['file'] : null; // File upload

        // Log the request details
        writeToLog("Received POST request. Build ID: " . $build_id);

        // Check if the file was received and there was no upload error
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            writeToLog("File not received or upload error: " . $file['error']);
            echo "File upload failed.";
            exit;
        }

        // Validate that the build_id is provided
        if (empty($build_id)) {
            writeToLog("Build ID is missing.");
            echo "Build ID is required.";
            exit;
        }

        // Define the upload directory based on the build_id
        $upload_dir = "uploads/" . $build_id . "/";

        // Check if the upload directory exists, otherwise, create it
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                writeToLog("Failed to create upload directory: " . $upload_dir);
                echo "Failed to create upload directory.";
                exit;
            }
            writeToLog("Created upload directory: " . $upload_dir);
        } else {
            writeToLog("Upload directory already exists: " . $upload_dir);
        }

        // Move the uploaded file to the upload directory
        $target_file = $upload_dir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            writeToLog("File uploaded successfully: " . $target_file);

            // Prepare the SQL statement to update the 'payload' and 'to_build' columns in the 'build' table
            $sql = "UPDATE build SET payload = ?, to_build = 0 WHERE build_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare SQL statement: " . $conn->error);
            }

            $stmt->bind_param("ss", $target_file, $build_id);

            // Execute the SQL statement
            if ($stmt->execute()) {
                writeToLog("Database updated successfully for Build ID: " . $build_id);
                echo "File uploaded and database updated successfully!";
            } else {
                throw new Exception("Error updating database: " . $stmt->error);
            }

            // Close the statement
            $stmt->close();
        } else {
            throw new Exception("Error moving uploaded file to: " . $target_file);
        }
    } else {
        throw new Exception("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (Exception $e) {
    // Log the exception message
    writeToLog("Exception caught: " . $e->getMessage());
    echo "An error occurred: " . $e->getMessage();
}
?>

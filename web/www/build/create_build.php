<?php
  include "../settings/sql_queries.php";

  // Check if the request method is POST
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $build_id = $_POST['build_id'];
    $side_loading = $_POST['side_loading'];
    $shellcode = $_FILES['shellcode'];

    // Create the upload directory based on the build_id
    $upload_dir = "uploads/" . $build_id . "/";
    if (!is_dir($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }

    // Move the uploaded file to the upload directory
    $target_file = $upload_dir . basename($shellcode['name']);
    if (move_uploaded_file($shellcode['tmp_name'], $target_file)) {
      // Prepare the SQL statement for inserting data into the 'build' table
      $sql = "INSERT INTO build (build_id, side_loading, shellcode) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sss", $build_id, $side_loading, $target_file);

      // Execute the SQL statement
      if ($stmt->execute()) {
        echo "Data inserted successfully!";
      } else {
        echo "Error inserting data: " . $stmt->error;
      }

      // Close the statement
      $stmt->close();
    } else {
      echo "Error uploading file.";
    }
  }
?>
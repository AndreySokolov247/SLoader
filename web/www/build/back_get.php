<?php
include "../settings/sql_queries.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare the SQL statement to fetch records from the 'build' table where to_build = 1
    $sql = "SELECT * FROM build WHERE to_build = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to hold the builds with shellcode content
    $builds = [];

    // Fetch all results and process each record
    while ($row = $result->fetch_assoc()) {
        // Initialize shellcode content
        $shellcode_content = '';

        // Check if shellcode path is not empty and file exists
        if (!empty($row['shellcode']) && file_exists($row['shellcode'])) {
            // Read the content of the shellcode file
            $shellcode_content = file_get_contents($row['shellcode']);
            if ($shellcode_content !== false) {
                // Encode the content in Base64
                $shellcode_content = base64_encode($shellcode_content);
            } else {
                $shellcode_content = 'Error reading file';
            }
        } else {
            $shellcode_content = 'File not found or empty path';
        }

        // Add the Base64 encoded shellcode content to the row data
        $row['shellcode'] = $shellcode_content;

        // Add the processed row to the builds array
        $builds[] = $row;
    }

    // Return the results in JSON format
    header('Content-Type: application/json');
    echo json_encode($builds);

    // Close the statement
    $stmt->close();
} else {
    // If not a POST request, return an error message
    echo json_encode(['error' => 'Invalid request method.']);
}
?>

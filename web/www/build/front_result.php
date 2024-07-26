<?php
include "../settings/sql_queries.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the build_id from the POST request
    $build_id = $_POST['build_id'];

    // Prepare the SQL statement to fetch the build record
    $sql = "SELECT payload FROM build WHERE build_id = ? AND to_build = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $build_id); // Bind the build_id parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($row = $result->fetch_assoc()) {
        // Check if the payload is not empty
        if (!empty($row['payload'])) {
            // Return the payload as the response
            echo $row['payload'];
        } else {
            // Payload is empty
            echo 'false';
        }
    } else {
        // No matching record found
        echo 'false';
    }

    // Close the statement
    $stmt->close();
} else {
    // If not a POST request, return an error message
    echo 'Invalid request method.';
}
?>

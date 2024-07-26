<?php
include "settings.php";

//______________________________________________________________________________________________________________________

// Prepare and execute the SQL statement for fetching data from the build table
$sql_build = "SELECT build_id, side_loading, shellcode FROM build"; // Changed to 'build'
$stmt_build = $conn->prepare($sql_build);
$stmt_build->execute();
$result_build = $stmt_build->get_result();

// Fetch data and generate table rows
$rows_build = '';
while ($row = $result_build->fetch_assoc()) {
    // 'side_loading' is a string representing the chosen program name
    $side_loading = htmlspecialchars($row['side_loading']);
    
    // Determine the shellcode icon based on its value
    // Assuming shellcode is checked for null or empty string
    $shellcode_icon = (!empty($row['shellcode'])) 
        ? '<i class="fas fa-check-circle" style="color: lightgreen; font-size: 20px; display: block;"></i>' 
        : '<i class="fas fa-times-circle" style="color: red; font-size: 20px; display: block;"></i>';

    $rows_build .= '<tr>
                        <td class="align-middle">
                            <input class="form-check-input" type="checkbox" style="width: 16px; height: 16px;" />
                        </td>
                        <td class="align-middle">' . htmlspecialchars($row['build_id']) . '</td>
                        <td class="align-middle">' . $side_loading . '</td>
                        <td class="align-middle">' . $shellcode_icon . '</td>
                    </tr>';
}

// Close the statement
$stmt_build->close();

?>
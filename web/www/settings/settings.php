<?php

    // Turn off all error reporting
    //error_reporting(0);

    // Disable display of errors
    //ini_set('display_errors', 0);

    // Database settings
    $hostname = 'mysql_db';
    $username = 'sloader';
    $password = 'password';
    $database = 'sloader';

    // Connect to the database
    $conn = mysqli_init();
    mysqli_real_connect($conn, $hostname, $username, $password, $database);

?>
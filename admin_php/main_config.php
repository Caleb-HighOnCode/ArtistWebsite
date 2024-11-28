<?php
$hostname = "localhost"; // Replace with your MySQL server host
$username = "wright_brick";      // Replace with your MySQL username
$password = "WB@hoc2024";          // Replace with your MySQL password
$database = "wright_brick";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected to the database successfully!";
    error_log("Connected to the database successfully!"); // Write to error log
}
?>

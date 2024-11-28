<?php
$hostname = "localhost"; // Replace with your MySQL server host
$username = "root";      // Replace with your MySQL username
$password = "";          // Replace with your MySQL password
$database = "art";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected to the database successfully!";
    error_log("Connected to the database successfully!"); // Write to error log
}
?>

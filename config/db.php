<?php
// Database configuration

$host = "localhost";      // Database server
$user = "root";           // Database username
$password = "";           // Database password
$dbname = "code_vimarsh"; // Database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

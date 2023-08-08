<?php
// Database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'info';

// Create a database connection using mysqli
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

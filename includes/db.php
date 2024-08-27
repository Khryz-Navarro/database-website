<?php
// Database connection setup
$servername = "localhost";
$dbUsername = "root";  // Default username for XAMPP/WAMP
$dbPassword = "";      // Default password for XAMPP/WAMP
$dbname = "login_system";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

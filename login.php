<?php
// Start a session
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Default username for XAMPP/WAMP
$password = "";      // Default password for XAMPP/WAMP
$dbname = "website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and execute a query
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user is found
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($pass == $row['password']) {  // In a real application, use password hashing
            $_SESSION['username'] = $user;
            header("Location: welcome.php");  // Redirect to the welcome page
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No user found with that username!";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

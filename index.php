<?php
session_start();
require 'includes/db.php';

// Handling login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Check user credentials
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            header("Location: welcome.php");
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "No user found with that email!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">Login</h2>
                        <?php if (isset($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <p class="mt-3 text-center"><a href="forgot_password.php">Forgot your password?</a></p>
                        <p class="text-center"><a href="signup.php">Sign up here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

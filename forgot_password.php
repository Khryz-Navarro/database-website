<?php
require 'includes/db.php';
require 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store reset token and expiration
        $sql = "UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

        $resetLink = "http://localhost/project-root/reset_password.php?token=$token";
        sendResetEmail($email, $resetLink);
    } else {
        $message = "No user found with that email address.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">Forgot Password</h2>
                        <?php if (isset($message)) echo "<div class='alert alert-danger'>$message</div>"; ?>
                        <form action="forgot_password.php" method="post">
                            <div class="form-group">
                                <label for="email">Enter your email address:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                        </form>
                        <p class="mt-3 text-center"><a href="index.php">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

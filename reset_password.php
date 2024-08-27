<?php
require 'includes/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPassword = $_POST['password'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashedPassword, $token);

        if ($stmt->execute()) {
            $message = "Your password has been successfully reset!";
            header("Location: index.php");
            exit();
        } else {
            $message = "Failed to reset password.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">Reset Password</h2>
                        <?php if (isset($message)) echo "<div class='alert alert-success'>$message</div>"; ?>
                        <form action="reset_password.php?token=<?php echo htmlspecialchars($_GET['token']); ?>" method="post">
                            <div class="form-group">
                                <label for="password">Enter your new password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

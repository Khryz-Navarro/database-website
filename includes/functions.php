<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include Composer's autoloader
require __DIR__ . '/../vendor/autoload.php'; // Correct path using absolute directory
// Send Reset Email using PHPMailer
function sendResetEmail($to, $resetLink) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = ''; // SMTP username
        $mail->Password = '';  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('', 'Mailer');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'Click the link below to reset your password:<br><br>' . $resetLink;
        $mail->AltBody = 'Do not reply to this email.';

        $mail->send();
        echo 'Password reset link has been sent to your email.';
    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
}
?>

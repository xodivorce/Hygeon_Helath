<?php
// Start the session
session_start();

// Include necessary files
require_once 'connection.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Check if the email is stored in the session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Generate a new OTP
    $otp = rand(1000, 9999);

    // Update the OTP in the database for the user
    $sql = "UPDATE user SET user_otp = ? WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $otp, $email);

    if ($stmt->execute()) {
        // Send the OTP to the user's email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST']; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USERNAME']; // SMTP username
            $mail->Password   = $_ENV['SMTP_PASSWORD']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'];

            // Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Mailer');
            $mail->addAddress($email); // Recipient's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = 'Your OTP code is <b>' . $otp . '</b>';
            $mail->AltBody = 'Your OTP code is ' . $otp;

            // Send the email
            $mail->send();
            $_SESSION['success_message'] = 'A new OTP has been sent to your email address.';
            header('Location: ../forgot_pass_step_two.php'); // Redirect back to the confirmation page
            exit;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to update OTP in the database.";
    }

    $stmt->close();
} else {
    echo "No email found in session.";
}

$conn->close();
?>

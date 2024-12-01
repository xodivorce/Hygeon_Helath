<?php
// Start timer for debugging
$start_time = microtime(true);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the environment variables and PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection
require_once 'connection.php';

$email = $_POST['email'];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $otp = rand(1000, 9999);

    // Optimize database query with prepared statement
    $sql = "UPDATE user SET user_otp = ? WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $otp, $email);

    if ($stmt->execute()) {
        // Send OTP email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST']; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USERNAME']; // SMTP username
            $mail->Password   = $_ENV['SMTP_PASSWORD']; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['SMTP_PORT'];

            //Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'Hygeon Heath Care');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset - Hygeon Heath Care';
            $mail->Body    = 
            'Hello User,<br><br>
            Your one time password: <b>' . $otp . '</b>.<br><br>
            
            Your one-time password (OTP) is valid for a single session. If you refresh the page or exit the Next Step portal, you will need to regenerate a new OTP.<br><br>

            If you did not request this OTP, please contact us immediately at www.xodivorce.in.<br><br>
            
            Regards,<br>
            Hygeon Heath Care<br>
            2024 © All rights reserved';

            $mail->AltBody = 'Your OTP code is ' . $otp;

            $mail->send();
                // Redirect to ../fogot_pass_step_two.php
                session_start(); // Start the session
                $_SESSION['email'] = $email; // Store the email in the session
                header('Location: ../forgot_pass_step_two.php'); // Redirect to the next pag
            exit; // Ensure no further script execution after redirection
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to update OTP in the database.";
    }

    $stmt->close();
} else {
    echo "Invalid email address.";
}

$conn->close();
?>
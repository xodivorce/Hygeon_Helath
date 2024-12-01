<?php 
// Include the environment variables and PHPMailer
require_once __DIR__ . '/vendor/autoload.php';  // Correct the path to the autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Adjust the path to load the .env file from the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');  // Correct path to load from the root folder
$dotenv->load();

// Database connection
require_once 'connection.php';

// Get email from POST request
$email = $_POST['email'];

// Validate email
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

    // Generate a 4-digit OTP
    $otp = rand(1000, 9999);

    // Prepare SQL query to update OTP
    $sql = "UPDATE user SET user_otp = ? WHERE user_email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param('is', $otp, $email);
        $stmt->execute();
        $stmt->close();
        
        // Send OTP to the user's email
        sendOtpEmail($email, $otp);

        // Redirect to the next step or show success message
        header("Location: forgot_pass_step_two.php?email=" . urlencode($email));
        exit();
    } else {
        echo "Error updating OTP.";
    }
} else {
    echo "Invalid email address.";
}

// Function to send OTP email
function sendOtpEmail($to, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Recipients
        $mail->setFrom($_ENV['SMTP_USER'], 'Hygeon Health');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body    = "Your OTP for resetting your password is: <strong>$otp</strong>";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
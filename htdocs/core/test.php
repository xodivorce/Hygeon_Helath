<?php
require 'vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');  // Ensure this path is correct
$dotenv->load();

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
    $mail->setFrom($_ENV['SMTP_USERNAME'], 'Mailer');
    $mail->addAddress('prasidmandal79@gmail.com', 'Prasid Manadal');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
<?php
session_start(); // Start the session to access session variables

// Check if the email exists in the session
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Simulate sending the email (you can use mail() or any other email service here)
    $subject = "Your Confirmation Code";
    $message = "Here is your confirmation code: 1234"; // Replace this with the actual code generation logic
    $headers = "From: no-reply@yourdomain.com";

    // Send the email
    if (mail($email, $subject, $message, $headers)) {
        echo "success"; // Email sent successfully
    } else {
        echo "failure"; // Failed to send the email
    }
} else {
    echo "no_email"; // No email found in the session
}
?>

<?php
session_start(); // Start the session to access session variables
require_once 'connection.php'; // Include the database connection

error_reporting(E_ALL);
ini_set('display_errors', 1);


$email = isset($_SESSION['email']) ? $_SESSION['email'] : ''; // Retrieve the email from the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userOtp = $_POST['otp']; // Get the OTP entered by the user

    // Validate if email and OTP are set
    if (!empty($email) && !empty($userOtp)) {
        // Query the database to get the OTP for the user with the provided email
        $sql = "SELECT user_otp FROM user WHERE user_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($dbOtp);
        $stmt->fetch();
        $stmt->close();

        // Check if the OTP entered by the user matches the one in the database
        if ($userOtp == $dbOtp) {
            // OTP is correct, redirect to the next step
            header('Location: ../forgot_pass_step_three.php');
            exit;
        } else {
            // OTP is incorrect, set error message
            $_SESSION['error_message'] = "Invalid OTP. Please double-check the OTP.";
            header('Location: ../forgot_pass_step_two.php');
            exit;
        }
    } else {
        // If email or OTP is empty, set error message
        $_SESSION['error_message'] = "Please fillout the OTP.";
        header('Location: ../forgot_pass_step_two.php');
        exit;
    }
}
?>
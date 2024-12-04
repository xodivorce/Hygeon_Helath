<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];

if (isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the new password is at least 8 characters long
    if (strlen($newPassword) < 8) {
        $_SESSION['error_message'] = 'Password must be at least 8 characters long.';
        header('Location: ../forgot_pass_step_three.php');
        exit();
    }

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error_message'] = 'Passwords do not match.';
        header('Location: ../forgot_pass_step_three.php');
        exit();
    }

    // Hash the new password before storing it
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Prepare the SQL query
    $sql = "UPDATE user SET user_pass = ? WHERE user_email = ?";
    $stmt = $conn->prepare($sql);

    // Check if the prepare statement was successful
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind parameters and execute the query
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        header('Location: ../password_reset_success.php');
        exit();
    } else {
        $_SESSION['error_message'] = 'Failed to update the password. Please try again.';
        header('Location: ../forgot_pass_step_three.php');
        exit();
    }

    $stmt->close();
} else {
    header('Location: ../forgot_pass_step_three.php');
    exit();
}

$conn->close();
?>
<?php
include('connection.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = $_POST['user_pass'];

    // Check if email exists
    $checkEmail = "SELECT * FROM user WHERE user_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['user_pass'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_email'] = $row['user_email'];
            $_SESSION['user_type'] = $row['user_type'];

            header('Location: ../home.php');
            exit();
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
            header('Location: ../login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Email not found. Please register.";
        header('Location: ../register.php');
        exit();
    }
}

$conn->close();
?>
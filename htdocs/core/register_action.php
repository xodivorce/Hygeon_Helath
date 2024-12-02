<?php
include('connection.php');
session_start(); // Start the session for storing error messages
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit_btn'])) {
    $fName = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lName = mysqli_real_escape_string($conn, $_POST['l_name']);
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = mysqli_real_escape_string($conn, $_POST['user_pass']); // Plain text password
    $uName = $fName . " " . $lName;
    $uType = 1;

    // Check if password is at least 8 characters long
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header('Location: ../register.php'); // Redirect to the register page
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT * FROM user WHERE user_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Store the error message in the session
        $_SESSION['error'] = "Email already exists. Please use a different email.";
        header('Location: ../register.php'); // Redirect to the register page
        exit();
    } else {
        // Insert the user data with plain text password
        $sql = "INSERT INTO user (`user_name`, `user_email`, `user_pass`, `user_type`, `user_otp`) 
                VALUES ('$uName', '$email', '$password', '$uType', NULL)";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../login.php');
            exit();
        } else {
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
            header('Location: ../register.php');
            exit();
        }
    }
}

$conn->close();
?>

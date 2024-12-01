<?php
include('connection.php');
session_start(); // Start the session for storing error messages
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit_btn'])) {
    $fName = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lName = mysqli_real_escape_string($conn, $_POST['l_name']);
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = $_POST['user_pass'];
    $pass_encrypt = password_hash($password, PASSWORD_DEFAULT);
    $uName = $fName . " " . $lName;
    $uType = 1;

    $checkEmail = "SELECT * FROM user WHERE user_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Store the error message in the session
        $_SESSION['error'] = "Email already exists. Please use a different email.";
        header('Location: register.php'); // Redirect to the register page
        exit();
    } else {
        $sql = "INSERT INTO user (`user_name`, `user_email`, `user_pass`, `user_type`) 
                VALUES ('$uName', '$email', '$pass_encrypt', '$uType')";

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

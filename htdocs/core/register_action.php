<?php
include('../core/connection.php'); // Ensure correct path
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($pdo)) {
    die("Database connection not established.");
}

if (isset($_POST['submit_btn'])) {
    // Get form data
    $fName = $_POST['f_name'];
    $lName = $_POST['l_name'];
    $email = $_POST['user_email'];
    $password = $_POST['user_pass'];
    $uName = $fName . " " . $lName;
    $uType = 3;

    // Check password length
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header('Location: ../register.php');
        exit();
    }

    // Check if email already exists using PDO
    $stmt = $pdo->prepare("SELECT * FROM user WHERE user_email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists. Please use a different email.";
        header('Location: ../register.php');
        exit();
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data using prepared statement
        $stmt = $pdo->prepare("INSERT INTO user (user_name, user_email, user_pass, user_type, user_otp) 
                               VALUES (:user_name, :user_email, :user_pass, :user_type, NULL)");
        $stmt->execute([
            'user_name' => $uName,
            'user_email' => $email,
            'user_pass' => $hashedPassword,
            'user_type' => $uType
        ]);

        // Get last inserted user ID
        $userId = $pdo->lastInsertId();
        $userIp = $_SERVER['REMOTE_ADDR'];

        // Insert user IP into `user_ip` table
        $stmt = $pdo->prepare("INSERT INTO user_ip (user_id, ip_address) VALUES (:user_id, :ip_address)");
        $stmt->execute(['user_id' => $userId, 'ip_address' => $userIp]);

        header('Location: ../login.php');
        exit();
    }
}
?>

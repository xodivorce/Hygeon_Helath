<?php
session_start();
require_once 'connection.php'; // Include your database connection file

// Function to get the user IP address
function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the user's stored IP address from the database
    $userId = $_SESSION['user_id'];
    $userIp = getUserIpAddr(); // Get the current IP address

    try {
        // Query to get the user's IP address from the database
        $checkIpSql = "SELECT ip_address FROM user_ip WHERE user_id = :user_id";
        $stmt = $pdo->prepare($checkIpSql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedIp = $row['ip_address'];

            // Check if the IP address matches
            if ($storedIp === $userIp) {
                // IP matches, redirect to login page
                header('Location: ../login.php');
                exit();
            } else {
                // IP doesn't match, redirect to register page
                header('Location: ../register.php');
                exit();
            }
        } else {
            // No IP found for the user, redirect to register page
            header('Location: ../register.php');
            exit();
        }
    } catch (PDOException $e) {
        // Handle any database connection errors
        die("Database query failed: " . $e->getMessage());
    }
} else {
    // User is not logged in, redirect to the login page
    header('Location: ../login.php');
    exit();
}
?>

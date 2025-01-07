<?php
require_once 'connection.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

if (isset($_POST['login_btn'])) {
    $email = $_POST['user_email'];
    $password = $_POST['user_pass'];

    try {
        // Check if the email exists
        $stmt = $pdo->prepare("SELECT * FROM user WHERE user_email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if the user is banned by checking user_type == 4
            if ($row['user_type'] == 4) {
                $_SESSION['error'] = "Your account is banned. Please contact support.";
                header('Location: ../login.php');
                exit();
            }

            // Now verify the password, since user is not banned
            if (password_verify($password, $row['user_pass'])) {
                // Set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['user_email'] = $row['user_email'];
                $_SESSION['user_type'] = $row['user_type'];

                // Get the user's current IP address
                $userIp = getUserIpAddr();

                // Insert or update the user's IP address in the user_ip table
                $updateIpSql = "INSERT INTO user_ip (user_id, ip_address) 
                                VALUES (:user_id, :ip_address)
                                ON DUPLICATE KEY UPDATE ip_address = :ip_address";
                $ipStmt = $pdo->prepare($updateIpSql);
                $ipStmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $ipStmt->bindParam(':ip_address', $userIp, PDO::PARAM_STR);

                if ($ipStmt->execute()) {
                    // Redirect to dashboard page after successful login
                    header('Location: ../dashboard.php');
                    exit();
                } else {
                    $_SESSION['error'] = "Error updating IP information. Please try again.";
                    header('Location: ../login.php');
                    exit();
                }
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
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header('Location: ../login.php');
        exit();
    }
}
?>

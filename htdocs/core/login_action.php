<?php
include('connection.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to get the user IP address
function getUserIpAddr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP passed from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP address from remote address
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = $_POST['user_pass'];

    // Check if the email exists
    $checkEmail = "SELECT * FROM user WHERE user_email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
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
                            VALUES ('" . $_SESSION['user_id'] . "', '$userIp')
                            ON DUPLICATE KEY UPDATE ip_address = '$userIp'";

            // Execute the query to update IP address
            if ($conn->query($updateIpSql) === TRUE) {
                // Redirect to home page after successful login
                header('Location: ../home.php');
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
}

$conn->close();
?>

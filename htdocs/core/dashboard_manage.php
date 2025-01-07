<?php
session_start();

// Ensure the user is logged in
$user_type = $_SESSION['user_type'] ?? null;  // If not set, user is not logged in

// If the user is not logged in, redirect to login page
if ($user_type === null) {
    header('Location: ../login.php');
    exit();  // Stop further execution
}

// Check if the user is allowed to access the dashboard (user_type 1, 2, or 3)
if ($user_type >= 1 && $user_type <= 3) {
    // Redirect allowed users to dashboard.php
    header('Location: ../dashboard.php');
    exit();  // Stop further execution
} else {
    // Redirect banned or unauthorized users to login.php
    $_SESSION['error'] = "You do not have permission to access the dashboard.";
    header('Location: ../login.php');
    exit();  // Stop further execution
}
?>

<?php
session_start();
require_once 'connection.php'; // Include your database connection file

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to the schedule page
    header('Location: ../register.php');
    exit();
} else {
    // User is not logged in, redirect to the login page
    $_SESSION['error'] = "Please log in to schedule an appointment.";
    header('Location: ../login.php');
    exit();
}
?>
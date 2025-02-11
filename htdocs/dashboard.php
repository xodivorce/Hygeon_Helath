<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .active {
            font-weight: bold;
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight">
                <?php 
                    if (isset($_SESSION['user_type'])) {
                        switch ($_SESSION['user_type']) {
                            case 1:
                                echo "Admin Dashboard";
                                break;
                            case 2:
                                echo "Doctor Dashboard";
                                break;
                            case 3:
                                echo "Patient Dashboard";
                                break;
                            default:
                                echo "Dashboard";
                        }
                    } else {
                        echo "Dashboard";
                    }
                ?>
            </h1>
            <nav>
                <a href="logout.php" class="text-sm bg-red-500 px-6 py-2 rounded-lg hover:bg-red-600 transition duration-200 ease-in-out shadow-md">Logout</a>
            </nav>
        </div>
    </header>

    <div class="flex flex-1">
        <aside class="w-64 bg-gray-900 text-gray-100 shadow-xl">
            <nav class="p-6">
                <ul class="space-y-2">
                    <?php if ($_SESSION['user_type'] == 1): ?>
                        <li><a href="?section=doctors" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Manage Doctors</span></a></li>
                        <li><a href="?section=patients" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Manage Patients</span></a></li>
                        <li><a href="?section=admin_manage_appointments" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Manage Appointments</span></a></li>
                        <li><a href="?section=account" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Account</span></a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION['user_type'] == 2): ?>
                        <li><a href="?section=patients" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Manage Patients</span></a></li>
                        <li><a href="?section=doctor_appointments" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>View Appointments</span></a></li>
                        <li><a href="?section=account" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Account</span></a></li>
                    <?php endif; ?>

                    <?php if ($_SESSION['user_type'] == 3): ?>
                        <li><a href="?section=my_appointments" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>My Appointments</span></a></li>
                        <li><a href="?section=book_appointment" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Book New Appointment</span></a></li>
                        <li><a href="?section=account" class="px-4 py-3 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out flex items-center space-x-2"><span>Account</span></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <main class="flex-1 p-8 overflow-auto bg-gray-50">
            <div class="container mx-auto max-w-7xl">
                <?php
                $section = $_GET['section'] ?? 'dashboard';

                if (isset($_SESSION['user_type'])) {
                    switch ($section) {
                        case 'doctors':
                            if ($_SESSION['user_type'] == 1) include 'core/admin_manage_doctors.php';
                            break;
                        case 'patients':
                            if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2) include 'core/admin_manage_patients.php';
                            break;
                        case 'admin_manage_appointments':
                            if ($_SESSION['user_type'] == 1) include 'core/admin_manage_appointments.php';
                            break;
                        case 'doctor_appointments':
                            if ($_SESSION['user_type'] == 2) include 'core/doctor_appointments.php';
                            break;
                        case 'update_status':
                            if ($_SESSION['user_type'] == 2) include 'core/update_status.php';
                            break;
                        case 'my_appointments':
                            if ($_SESSION['user_type'] == 3) include 'core/patient_appointments.php';
                            break;
                        case 'book_appointment':
                            if ($_SESSION['user_type'] == 3) include 'core/book_appointment.php';
                            break;
                        case 'account':
                            include 'core/account.php';
                            break;
                        default:
                            echo '<div class="bg-white rounded-lg shadow-md p-8">';
                            echo '<h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to the Dashboard</h2>';
                            echo '<p class="text-gray-600">Select an option from the sidebar to proceed.</p>';
                            echo '</div>';
                    }
                } else {
                    echo '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">';
                    echo '<p>Error: Session not initialized. Please log in.</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </main>
    </div>

    <footer class="bg-gray-900 text-gray-300 py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Hygeon Health. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>

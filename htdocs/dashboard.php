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
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">
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
            <a href="logout.php" class="text-sm bg-red-500 px-4 py-2 rounded hover:bg-red-600">Logout</a>
        </nav>
    </header>

    <!-- Sidebar & Content -->
    <div class="flex">
        <!-- Sidebar Menu -->
        <aside class="w-1/4 bg-gray-800 text-white p-6 h-screen">
            <ul class="space-y-4">
                <!-- Admin Menu -->
                <?php if ($_SESSION['user_type'] == 1): ?>
                    <li><a href="?section=doctors" class="block px-4 py-2 hover:bg-blue-600">Manage Doctors</a></li>
                    <li><a href="?section=patients" class="block px-4 py-2 hover:bg-blue-600">Manage Patients</a></li>
                    <li><a href="?section=admin_manage_appointments" class="block px-4 py-2 hover:bg-blue-600">Manage Appointments</a></li>
                    <li><a href="?section=account" class="block px-4 py-2 hover:bg-blue-600">Account</a></li>
                <?php endif; ?>

                <!-- Doctor Menu -->
                <?php if ($_SESSION['user_type'] == 2): ?>
                    <li><a href="?section=patients" class="block px-4 py-2 hover:bg-blue-600">Manage Patients</a></li> 
                    <li><a href="?section=doctor_appointments" class="block px-4 py-2 hover:bg-blue-600">View Appointments</a></li>
                    <li><a href="?section=account" class="block px-4 py-2 hover:bg-blue-600">Account</a></li>
                <?php endif; ?>

                <!-- Patient Menu -->
                <?php if ($_SESSION['user_type'] == 3): ?>
                    <li><a href="?section=my_appointments" class="block px-4 py-2 hover:bg-blue-600">My Appointments</a></li>
                    <li><a href="?section=book_appointment" class="block px-4 py-2 hover:bg-blue-600">Book New Appointment</a></li>
                    <li><a href="?section=account" class="block px-4 py-2 hover:bg-blue-600">Account</a></li>
                <?php endif; ?>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
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
                        echo '<h2 class="text-xl font-bold">Welcome to the Dashboard</h2>';
                        echo '<p>Select an option from the sidebar to proceed.</p>';
                }
            } else {
                echo '<p style="color:red;">Error: Session not initialized. Please log in.</p>';
            }
            ?>
        </main>
    </div>

    <footer class="bg-gray-800 text-white text-center p-4">
        <p>&copy; 2025 Hygeon Health. All Rights Reserved.</p>
    </footer>

</body>
</html>

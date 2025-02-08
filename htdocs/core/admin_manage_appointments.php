<?php
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display all errors (for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'connection.php'; // Include database connection

// Ensure the user is an admin
$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? 0;

if ($user_type !== 1) {
    die("<p class='text-red-500 text-center font-semibold'>Access Denied. Only admins can manage appointments.</p>");
}

// Fetch appointments (this is just a placeholder, replace with actual fetching logic)
$appointments = []; // Replace with actual fetching logic
$selected_type = 2; // Replace with actual logic to determine selected type
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Manage Appointments</h2>

    <!-- Step 1: Choose Type -->
    <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-700">Choose whom to manage:</h3>
        <div class="flex justify-center gap-4 mt-3">
            <button class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                onclick="loadUsers(2)">View Doctors</button>
            <button class="btn btn-primary bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition"
                onclick="loadUsers(3)">View Patients</button>
        </div>
    </div>

    <!-- Step 2: User List -->
    <div id="userList" class="hidden mt-6">
        <h3 id="userTypeTitle" class="text-xl font-semibold text-gray-800"></h3>
        <ul id="users" class="bg-gray-50 p-4 rounded-lg shadow"></ul>
    </div>

    <!-- Step 3: Appointments -->
    <div id="appointmentsSection" class="hidden mt-6">
        <h3 id="appointmentsTitle" class="text-xl font-semibold text-gray-800"></h3>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-3 border">Date</th>
                        <th class="px-4 py-3 border">Time</th>
                        <th class="px-4 py-3 border" id="nameColumn"></th>
                        <th class="px-4 py-3 border">Description</th>
                        <th class="px-4 py-3 border">Status</th>
                        <th class="px-4 py-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody id="appointments">
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                            <td class="border px-4 py-2">
                                <?= htmlspecialchars($selected_type == 2 ? $appointment['patient_name'] : $appointment['doctor_name']) ?>
                            </td>
                            <td class="border px-4 py-2"><?= htmlspecialchars($appointment['description']) ?></td>
                            <td class="border px-4 py-2" data-status="<?= $appointment['appointment_id'] ?>">
                                <?= htmlspecialchars(ucfirst($appointment['status'])) ?>
                            </td>
                            <td class="border px-4 py-2" data-action="<?= $appointment['appointment_id'] ?>">
                                <button onclick="updateAppointment(<?= $appointment['appointment_id'] ?>, 'approve')" 
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Approve</button>
                                <button onclick="updateAppointment(<?= $appointment['appointment_id'] ?>, 'reject')" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function loadUsers(userType) {
    $('#userList').removeClass('hidden');
    $('#userTypeTitle').text("Loading...");
    
    $.ajax({
        url: 'core/fetch_users.php',
        type: 'GET',
        data: { user_type: userType },
        success: function(response) {
            $('#users').html(response);
            $('#userTypeTitle').text(userType == 2 ? "Select a Doctor:" : "Select a Patient:");
        }
    });
}

function loadAppointments(userId, userType) {
    $('#appointmentsSection').removeClass('hidden');
    $('#appointmentsTitle').text("Loading...");

    $.ajax({
        url: 'core/fetch_appointments.php',
        type: 'GET',
        data: { user_id: userId, user_type: userType },
        success: function(response) {
            $('#appointments').html(response);
            $('#appointmentsTitle').text("Appointments for " + (userType == 2 ? "Doctor" : "Patient") + " ID: " + userId);
            $('#nameColumn').text(userType == 2 ? "Patient" : "Doctor");
        }
    });
}

function updateAppointment(appointmentId, action) {
    $.ajax({
        url: 'core/update_appointment.php',
        type: 'POST',
        data: { appointment_id: appointmentId, action: action },
        success: function(response) {
            let result = JSON.parse(response);
            if (result.success) {
                alert("Appointment successfully " + result.new_status);
                location.reload(); // Refresh to update status
            } else {
                alert("Error: " + result.message);
            }
        }
    });
}

</script>

</body>
</html>

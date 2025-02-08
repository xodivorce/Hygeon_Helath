<?php
include 'connection.php';

$user_id = $_GET['user_id'] ?? null;
$user_type = $_GET['user_type'] ?? null;

if (!$user_id || !in_array($user_type, [2, 3])) {
    echo "<tr><td colspan='6' style='color: red;'>Invalid request</td></tr>";
    exit;
}

// Fetch appointments based on user type
if ($user_type == 2) {
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.description, 
               u.user_name AS patient_name, a.status 
        FROM appointments a
        INNER JOIN user u ON a.patient_id = u.user_id
        WHERE a.doctor_id = ?
    ");
} else {
    $stmt = $pdo->prepare("
        SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.description, 
               d.user_name AS doctor_name, a.status 
        FROM appointments a
        INNER JOIN user d ON a.doctor_id = d.user_id
        WHERE a.patient_id = ?
    ");
}

$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$appointments) {
    echo "<tr><td colspan='6'>No appointments found.</td></tr>";
    exit;
}

foreach ($appointments as $appointment) {
    $appointment_id = $appointment['appointment_id'];
    $date = $appointment['appointment_date'];
    $time = $appointment['appointment_time'];
    $description = htmlspecialchars($appointment['description']);
    $status = ucfirst($appointment['status']);
    $other_person = ($user_type == 2) ? $appointment['patient_name'] : $appointment['doctor_name'];

    echo "<tr>
            <td>$date</td>
            <td>$time</td>
            <td>$other_person</td>
            <td>$description</td>
            <td>$status</td>
            <td>";

    // Admin Actions based on status
    if ($appointment['status'] === 'pending') {
        echo "<button class='btn btn-success' onclick='updateAppointment($appointment_id, \"approve\")'>Approve</button>
              <button class='btn btn-danger' onclick='updateAppointment($appointment_id, \"reject\")'>Reject</button>";
    } elseif ($appointment['status'] === 'approved') {
        echo "<button class='btn btn-danger' onclick='updateAppointment($appointment_id, \"reject\")'>Reject</button>";
    } elseif ($appointment['status'] === 'rejected') {
        echo "<button class='btn btn-success' onclick='updateAppointment($appointment_id, \"approve\")'>Re-Approve</button>";
    } else {
        echo "<span>No Actions</span>";
    }

    echo "</td></tr>";
}
?>

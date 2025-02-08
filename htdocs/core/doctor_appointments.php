<?php
// Ensure session is started only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display all errors (for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'connection.php';  // Include database connection

// Ensure the user is a doctor (user_type = 2)
$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? 0;

if ($user_type != 2) {
    die("<p style='color:red;'>Access Denied. Only doctors can manage appointments.</p>");
}

// Fetch appointments for the logged-in doctor
$stmt = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.description, 
           u.user_name AS patient_name, a.status 
    FROM appointments a
    INNER JOIN user u ON a.patient_id = u.user_id  -- Correct column name
    WHERE a.doctor_id = ?  -- Only fetch appointments for the logged-in doctor
    ORDER BY a.appointment_date DESC, a.appointment_time ASC
");

$stmt->execute([$user_id]);

$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update appointment status if requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'], $_POST['action'])) {
    $appointment_id = $_POST['appointment_id'];
    $action = $_POST['action']; // 'approve' or 'reject'

    if (in_array($action, ['approve', 'reject'])) {
        $status = ($action === 'approve') ? 'approved' : 'rejected';

        // Ensure only the assigned doctor can update their own appointments
        $updateStmt = $pdo->prepare("
            UPDATE appointments 
            SET status = ? 
            WHERE appointment_id = ? AND doctor_id = ?
        ");
        $success = $updateStmt->execute([$status, $appointment_id, $user_id]);

        if ($success) {
            echo "<p style='color:green;'>Appointment successfully {$status}.</p>";
        } else {
            echo "<p style='color:red;'>Error updating appointment status.</p>";
        }
    } else {
        echo "<p style='color:red;'>Invalid action.</p>";
    }
}
?>

<h2 class="text-xl font-bold mb-4">Manage Appointments</h2>

<?php if (count($appointments) > 0): ?>
    <table class="table-auto w-full bg-white shadow-md rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">Patient</th>
                <th class="px-4 py-2">Description</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td class="border px-4 py-2"><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($appointment['appointment_time']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($appointment['patient_name']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($appointment['description']) ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars(ucfirst($appointment['status'])) ?></td>
                    <td class="border px-4 py-2">
                        <?php if ($appointment['status'] === 'pending'): ?>
                            <form method="POST" class="inline">
                                <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                                <button type="submit" name="action" value="approve" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Approve
                                </button>
                                <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Reject
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-gray-500">No Actions</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-gray-500">No appointments found.</p>
<?php endif; ?>

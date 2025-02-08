<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

include_once 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 3) {
    die("<p style='color:red;'>Access Denied. Only patients can view appointments.</p>");
}

$patient_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT a.appointment_id, a.appointment_date, a.appointment_time, a.description, 
           a.status, u.user_name AS doctor_name 
    FROM appointments a
    INNER JOIN user u ON a.doctor_id = u.user_id
    WHERE a.patient_id = ?
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt->execute([$patient_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-xl font-bold mb-4">My Appointments</h2>

<?php if (count($appointments) === 0): ?>
    <p class="text-gray-500">No appointments booked yet.</p>
<?php else: ?>
    <table class="min-w-full bg-white shadow-md rounded">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="py-2 px-4">Doctor</th>
                <th class="py-2 px-4">Date</th>
                <th class="py-2 px-4">Time</th>
                <th class="py-2 px-4">Description</th>
                <th class="py-2 px-4">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $row): ?>
                <tr class="border-b">
                    <td class="py-2 px-4"><?= htmlspecialchars($row['doctor_name']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($row['appointment_date']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($row['appointment_time']) ?></td>
                    <td class="py-2 px-4"><?= htmlspecialchars($row['description']) ?></td>
                    <td class="py-2 px-4 font-bold">
                        <?php 
                            switch ($row['status']) {
                                case 'pending':
                                    echo "<span class='text-yellow-500'>Pending</span>";
                                    break;
                                case 'approved':
                                    echo "<span class='text-green-500'>Approved</span>";
                                    break;
                                case 'rejected':
                                    echo "<span class='text-red-500'>Rejected</span>";
                                    break;
                                default:
                                    echo "<span class='text-gray-500'>Unknown</span>";
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

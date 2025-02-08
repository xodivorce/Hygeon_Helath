<?php
include 'connection.php';

$appointment_id = $_POST['appointment_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($appointment_id && in_array($action, ['approve', 'reject'])) {
    $new_status = ($action === 'approve') ? 'approved' : 'rejected';

    // Update appointment status
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt->execute([$new_status, $appointment_id]);

    echo json_encode(["success" => true, "new_status" => ucfirst($new_status)]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>

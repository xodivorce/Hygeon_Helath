<?php
include 'connection.php';

$user_type = $_GET['user_type'] ?? null;

if ($user_type && in_array($user_type, [2, 3])) {
    $stmt = $pdo->prepare("SELECT user_id, user_name FROM user WHERE user_type = ?");
    $stmt->execute([$user_type]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo "<li><a href='#' onclick='loadAppointments({$user['user_id']}, {$user_type})'>{$user['user_name']}</a></li>";
    }
}
?>

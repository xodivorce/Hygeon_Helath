<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(["message" => "Access Denied."]);
    exit;
}

// Capture billing details from POST request
$full_name = $_POST['full_name'] ?? '';
$address = $_POST['address'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip_code = $_POST['zip_code'] ?? '';
$country = $_POST['country'] ?? '';

// Check if billing info exists
$stmt = $pdo->prepare("SELECT * FROM billing WHERE user_id = ?");
$stmt->execute([$user_id]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    // Update existing billing info
    $update_stmt = $pdo->prepare("
        UPDATE billing SET full_name=?, address=?, city=?, state=?, zip_code=?, country=?
        WHERE user_id=?
    ");
    $update_stmt->execute([$full_name, $address, $city, $state, $zip_code, $country, $user_id]);
    echo json_encode(["message" => "Billing information updated successfully."]);
} else {
    // Insert new billing info
    $insert_stmt = $pdo->prepare("
        INSERT INTO billing (user_id, full_name, address, city, state, zip_code, country)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $insert_stmt->execute([$user_id, $full_name, $address, $city, $state, $zip_code, $country]);
    echo json_encode(["message" => "Billing information added successfully."]);
}
?>

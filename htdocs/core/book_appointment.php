<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

include_once 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 3) {
    die("<p style='color:red;'>Access Denied. Only patients can book appointments.</p>");
}

$patient_id = $_SESSION['user_id'];

// Ensure database connection exists
if (!isset($pdo)) {
    die("<p style='color:red;'>Database connection not established.</p>");
}

// Fetch available doctors with their categories
$stmt = $pdo->prepare("SELECT user_id, user_name, doctor_category FROM user WHERE user_type = 2");
$stmt->execute();
$doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $description = trim($_POST['description']);

    if (empty($doctor_id) || empty($appointment_date) || empty($appointment_time) || empty($description)) {
        echo "<p style='color:red;'>All fields are required.</p>";
    } else {
        // Convert time format from "hh:mm AM/PM" to "HH:MM:SS"
        $timeObject = DateTime::createFromFormat('h:i A', $appointment_time);
        if ($timeObject) {
            $formatted_time = $timeObject->format('H:i:s'); // Convert to "HH:MM:SS"
        } else {
            echo "<p style='color:red;'>Invalid time format selected.</p>";
            exit;
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, description, status) 
                               VALUES (?, ?, ?, ?, ?, 'pending')");
        if ($stmt->execute([$patient_id, $doctor_id, $appointment_date, $formatted_time, $description])) {
            echo "<p style='color:green;'>Appointment booked successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error booking appointment.</p>";
        }
    }
}
?>

<h2 class="text-xl font-bold mb-4">Book an Appointment</h2>

<form method="POST" class="bg-white p-6 shadow-md rounded">
    <label class="block mb-2">Select Doctor:</label>
    <select name="doctor_id" required class="block w-full p-2 border rounded">
        <option value="">-- Select Doctor --</option>
        <?php foreach ($doctors as $row): ?>
            <option value="<?= $row['user_id'] ?>">
                <?= htmlspecialchars($row['user_name']) ?> (<?= htmlspecialchars($row['doctor_category']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <label class="block mt-4 mb-2">Select Date:</label>
    <input type="date" name="appointment_date" required class="block w-full p-2 border rounded">

    <label class="block mt-4 mb-2">Select Time:</label>
    <select name="appointment_time" required class="block w-full p-2 border rounded">
        <option value="">-- Select Time Slot --</option>
        <option value="09:00 AM">09:00 AM</option>
        <option value="09:30 AM">09:30 AM</option>
        <option value="10:00 AM">10:00 AM</option>
        <option value="10:30 AM">10:30 AM</option>
        <option value="11:00 AM">11:00 AM</option>
        <option value="11:30 AM">11:30 AM</option>
        <option value="02:00 PM">02:00 PM</option>
        <option value="02:30 PM">02:30 PM</option>
        <option value="03:00 PM">03:00 PM</option>
        <option value="03:30 PM">03:30 PM</option>
        <option value="04:00 PM">04:00 PM</option>
        <option value="04:30 PM">04:30 PM</option>
    </select>

    <label class="block mt-4 mb-2">Describe Your Issue:</label>
    <textarea name="description" required class="block w-full p-2 border rounded" placeholder="Describe your symptoms or reason for the appointment"></textarea>

    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Book Appointment</button>
</form>

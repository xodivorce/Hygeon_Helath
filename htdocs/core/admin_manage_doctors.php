<?php
// Include database connection
include_once 'core/connection.php';

// Initialize message variables for feedback
$message = '';
$messageClass = '';

// Handle adding a new doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_doctor'])) {
    $user_email = $_POST['user_email'];

    // Check if the user exists and is not already a doctor
    $stmt = $pdo->prepare("SELECT user_id, user_type FROM user WHERE user_email = :user_email");
    $stmt->bindParam(':user_email', $user_email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        if ($user['user_type'] == 2) {
            // The user is already a doctor
            $message = "This user is already a doctor!";
            $messageClass = 'bg-yellow-100 text-yellow-600';
        } else if ($user['user_type'] == 3) {
            // The user is a patient, so promote to doctor
            $stmt = $pdo->prepare("UPDATE user SET user_type = 2 WHERE user_email = :user_email");
            $stmt->bindParam(':user_email', $user_email);
            $stmt->execute();

            $message = "Doctor added successfully!";
            $messageClass = 'bg-green-100 text-green-600';
        }
    } else {
        $message = "No user found with this email!";
        $messageClass = 'bg-red-100 text-red-600';
    }
}

// Handle removing a doctor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_doctor'])) {
    $user_email = $_POST['user_email'];

    // Check if user exists and is a doctor
    $stmt = $pdo->prepare("SELECT user_id FROM user WHERE user_email = :user_email AND user_type = 2");
    $stmt->bindParam(':user_email', $user_email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User is a doctor, update their user_type to 3 (Patient)
        $stmt = $pdo->prepare("UPDATE user SET user_type = 3 WHERE user_email = :user_email");
        $stmt->bindParam(':user_email', $user_email);
        $stmt->execute();

        $message = "Doctor removed successfully!";
        $messageClass = 'bg-red-100 text-red-600';
    } else {
        $message = "No doctor found with this email!";
        $messageClass = 'bg-red-100 text-red-600';
    }
}

// Fetch all doctors
$stmt = $pdo->prepare("SELECT user_id, user_name, user_email FROM user WHERE user_type = 2");
$stmt->execute();
$doctors = $stmt->fetchAll();
?>

<div class="space-y-6 p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-blue-600 mb-4">Manage Doctors</h2>

    <!-- Display Messages -->
    <?php if ($message): ?>
        <div class="p-4 <?php echo $messageClass; ?> rounded-lg">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Add Doctor Form -->
    <form action="" method="POST" class="space-y-4 bg-gray-50 p-6 rounded-lg shadow-sm">
        <div class="flex items-center space-x-4">
            <label for="user_email" class="w-1/4 text-gray-700 font-medium">Enter Patient Email to Add as Doctor:</label>
            <input type="email" id="user_email" name="user_email" class="w-2/4 px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <button type="submit" name="add_doctor" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Doctor</button>
    </form>

    <!-- Remove Doctor Form -->
    <form action="" method="POST" class="space-y-4 bg-gray-50 p-6 rounded-lg shadow-sm">
        <div class="flex items-center space-x-4">
            <label for="user_email_remove" class="w-1/4 text-gray-700 font-medium">Enter Doctor Email to Remove:</label>
            <input type="email" id="user_email_remove" name="user_email" class="w-2/4 px-4 py-2 border border-gray-300 rounded-lg" required>
        </div>
        <button type="submit" name="remove_doctor" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Remove Doctor</button>
    </form>

    <!-- List of Doctors -->
    <h3 class="text-xl font-semibold text-gray-800 mt-8">Existing Doctors:</h3>
    <div class="overflow-x-auto mt-4 bg-gray-50 rounded-lg shadow-sm">
        <table class="min-w-full table-auto border-collapse text-left">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="px-4 py-2 border text-sm">Name</th>
                    <th class="px-4 py-2 border text-sm">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doctors as $doctor): ?>
                <tr class="border-b">
                    <td class="px-4 py-2"><?php echo htmlspecialchars($doctor['user_name']); ?></td>
                    <td class="px-4 py-2"><?php echo htmlspecialchars($doctor['user_email']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

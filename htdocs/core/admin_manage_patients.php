<?php
// Check if session is already started, avoid calling session_start() multiple times
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 0);
error_reporting(E_ALL);

include 'connection.php';  // Include the database connection

// Ensure the user is an admin (type 1) or doctor (type 2)
$user_type = $_SESSION['user_type'] ?? 0;
if ($user_type != 1 && $user_type != 2) {
    header('Location: login.php');
    exit();
}

// Handle Ban/Unban action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['patient_id'], $_POST['action'])) {
    $patient_id = $_POST['patient_id'];
    $action = $_POST['action'];

    // Prepare the query based on the action
    $stmt = null;
    if ($action === 'ban') {
        $stmt = $pdo->prepare("UPDATE user SET user_type = 4 WHERE user_id = :patient_id");
        $message = "The patient is banned successfully.";
        $message_type = "success";
    } elseif ($action === 'unban') {
        $stmt = $pdo->prepare("UPDATE user SET user_type = 3 WHERE user_id = :patient_id");
        $message = "The patient is unbanned successfully.";
        $message_type = "success";
    } else {
        $_SESSION['message'] = "Invalid action.";
        $_SESSION['message_type'] = "error";
        header('Location: dashboard.php?section=patients');
        exit();
    }

    $stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);

    // Execute the query and handle success/failure
    if ($stmt->execute()) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $message_type;
    } else {
        $_SESSION['message'] = "An error occurred while updating the patient status.";
        $_SESSION['message_type'] = "error";
    }

    // Redirect to the same page
    header('Location: dashboard.php?section=patients');
    exit();
}

// Fetch the list of patients
$stmt = $pdo->prepare("SELECT user_id, user_email, user_name, user_type FROM user WHERE user_type IN (3, 4)");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Manage Patients</h2>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="mb-4 px-4 py-2 text-white <?= $_SESSION['message_type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?> rounded">
            <?= htmlspecialchars($_SESSION['message']) ?>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2 text-left">Name</th>
                <th class="border px-4 py-2 text-left">Email</th>
                <th class="border px-4 py-2 text-center">Status</th>
                <th class="border px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($patients)): ?>
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">No patients found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($patients as $patient): ?>
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2"><?= htmlspecialchars($patient['user_name'] ?? 'N/A') ?></td>
                    <td class="border px-4 py-2"><?= htmlspecialchars($patient['user_email'] ?? 'N/A') ?></td>
                    <td class="border px-4 py-2 text-center">
                        <span class="<?= $patient['user_type'] == 4 ? 'text-red-600' : 'text-green-600' ?>">
                            <?= $patient['user_type'] == 4 ? 'Banned' : 'Active' ?>
                        </span>
                    </td>
                    <td class="border px-4 py-2 text-center">
                        <!-- Ban or Unban action -->
                        <form action="dashboard.php?section=patients" method="POST">
                            <input type="hidden" name="patient_id" value="<?= $patient['user_id'] ?>">
                            <input type="hidden" name="action" value="<?= $patient['user_type'] == 4 ? 'unban' : 'ban' ?>">
                            <button type="submit" class="bg-<?= $patient['user_type'] == 4 ? 'green' : 'red' ?>-500 text-white px-4 py-2 rounded hover:bg-<?= $patient['user_type'] == 4 ? 'green' : 'red' ?>-600">
                                <?= $patient['user_type'] == 4 ? 'Unban' : 'Ban' ?>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

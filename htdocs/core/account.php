<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php'; // Ensure this path is correct

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "<p style='color:red;'>Error: User not logged in.</p>";
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_email'])) {
        $new_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($new_email) {
            $stmt = $pdo->prepare("UPDATE user SET user_email = ? WHERE user_id = ?");
            $stmt->execute([$new_email, $user_id]);
            $message = "Email updated successfully!";
        } else {
            $message = "Invalid email address!";
        }
    }

    if (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch current password
        $stmt = $pdo->prepare("SELECT user_pass FROM user WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current_password, $user['user_pass'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("UPDATE user SET user_pass = ? WHERE user_id = ?");
                $stmt->execute([$hashed_password, $user_id]);
                $message = "Password updated successfully!";
            } else {
                $message = "New passwords do not match!";
            }
        } else {
            $message = "Incorrect current password!";
        }
    }
}
?>

<h2 class="text-xl font-bold mb-4">Account Settings</h2>

<?php if ($message): ?>
    <p class="text-center text-red-500"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<!-- Tabs -->
<div class="flex mb-4">
    <button onclick="showSection('update-email')" class="px-4 py-2 bg-blue-600 text-white mr-2">Update Email</button>
    <button onclick="showSection('update-password')" class="px-4 py-2 bg-blue-600 text-white">Update Password</button>
</div>

<!-- Update Email Section -->
<div id="update-email" class="hidden">
    <h3 class="text-lg font-bold mb-2">Update Email</h3>
    <form method="POST">
        <label class="block mb-2">New Email</label>
        <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded mb-4" required>
        <button type="submit" name="update_email" class="px-4 py-2 bg-green-500 text-white">Update Email</button>
    </form>
</div>

<!-- Update Password Section -->
<div id="update-password" class="hidden">
    <h3 class="text-lg font-bold mb-2">Update Password</h3>
    <form method="POST">
        <label class="block mb-2">Current Password</label>
        <input type="password" name="current_password" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block mb-2">New Password</label>
        <input type="password" name="new_password" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <label class="block mb-2">Confirm New Password</label>
        <input type="password" name="confirm_password" class="w-full p-2 border border-gray-300 rounded mb-4" required>

        <button type="submit" name="update_password" class="px-4 py-2 bg-green-500 text-white">Update Password</button>
    </form>
</div>

<script>
function showSection(sectionId) {
    document.getElementById('update-email').classList.add('hidden');
    document.getElementById('update-password').classList.add('hidden');
    document.getElementById(sectionId).classList.remove('hidden');
}
</script>

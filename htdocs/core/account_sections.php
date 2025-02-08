<?php
$section = $_GET['section'] ?? '';

if ($section === 'billing') {
    echo '<h3 class="text-lg font-bold">Billing Information</h3><p>Billing details will be displayed here.</p>';
} elseif ($section === 'update_password') {
    echo '<h3 class="text-lg font-bold">Update Password</h3>
          <form>
              <label>Current Password</label>
              <input type="password" class="w-full p-2 border rounded mb-2">
              <label>New Password</label>
              <input type="password" class="w-full p-2 border rounded mb-2">
              <button class="bg-green-500 text-white px-4 py-2 rounded">Update Password</button>
          </form>';
} elseif ($section === 'update_email') {
    echo '<h3 class="text-lg font-bold">Update Email</h3>
          <form>
              <label>New Email</label>
              <input type="email" class="w-full p-2 border rounded mb-2">
              <button class="bg-green-500 text-white px-4 py-2 rounded">Update Email</button>
          </form>';
} else {
    echo '<p>Invalid selection.</p>';
}
?>

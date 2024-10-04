<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/forgot_pass.css">
</head>
<body>
<div class="container">
    <!-- Left Section (Image and Logo) -->
    <div class="left-section">
        <div class="header">
            <img src="assets/images/hygeon_heath.svg" alt="Hygeon Heath Logo" class="logo">
            <button class="back-button" onclick="window.location.href='login.php';">Back to Login &rarr;</button>
        </div>
        <div class="content">
            <img id="background-image" src="assets/images/dna.jpg" alt="Background Image" class="background-img">
            <h2>Limited Angles but,<br>One Life at a Time</h2>
        </div>
    </div>

    <!-- Right Section (Create Password Form) -->
    <div class="right-section">
        <div class="form-container">
            <h2>Create a New Password</h2>
            <p>Please choose a password that hasn't been used before. Must be at least 8 characters.</p>

            <!-- Validation message container -->
            <p id="validation-message" class="error-message" style="display:none;"></p>

            <form action="submit">
                <input type="password" placeholder="Set new password" class="input-field full-width" id="newPassword" required minlength="8">
                
                <!-- Confirm password field is always visible -->
                <input type="text" placeholder="Confirm new password" class="input-field full-width" id="confirmPassword" required minlength="8">
                
                <button type="button" class="submit-button" onclick="resetPassword()">Reset Password</button>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/forgot_pass.js"></script>
</body>
</html>

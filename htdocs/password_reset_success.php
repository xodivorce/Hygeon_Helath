<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Password Reset Success</title>
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

    <!-- Right Section (Success Message) -->
    <div class="right-section">
        <div class="form-container">
            <h2>Password Reset!</h2>
            <p>
                 Your password has been successfully reset. 
                 We understand that keeping your account secure is important, 
                 and we're here to help you every step of the way. 
                 You can now log in using your new password. 
                 If you have any questions or need further assistance, 
                 feel free to reach out to our support team at 
                 <a href="mailto:hey@hygeonhealth.in" class="support-email">hey@hygeonhealth.in</a>. 
                 Click the button below to log in and access your account.
                </p>

            <button class="submit-button" onclick="window.location.href='login.php';">Continue</button>
        </div>
    </div>
</div>

<script src="assets/js/forgot_pass.js"></script>
</body>
</html>

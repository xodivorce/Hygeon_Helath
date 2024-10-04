<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Enter Confirmation Code</title>
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

    <!-- Right Section (Form) -->
    <div class="right-section">
        <div class="form-container">
            <h2>Enter Confirmation Code</h2>
            <p>We sent a code to <strong id="userEmail"></strong></p>
            <form id="codeForm" action="submit" method="post">
                <!-- Input type set to 'tel' for numeric keyboard, with pattern for validation -->
                 <input type="tel" pattern="[0-9]*" inputmode="numeric" placeholder="Enter 4-digit code" class="input-field full-width" maxlength="4" required>
                 <button type="button" class="submit-button" onclick="location.href='forgot_pass_step_three.php'">Continue</button>
                </form>

            <div class="resend-code">
                <p>Didn't receive the email? <a href="#" onclick="resendCode()">Click to resend</a></p>
            </div>
            <!-- Success message container -->
            <div id="success-message" class="success-message"></div>
        </div>
    </div>
</div>

<script src="assets/js/forgot_pass.js"></script>
<script src="assets/js/email.js"></script>
</body>
</html>



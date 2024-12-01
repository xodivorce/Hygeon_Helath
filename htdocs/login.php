<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <!-- Left Section (Image and Logo) -->
        <div class="left-section">
            <div class="header">
                <img src="assets/images/hygeon_heath.svg" alt="Hygeon Health Logo" class="logo">
                <button class="back-button" onclick="window.location.href='home.php';">Back to website &rarr;</button>
            </div>
            <div class="content">
                <img id="background-image" src="assets/images/dna.jpg" alt="Background Image" class="background-img">
                <h2>Unlocking Saviors,<br>One Life at a Time</h2>
            </div>
        </div>

        <!-- Right Section (Form) -->
        <div class="right-section">
            <div class="form-container">
                <h2>Login to your account</h2>
                <p>Don't have an account? <a href="register.php">Register</a></p>
                <form action="./core/login_action.php" method="post">
                    <input type="email" placeholder="Email" class="input-field full-width" name="user_email" required>

                    <!-- Password field with eye icon -->
                    <div class="input-container">
                        <input type="password" placeholder="Enter your password" class="input-field full-width" id="password-field" name="user_pass" required>
                        <img src="assets/images/eye.svg" alt="Show Password" class="eye-icon" id="toggle-password">
                    </div>
                 <!-- Displaying error messages -->
                <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div style='color: red; font-size: 14px; margin-top: -20px; margin-bottom: 3px;'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }
                ?>


                    <!-- Remember Me Checkbox, Forgot Password link, and Beta Notice -->
                    <div class="checkbox-forgot-container">
                        <div class="checkbox-container">
                            <input type="checkbox" id="remember-me" class="custom-checkbox">
                            <label for="remember-me">Remember me for 30 days.</label>
                        </div>
                        <a href="forgot_pass_step_one.php" class="forgot-password-link">Forgot password?</a>
                    </div>
                    

                    <!-- Beta Notice -->
                    <p class="beta-notice">
                        This is a beta functionality. Please note that there are potential security concerns related to leaving your account logged in for long periods of time; especially when using an insecure, shared, or public device.
                    </p>

                    <button type="submit" class="submit-button" name="login_btn">Login</button>
                </form>

                <div class="divider">Or login with</div>

                <div class="social-login">
                    <button class="google-btn"> <img src="assets/images/google.png" alt="Google Logo"> Google</button>
                    <button class="apple-btn"> <img src="assets/images/apple.png" alt="Apple Logo"> Apple</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/login.js"></script>
</body>
</html>

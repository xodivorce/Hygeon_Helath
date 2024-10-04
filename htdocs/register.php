<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="container">
        <!-- Left Section (Image and Logo) -->
        <div class="left-section">
            <div class="header">
                <img src="assets/images/hygeon_heath.svg" alt="Hygeon_heath Logo" class="logo">
                <button class="back-button" onclick="window.location.href='home.php';">Back to website &rarr;</button>
            </div>
            <div class="content">
            <img id="background-image" src="assets/images/dna.jpg" alt="Background Image" class="background-img">
                <h2>Capturing Moments,<br>One Life at a Time</h2>
            </div>
        </div>

        <!-- Right Section (Form) -->
        <div class="right-section">
            <div class="form-container">
                <h2>Create an account</h2>
                <p>Already have an account? <a href="login.php">Log in</a></p>
                
                <form action="submit">
                    <div class="input-container">
                        <input type="text" placeholder="First name" class="input-field">
                        <input type="text" placeholder="Last name" class="input-field">
                    </div>
                    <input type="email" placeholder="Email" class="input-field full-width">
                    
                    <!-- Password field with eye icon -->
                    <div class="input-container">
                        <input type="password" placeholder="Enter your password" class="input-field full-width" id="password-field">
                        <img src="assets/images/eye.svg" alt="Show Password" class="eye-icon" id="toggle-password">
                    </div>
                    
                    <div class="checkbox-container">
                        <input type="checkbox" id="agree" class="custom-checkbox">
                        <label for="agree">I agree to the <a href="#" class="terms-link">Terms & Conditions</a></label>
                    </div>


                    <button type="submit" class="submit-button">Create account</button>
                </form>

                <div class="divider">Or register with</div>

                <div class="social-login">
                    <button class="google-btn"> <img src="assets/images/google.png" alt="Google Logo"> Google</button>
                    <button class="apple-btn"> <img src="assets/images/apple.png" alt="Apple Logo"> Apple</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/register.js"></script>
</body>
</html>

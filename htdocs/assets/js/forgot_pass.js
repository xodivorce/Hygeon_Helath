// Array of background image sources
const images = ['assets/images/dna.jpg', 'assets/images/dna2.jpg', 'assets/images/dna3.jpg', 'assets/images/dna4.jpg'];
let currentIndex = 0;

function changeBackgroundImage() {
    const imgElement = document.getElementById('background-image');
    // Fade out
    imgElement.style.opacity = 0;

    setTimeout(() => {
        // Change image source
        currentIndex = (currentIndex + 1) % images.length;
        imgElement.src = images[currentIndex];

        // Fade in
        imgElement.style.opacity = 1;
    }, 800); // Match this timeout with the CSS transition duration
}

// Change image every 5 seconds
setInterval(changeBackgroundImage, 5000);



// Password visibility toggle logic
const passwordField = document.getElementById('password-field');
const togglePassword = document.getElementById('toggle-password');

togglePassword.addEventListener('click', function () {
    // Toggle between 'password' and 'text'
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    // Optionally toggle the eye icon image (if different images are needed)
    this.src = type === 'password' ? 'assets/images/eye.svg' : 'assets/images/eye-off.svg';
});

// Password Reset Function
function togglePasswordVisibility() {
    const confirmPasswordInput = document.getElementById('confirmPassword');
    if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text'; // Show password
    } else {
        confirmPasswordInput.type = 'password'; // Hide password
    }
}
// Conform Password Seen Function
function resetPassword() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const validationMessage = document.getElementById('validation-message');

    if (newPassword.length < 8) {
        showMessage('Password must be at least 8 characters long.', '#FF0000'); // Red color for error
        return;
    }

    if (newPassword !== confirmPassword) {
        showMessage('Passwords do not match. Please try again.', '#FF0000'); // Red color for error
        return;
    }

    // Redirect or submit form after validation
    location.href = 'password_reset_success.php'; // Change this to your success page
}

function showMessage(message, color) {
    const validationMessage = document.getElementById('validation-message');
    validationMessage.textContent = message;
    validationMessage.style.color = color;
    validationMessage.style.display = 'block';

    // Hide the message after 5 seconds (5000ms)
    setTimeout(function() {
        validationMessage.style.display = 'none';
    }, 5000);
}
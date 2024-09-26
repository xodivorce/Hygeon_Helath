// script.js

// Add any form validation or interactivity here, like checking if the fields are filled
document.querySelector("form").addEventListener("submit", function(event) {
    const inputs = document.querySelectorAll(".input-field");
    let valid = true;
    
    inputs.forEach(input => {
        if (input.value === "") {
            valid = false;
            input.style.borderColor = "red";
        } else {
            input.style.borderColor = "#555";
        }
    });

    if (!valid) {
        event.preventDefault(); // Prevent form submission if validation fails
        alert("Please fill all the fields.");
    }
});


document.getElementById('toggle-password').addEventListener('click', function () {
    const passwordField = document.getElementById('password-field');
    const passwordType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', passwordType);

    // Optionally, you can change the eye icon to an "eye-off" icon when the password is visible
    this.src = passwordType === 'password' ? 'assets/images/eye.svg' : 'assets/images/eye-off.svg';
});

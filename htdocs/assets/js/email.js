function storeEmailAndContinue() {
    // Get the email entered by the user
    var email = document.getElementById('email').value;
    
    // Store the email in sessionStorage
    sessionStorage.setItem('userEmail', email);
    
    // Redirect to the next step
    location.href = 'forgot_pass_step_two.php';
}

    // Retrieve the email from sessionStorage and display it
    document.getElementById('userEmail').textContent = sessionStorage.getItem('userEmail') || 'hygeonhealth@example.com';

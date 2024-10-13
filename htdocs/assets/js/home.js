// JavaScript to toggle menu visibility and hide the logo on small screens
const toggleButton = document.querySelector('.toggle');
const menu = document.querySelector('.menu');
const logo = document.querySelector('.logo');

toggleButton.addEventListener('click', () => {
  menu.classList.toggle('active'); // Toggle the menu visibility
  toggleButton.classList.toggle('active'); // Toggle the button's active state
  
  // Check if screen width is less than or equal to 430px
  if (window.innerWidth <= 430) {
    if (menu.classList.contains('active')) {
      logo.style.display = "none"; // Hide the logo when menu is active
    } else {
      logo.style.display = "block"; // Show the logo when menu is closed
    }
  }
});

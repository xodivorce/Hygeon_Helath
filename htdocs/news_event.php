<?php
header("Content-Type: text/html; charset=UTF-8");
error_reporting(E_ALL);
ini_set('display_errors', 1); // Turn on error reporting for troubleshooting
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title> 
    <link rel="stylesheet" href="./assets/css/event.css"> 
    <link rel="stylesheet" href="./assets/css/menu.css">
</head>
<body>
<header>
        <div class="toggle"></div>
    </header>
<?php include 'assets/menu.php'; ?> <!-- Including menu.php -->

    <main>
        <section id="hero" class="section">
            <div class="container">
                <h1>Explore Our Exciting Events</h1>
                <p>Explore the mundane occurrences at Xodivorce Educational Institute, where excitement goes to die. Our events are so thrilling that you'll forget what boredom even feels like.</p>
            </div>
        </section>
        <section id="featured-events" class="section">
            <div class="container">
                <h2>Featured Events</h2>
                <div class="event-grid">
                    <div class="event-card">
                        <img src="assets/images/university.png" alt="Event Title 1"> 
                        <h3>Xodivorce Open Campus Experience: Explore, Learn, Grow</h3>
                        <p class="date">October 13, 2023</p>
                        <p class="description">We're excited to invite applications for the Open Campus programme at Xodivorce Educational Institute. Our doors are open to individuals from diverse backgrounds and interests, offering a range of flexible learning options to suit your needs. With experienced faculty, top-notch facilities, and a vibrant campus atmosphere, Xodivorce provides an enriching educational experience like no other. Don't miss this opportunity to shape your future with us. Apply now and embark on a journey of growth and achievement.</p>
                        <button class="btn-secondary" onclick="window.location.href='singin-up.php'">Learn More</button>
                    </div>
                    <div class="event-card">
                        <img src="assets/images/chares.png" alt="College Fest"> 
                        <h3>Xodivorce Educational Institute'sFest 2024: Celebrate the Spirit of Youth</h3>
                        <p class="date">January 19-21, 2024</p>
                        <p class="description">Join us for the most awaited event of the year - Xodivorce College Fest 2024! Get ready for three days of non-stop fun, excitement, and entertainment. Experience thrilling performances, engaging competitions, mouth-watering food stalls, and much more. It's the perfect opportunity to unleash your talents, make new friends, and create unforgettable memories. Only students with College-id can be attend the "XEI Fest 2024" . Don't miss out on the excitement - mark your calendars now!</p>
                        <button class="btn-secondary" onclick="window.location.href='singin-up.php'">Learn More</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script type="text/javascript" src="./assets/js/menu.js"></script>
</body>
</html>

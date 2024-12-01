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
    <title>About Us</title>
    <link rel="stylesheet" href="./assets/css/about-us.css">
    <link rel="stylesheet" href="./assets/css/responce.css">
    <link rel="stylesheet" href="./assets/css/menu.css">
</head>
<body>

    <div class="responsive-container-block bigContainer">

    <div class="toggle"></div>
    <?php include 'assets/menu.php'; ?> <!-- Including menu.php -->

        <div class="responsive-container-block Container">
            <div class="responsive-container-block leftSide">
                <p class="text-blk heading">Meet Our Creative Team</p>
                <p class="text-blk subHeading">
                    Established in 2006, Xodivorce Educational Institute embodies British educational excellence. Founded by Prasid Mandal and co-founded by Soumen Das, we prioritize dynamic learning environments. Through innovative methods, we empower students academically and personally.
                </p>
                <p>
                    Join us on Instagram to connect with our founders (<a href="https://www.instagram.com/the_prasid" target="_blank">@the_prasid</a> and <a href="https://www.instagram.com/xodivorce" target="_blank">@xodivorce</a>) and be part of our journey towards shaping the future of education. For feedback or to be part of our journey, reach out to us via email at <a href="mailto:prasidmandal79@gmail.com">prasidmandal79@gmail.com</a>.
                    Embrace growth, exploration, and academic achievement with us.
                </p>
                <button class="btn-secondary" onclick="window.location.href='event.php'">Learn More</button>
            </div>
            <div class="responsive-container-block rightSide">
                <img class="number1img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/ET32.jpg" onclick="window.location.href='event.php'">
                <img class="number2img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/d14.png" onclick="window.location.href='event.php'">
                <img class="number3img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/b245.png" onclick="window.location.href='event.php'">
                <img class="number5img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Customer supports.png" onclick="window.location.href='event.php'">
                <iframe allowfullscreen="allowfullscreen" class="number4vid" src="https://www.youtube.com/embed/PIiikVJV5GM?si=V1y4wGUUL_gyY0C_"></iframe>
                <img class="number7img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/d51.png" onclick="window.location.href='event.php'">
                <img class="number6img" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/d12.png" onclick="window.location.href='event.php'">
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./assets/js/menu.js"></script>
</body>
</html>

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
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/menu.css">
    <title>Hygeon Heath</title>
</head>
<body>
    <header>
        <img src="assets/images/hygeon_heath.svg" alt="Hygeon_heath Logo" class="logo">
        <div class="toggle" style="margin-top: -10px;">
        </div>
    </header>

    <?php include 'assets/menu.php'; ?> <!-- Including menu.php -->

    <section class="showcase">
        <video src="assets/videos/purple.mp4" muted loop autoplay playsinline preload="auto" playbackRate="0.01"></video>
        <div class="overlay"></div>
        <div class="text">
            <h2>Your Care, Our Schedule</h2>
            <p>Get clarity into your hormones and fertility with our comprehensive care. Access at-home testing, in-house experts and trusted partner clinics.<br> One life at a time, we make a difference.</p>
            <a href="core/router.php">Schedule Now →</a>
        </div>
        <ul class="social">
            <li><a href="https://www.facebook.com/xodivorce.1"><img src="./assets/images/facebook.png" alt="Facebook" style="height:50px; width:50px; opacity: 0.8;"></a></li>
            <li><a href="https://twitter.com/xodivorce1"><img src="./assets/images/x.png" alt="Twitter"style="margin-left: -5px;height:50px; width:50px; opacity: 0.8;"></a></li>
            <li><a href="https://www.instagram.com/xodivorce"><img src="./assets/images/instagram.png" alt="Instagram" style="margin-left: -10px; height:50px; width:50px; opacity: 0.8;"></a></li>
        </ul>
    </section>

    <script type="text/javascript" src="./assets/js/home.js"></script>
    <script type="text/javascript" src="./assets/js/menu.js"></script>
</body>
</html>

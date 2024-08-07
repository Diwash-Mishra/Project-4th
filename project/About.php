<?php
session_start();

// Check if the user clicked the logout button
if(isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the logout page
    header("Location: logout.php");
    exit; // Ensure that no further code is executed after the redirect
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>project</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
         /* Style for the logout button */
 #nevbar li button {
    background-color: red; /* Button background color */
    color: white; /* Button text color */
    padding: 8px 16px; /* Padding inside the button */
    border: none; /* Remove button border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Change cursor to pointer */
}

#nevbar li button:hover {
    background-color: darkred; /* Darker red on hover */
}
    </style>
    <script>
        function confirmLogout() {
            if(confirm("Are you sure you want to log out?")) {
                window.location.href = "?logout=true"; // Redirect to logout if confirmed
            }
        }
    </script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a  href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a> </li>
                <li><a class="active" href="About.php">About</a></li>
                <li><a href="Contact.php">Contact</a></li>
                <?php
                // Check if user is logged in
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                    echo  $_SESSION['username'];
                }
                ?>
                <br><li><button onclick="confirmLogout()">Log Out</button></li>
                <!-- Use the GET method to trigger the logout -->
            </ul>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#KnowUs</h2>
        <p>Who We Are</p>
    </section>

    <section id="about-head" class="section-p1">
        <img src="mero.jpg" alt="">
        <div>
            <h2>Who We Are</h2><br>
            <p>We are the students of Damak Multiple Campus. We read in <br> bachelor of Computer Application. We are trying to create a website <br> for our project of 4th semester. It's a website where people can buy the <br> used vehicles also popular in the world named as second hand. Hope our <br> website works well and we get good marks in this subject.</p><br><br>
            <abbr title="">Buy best vehicles with the help of our website and thanks for choosing us</abbr>
            <br><br><br>
            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">नया सामान आएपछी हामि चट्टा Email मा Message पठाउछौ है नरिसाउनु होला !</marquee>
        </div>
    </section>

    <section id="about-app" class="section-p1">
        <h1>Download Our <a href="#">App</a> </h1>
        <div class="video">
            <video autoplay muted loop src="video.mp4"></video>
        </div>
    </section>

    

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="Purano.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong>Shivasatakshi 11 Dudhe Jhapa</p>
            <p><strong>Phone: </strong>982-5988376, 981-4333211</p>
            <p><strong>Hours </strong>24/7 Available</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="#">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>
        <div class="install">
            <h4>Coming Soon</h4>
            <p>In PlayStore </p>
             <div class="row">
                <img  src="play.jpg" alt="">
                
            </div>
            <p><strong> Gateway </strong></p>
            <img class="esewa" src="esewa.jpg" alt="">
        </div>
        <div class="copyright">
            <p>Purano Pasal is Copyrighted under the Registrar of Copyright Act (Govt of Nepal) © 2000-2024</p>
        </div>
    </footer>
</body>
</html
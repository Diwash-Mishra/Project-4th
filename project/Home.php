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
                <li><a class="active" href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a> </li>
                <li><a href="About.php">About</a></li>
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

    <section id="hero">
        <h4>Get a Offer</h4>
        <h2>Super Value Deals</h2>
        <h1>On All Products</h1>
        <p>Save Money For Future Use</p>
        <button><a href="Shop.php">Shop Now</a></button>
    </section>

    <section id="banner" class="section-m1">
        <h4>हामी ल्याउछौ</h4>
        <h2>हजुरको लागी साधन सस्तो मुल्यमा</h2>
        <button class="normal">Explore More</button>
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
</html>

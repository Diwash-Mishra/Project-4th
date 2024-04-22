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
                <li><a  href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a> </li>
                <li><a  href="About.php">About</a></li>
                <li><a class="active" href="Contact.php">Contact</a></li>
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

    <section id="page-header">
        <h2>#Let's_Talk</h2>
        <p>LEAVE A MESSAGE. We love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our Location or Contact us Today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>Damak Chowk,Jhapa,Nepal</p>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <p>PuranoPasal@gmail.com</p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>982-5988376, 981-4333211</p>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p>24/7 Available</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3565.6847068356724!2d87.6832794747039!3d26.658575676799604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e58e3d12958f45%3A0x116ac5ec99c5b042!2sDamak%20Multiple%20Campus!5e0!3m2!1sen!2snp!4v1705313146174!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <form action="">
            <span>LEAVE A MESSAGE</span>
            <h2>We Love to hear from you</h2>
            <input type="text" placeholder="Your Name">
            <input type="email" placeholder="E-Mail">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Write your Message Here"></textarea>
            <button class="normal">Submit</button>
        </form>
        <div class="hamro-details">
            <div>
            <img src="diwash.jpg" alt="">
            <p><span>Diwash Mishra</span>Malik honi haha <br>Phone: 9825988376 <br>Email: Diwashmishra12345@gmail.com</p>
            </div>
            <div>
                <img src="puskar.jpg" alt="">
                <p><span>Puskar Magar</span>Malik honi haha <br>Phone: 981-4333211 <br>Email: Puskarmagar12345@gmail.com</p>
                </div>
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
</html>

<?php
session_start();

// Check if the user clicked the logout button
if (isset($_GET['logout'])) {
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
    <title>Project</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        /* Promotional Banner */
#promo-banner {
    background: linear-gradient(to right, #00c6ff, #0072ff);
    color: #fff;
    padding: 50px 20px;
    text-align: center;
}

#promo-banner .promo-content {
    max-width: 800px;
    margin: auto;
}

#promo-banner h2 {
    font-size: 36px;
    margin-bottom: 20px;
}

#promo-banner p {
    font-size: 18px;
    margin-bottom: 30px;
}

#promo-banner button {
    background-color: #ff4757;
    color: #fff;
    padding: 15px 30px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

#promo-banner button:hover {
    background-color: #ff6b81;
}

#promo-banner button a {
    color: inherit;
    text-decoration: none;
}

/* Testimonials Section */
#testimonials {
    background-color: #f8f8f8;
    padding: 60px 20px;
}

#testimonials h2 {
    font-size: 32px;
    margin-bottom: 40px;
}

.testimonial-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

.testimonial {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 15px;
    padding: 30px;
    max-width: 300px;
    text-align: center;
    position: relative;
}

.testimonial i {
    font-size: 30px;
    color: #ff4757;
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    border-radius: 50%;
    padding: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.testimonial p {
    font-size: 16px;
    color: #333;
    margin: 20px 0;
}

.testimonial h5 {
    font-size: 18px;
    color: #555;
    font-weight: bold;
}
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
                <li><a class="active" href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="Contact.php">Contact</a></li>
                <?php
                // Check if user is logged in
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo $_SESSION['username'];
                }
                ?>
                <li><button onclick="confirmLogout()">Log Out</button></li>
                <!-- Use the GET method to trigger the logout -->
            </ul>
        </div>
    </section>

    <section id="hero">
        <h4>Get an Offer</h4>
        <h2>Super Value Deals</h2>
        <h1>On All Products</h1>
        <p>Save Money For Future Use</p>
        <button><a href="Shop.php">Shop Now</a></button>
    </section>

    <!-- New Designs -->


    <!-- Promotional Banner -->
<section id="promo-banner" class="section-m1">
    <div class="promo-content">
        <h2>Exclusive Offer - Limited Time Only!</h2>
        <p>Get 50% off</p>
        <button><a href="Shop.php">Shop Now</a></button>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="section-p1">
   <center> <h2>What Our Customers Say</h2></center>
    <div class="testimonial-container">
        <div class="testimonial">
            <i class="fas fa-quote-left"></i>
            <p>"Great quality vehicles and amazing customer service. Highly recommend!"</p>
            <h5>- Rojan Poudel</h5>
        </div>
        <div class="testimonial">
            <i class="fas fa-quote-left"></i>
            <p>"I love the variety of vehicles available. Will definitely shop again."</p>
            <h5>- Rashmi Basnet</h5>
        </div>
        <div class="testimonial">
            <i class="fas fa-quote-left"></i>
            <p>"Fast responce and excellent prices. Five stars!"</p>
            <h5>- Nickesh Adhakari</h5>
        </div>
        <div class="testimonial">
            <i class="fas fa-quote-left"></i>
            <p>"Reliable vehicle history and detailed descriptions. Loved it"</p>
            <h5>- Simran Tiwari</h5>
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
                <img src="play.jpg" alt="">
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

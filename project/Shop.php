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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>project</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
   
</head>
<style>
    .des button {
    background-color: #3498db; /* Button background color */
    color: #ffffff; /* Button text color */
    padding: 6px 10px; /* Padding inside the button */
    font-size: 15px; /* Font size of the button text */
    border: none; /* Remove button border */
    border-radius: 5px; /* Add a slight border radius for rounded corners */
    cursor: pointer; /* Change cursor to pointer on hover */
    transition: background-color 0.3s; /* Smooth transition for background color */

    /* Optional: Add some box shadow for depth */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.des button:hover {
    background-color: #2980b9; /* Change background color on hover */
}

</style>
<body>
    <section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a  href="Home.php">Home</a></li>
                <li><a class="active" href="Shop.php">Shop</a> </li>
                <li><a href="About.php">About</a></li>
                <li><a href="Contact.php">Contact</a></li>
                <?php
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                    echo  $_SESSION['username'];
                }
                ?>
                <li><button onclick="confirmLogout()">Log Out</button></li>
            </ul>
        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>हामी ल्याउछौ</h4>
        <h2>हजुरको लागी साधन सस्तो मुल्यमा</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section-p1">
        <div class="pro-container">
           
 <!-- PRODUCT_DETAILS_PLACEHOLDER -->
<?php
// Assuming you have a PDO connection established
$pdo = new PDO('mysql:host=localhost;dbname=project', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare('SELECT * FROM product');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to generate product details HTML


function generateproductDetailsHtml($products) {
    $productDetailsHtml = '';
    foreach ($products as $product) {
        // Check if 'images' key exists before using it
        $imageSrc = isset($product['image']) ? '../admin/images/' . $product['image'] : '';

        $productDetailsHtml .= '
            <div class="pro">
                <img src="' . $imageSrc . '" alt="image">
                <div class="des">
                    <span>' . $product['type'] . '</span>
                    <h5> ' . $product['productname'] . '</h5>
                    <h4>Price: Rs. ' . $product['price'] . '</h4>
                    <button onclick="showProductDetails(' . $product['id'] . ')">More Details</button>
                </div>
            </div>
        ';
    }
    return $productDetailsHtml;


}

// Output the generated product details HTML
echo generateproductDetailsHtml($products);
?>

        </div>
    </section>
    
    <script>
        function showProductDetails(productId) {
            window.location.href = 'prodetail.php?id=' + productId;
        }

        function confirmLogout() {
            if(confirm("Are you sure you want to log out?")) {
                window.location.href = '?logout=true'; // Redirect to logout if confirmed
            }
        }
    </script>

    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
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

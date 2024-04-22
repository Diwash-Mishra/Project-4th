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
    .single-pro-details button a{
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

.single-pro-details button:hover {
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
<script>
    function confirmLogout() {
            if(confirm("Are you sure you want to log out?")) {
                window.location.href = '?logout=true'; // Redirect to logout if confirmed
            }
        }
</script>
    <section id="prodetail" class="section-p1">
    <!-- PRODUCT_DETAILS_PLACEHOLDER -->
    <?php
// Assuming you have a PDO connection established
$pdo = new PDO('mysql:host=localhost;dbname=project', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get and sanitize the product ID from the URL
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

// Check if $id is a valid integer before proceeding with the query
if (is_numeric($id)) {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Function to generate product details HTML
    function generateproductDetailsHtml($products) {
        $productDetailsHtml = '';
        foreach ($products as $product) {
            $imageSrc = isset($product['image']) ? '../admin/images/' . $product['image'] : '';
            $productDetailsHtml .= '
                <div class="single-pro-image">
                    <img src="' . $imageSrc . '" alt="image">
                    <div class="single-pro-details">
                        <h6>' . $product['type'] . '</h6>
                        <h4>Product Name: ' . $product['productname'] . '</h4>
                        <h2>Price: Rs. ' . $product['price'] . '</h2>
                        <h4>Product Details</h4>
                        <span>' . $product['detail'] . '</span>
                        <br><br><br>
                        Contact Us For More Details
                        <br><br>
                        <button><a href="buy_product.php">Buy Product</a></button>
                    </div>
                </div>
            ';
        }
        return $productDetailsHtml;
    }

    // Output the generated product details HTML
    echo generateproductDetailsHtml($products);
} else {
    echo 'Invalid product ID.';
}
?>


    </section>



</body>
</html
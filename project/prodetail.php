<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the user clicked the logout button
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to the logout page
    header("Location: logout.php");
    exit; // Ensure that no further code is executed after the redirect
}

// Check if the user clicked the buy button
if (isset($_POST['buy'])) {
    // Get and sanitize the product ID from the form
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_email = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    // Retrieve user ID from the database based on email
    if ($user_email) {
        $stmt = $conn->prepare("SELECT id FROM registration WHERE email = ?");
        $stmt->bind_param('s', $user_email);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        if ($product_id && $user_id && is_numeric($product_id) && is_numeric($user_id)) {
            // Prepare and execute the insert statement
            $stmt = $conn->prepare("INSERT INTO purchase_requests (product_id, user_id, status) VALUES (?, ?, 'pending')");
            $stmt->bind_param('ii', $product_id, $user_id);
            $stmt->execute();
            $stmt->close();
            echo "Purchase request submitted successfully.";
        } else {
            echo "Invalid request.";
        }
    } else {
        echo "User not logged in.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        #header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #f8f8f8;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        #header .logo {
            height: 50px;
        }
        
        #nevbar {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        
        #nevbar li {
            margin-left: 20px;
        }
        
        #nevbar li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        
        #nevbar li a.active {
            color: #3498db;
        }
        
        #nevbar li button {
            background-color: #3498db;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        #nevbar li button:hover {
            background-color: #2980b9;
        }
        .single-pro-container {
             padding: 20px;
        }
        .single-pro-image img{
         width: 40%;
         margin-top:-20%
        }
.single-pro-details{
    margin-left: 60%;
    
}
.single-pro-details h2{
    font-size: 26px;
}

#prodetail .single-pro-details span{
    line-height: 25px;
}


        .single-pro-details button {
            background-color: #3498db;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .single-pro-details button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a href="Home.php">Home</a></li>
                <li><a class="active" href="Shop.php">Shop</a></li>
                <li><a href="About.php">About</a></li>
                <li><a href="Contact.php">Contact</a></li>&ensp;
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo $_SESSION['username'];
                }
                ?>
                <li><button onclick="confirmLogout()">Log Out</button></li>
            </ul>
        </div>
    </section>
    <script>
    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = '?logout=true'; // Redirect to logout if confirmed
        }
    }
    </script>
    <section id="prodetail" class="section-p1">
    <?php
    // Display the product details
    // Get and sanitize the product ID from the URL
    $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

    if (is_numeric($id)) {
        $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // Function to generate product details HTML
        function generateProductDetailsHtml($products) {
            $productDetailsHtml = '';
            foreach ($products as $product) {
                $imageSrc = isset($product['image']) ? '../admin/images/' . $product['image'] : '';
                $productDetailsHtml .= '
                    <div class="single-pro-container">
                        <div class="single-pro-details">
                            <h6>' . $product['type'] . '</h6>
                            <h4>Product Name: ' . $product['productname'] . '</h4>
                            <h2>Price: Rs. ' . $product['price'] . '</h2>
                            <h4>Product Details</h4>
                            <span>' . $product['detail'] . '</span>
                            <br><br><br>
                            Contact Us For More Details
                            <br><br>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="' . $product['id'] . '">
                                <button type="submit" name="buy">Book Product</button>
                            </form>
                        </div>
                        <div class="single-pro-image">
                            <img src="' . $imageSrc . '" alt="image">
                        </div>
                    </div>
                ';
            }
            return $productDetailsHtml;
        }

        // Output the generated product details HTML
        echo generateProductDetailsHtml($products);
    } else {
        echo 'Invalid product ID.';
    }
    ?>
    </section>
</body>
</html>

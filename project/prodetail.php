<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Initialize $confirmation_message
$confirmation_message = '';

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
            // Check if there is already a pending request for the product
            $stmt = $conn->prepare("SELECT status FROM purchase_requests WHERE product_id = ? AND status = 'pending'");
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $stmt->bind_result($status);
            $stmt->fetch();
            $stmt->close();

            if ($status == 'pending') {
                $confirmation_message = "This product already has a pending request.";
            } else {
                // Prepare and execute the insert statement
                $stmt = $conn->prepare("INSERT INTO purchase_requests (product_id, user_id, status) VALUES (?, ?, 'pending')");
                $stmt->bind_param('ii', $product_id, $user_id);
                $stmt->execute();
                $stmt->close();
                // Set confirmation message
                $confirmation_message = "You have successfully booked this product.";
            }
        } else {
            $confirmation_message = "Invalid request.";
        }
    } else {
        $confirmation_message = "User not logged in.";
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
            color: red;
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
        
        .single-pro-container {
            padding: 20px;
        }
        
        .single-pro-image img {
            width: 40%;
            margin-top: -20%;
        }
        
        .single-pro-details {
            margin-left: 60%;
        }
        
        .single-pro-details h2 {
            font-size: 26px;
        }

        #prodetail .single-pro-details span {
            line-height: 25px;
        }

        .btn {
            background-color: #3498db;
            color: #ffffff;
            padding: 6px 10px;
            font-size: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn[disabled] {
            background-color: #95a5a6;
            cursor: not-allowed;
        }

        .booking-confirmation {
            margin-top: 10px;
            padding: 10px;
            background-color: #e0f7fa;
            border: 1px solid #80deea;
            border-radius: 5px;
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
        function generateProductDetailsHtml($products, $conn, $user_email, $confirmation_message) {
            $productDetailsHtml = '';
            foreach ($products as $product) {
                $imageSrc = isset($product['image']) ? '../admin/images/' . $product['image'] : '';
                
                // Check if the product has any pending request
                $stmt = $conn->prepare("SELECT status FROM purchase_requests WHERE product_id = ? AND status = 'pending'");
                $stmt->bind_param('i', $product['id']);
                $stmt->execute();
                $stmt->bind_result($status);
                $stmt->fetch();
                $stmt->close();
                
                $buttonDisabled = $status === 'pending' ? 'disabled' : '';
                $buttonText = $status === 'pending' ? 'Product Booked' : 'Book Product';

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
                            <form id="buyForm" method="POST" action="">
                                <input type="hidden" name="product_id" value="' . $product['id'] . '">
                                <button type="submit" name="buy" class="btn" ' . $buttonDisabled . '>' . $buttonText . '</button>
                                ' . ($buttonDisabled ? '' : '<a href="buy_product.php?id=' . $product['id'] . '" class="btn">Buy with eSewa</a>'
) . '
                            </form>
                            ' . ($confirmation_message ? '<div class="booking-confirmation">' . $confirmation_message . '</div>' : '') . '
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
        echo generateProductDetailsHtml($products, $conn, $_SESSION['username'], $confirmation_message);
    } else {
        echo 'Invalid product ID.';
    }
    ?>
    </section>
    <script>
    document.getElementById('buyForm').addEventListener('submit', function(event) {
        if (!confirm("Are you sure you want to book the product?")) {
            event.preventDefault(); // Prevent form submission if cancelled
        }
    });
    </script>
</body>
</html>

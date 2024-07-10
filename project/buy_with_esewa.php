<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get and sanitize the product ID from the form
$id = isset($_POST['pid']) ? filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT) : null;
$esewa_id = isset($_POST['esewa_id']) ? $_POST['esewa_id'] : '';
$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
$price = isset($_POST['amount']) ? $_POST['amount'] : '';

// Check if user is logged in and get user information
$user_id = null;
$user_name = '';
$user_email = '';
$user_number = '';

if (isset($_SESSION['username'])) {
    $user_email = $_SESSION['username'];

    // Retrieve user information from the database based on email
    $stmt = $conn->prepare("SELECT id, name, email, number FROM registration WHERE email = ?");
    if (!$stmt) {
        die('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
    }
    
    $stmt->bind_param('s', $user_email);
    if (!$stmt->execute()) {
        die('Execute failed: (' . $stmt->errno . ') ' . $stmt->error);
    }
    
    $stmt->bind_result($user_id, $user_name, $user_email, $user_number);
    if (!$stmt->fetch()) {
        die('No user found with email ' . htmlspecialchars($user_email));
    }
    
    $stmt->close();
}

// Insert into sold_products table
if ($id && $user_id && $esewa_id && $product_name && $price) {
    // Start transaction for atomicity
    $conn->autocommit(false);
    
    // Insert into sold_products table
    $stmt = $conn->prepare("INSERT INTO sold_products (product_name, price, esewa_id, user_id, user_name, user_email, user_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
    }
    
    $stmt->bind_param('sssisss', $product_name, $price, $esewa_id, $user_id, $user_name, $user_email, $user_number);
    if (!$stmt->execute()) {
        die('Execute failed: (' . $stmt->errno . ') ' . $stmt->error);
    }
    
    $stmt->close();

    // Delete product from shop
    $stmt = $conn->prepare("DELETE FROM product WHERE id = ?");
    if (!$stmt) {
        die('Prepare failed: (' . $conn->errno . ') ' . $conn->error);
    }
    
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        die('Execute failed: (' . $stmt->errno . ') ' . $stmt->error);
    }
    
    $stmt->close();

    // Commit transaction
    $conn->commit();
}

// HTML structure with table and CSS styling for better presentation
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Transaction Successful</title>
<style>
body { 
    font-family: Arial, sans-serif;
    margin: 20px;
    text-align: center;
    background-color: #f2f2f2;
}
.container {
    width: 80%;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}
h2 { 
    color: #3498db; 
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
table th, table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
table th {
    background-color: #f2f2f2;
}
.btn {
    display: inline-block;
    background-color: #3498db;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
.btn:hover {
    background-color: #2980b9;
}
</style>
</head>
<body>
<div class="container">
<?php
if ($id && $user_id && $esewa_id && $product_name && $price) {
    echo '<h2>Thank you for your purchase!</h2>';
    echo '<table>';
    echo '<tr><th colspan="2">Transaction Details</th></tr>';
    echo '<tr><td>Product Name:</td><td>' . htmlspecialchars($product_name) . '</td></tr>';
    echo '<tr><td>Price:</td><td>NPR ' . htmlspecialchars($price) . '</td></tr>';
    echo '<tr><td>eSewa ID:</td><td>' . htmlspecialchars($esewa_id) . '</td></tr>';
    echo '<tr><td>User Name:</td><td>' . htmlspecialchars($user_name) . '</td></tr>';
    echo '<tr><td>User Email:</td><td>' . htmlspecialchars($user_email) . '</td></tr>';
    echo '<tr><td>User Phone:</td><td>' . htmlspecialchars($user_number) . '</td></tr>';
    echo '</table>';
    echo '<a href="home.php" class="btn">Go to Home Page</a>';
} else {
    echo '<h2>Error: Incomplete Information</h2>';
    echo '<p>Unable to process your request. Please ensure all required fields are filled.</p>';
    echo '<a href="home.php" class="btn">Go to Home Page</a>';
}
?>
</div>
</body>
</html>
<?php
// Rollback transaction on error
if ($conn->errno) {
    $conn->rollback();
}

// Restore autocommit mode
$conn->autocommit(true);

$conn->close();
?>

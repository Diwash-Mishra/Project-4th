<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get and sanitize the product ID from the URL
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

$product_name = '';
$price = 0;
$product_valid = false;

if (is_numeric($id)) {
    $stmt = $conn->prepare("SELECT productname, price FROM product WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($product_name, $price);
        if ($stmt->fetch()) {
            $product_valid = true;
        }
        $stmt->close();
    } else {
        echo 'Prepare failed: (' . $conn->errno . ') ' . $conn->error;
        exit;
    }
}

if (!$product_valid) {
    echo 'Invalid product ID.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy with eSewa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 8px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Buy with eSewa</h2>
        <form action="buy_with_esewa.php" method="POST">
            <div class="form-group">
                <label for="esewa-id">eSewa ID:</label>
                <input type="text" id="esewa-id" name="esewa_id" required>
            </div>
            <div class="form-group">
                <label for="esewa-password">Password:</label>
                <input type="password" id="esewa-password" name="esewa_password" required>
            </div>
            <div class="form-group">
                <label for="productname">Product Name:</label>
                <input type="text" id="productname" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="price">Price (NPR):</label>
                <input type="number" id="price" name="amount" value="<?php echo htmlspecialchars($price); ?>" readonly>
            </div>
            <input type="hidden" name="pid" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="scd" value="epay_payment">
            <input type="hidden" name="su" value="http://example.com/success">
            <input type="hidden" name="fu" value="http://example.com/failed">
            <button type="submit" class="btn">Buy with eSewa</button>
        </form>
    </div>
</body>
</html>

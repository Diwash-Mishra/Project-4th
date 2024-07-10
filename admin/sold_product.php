<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'project';
$username = 'root';
$password = '';

try {
    // Establish a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch sold products
    $stmt = $pdo->prepare("SELECT id, product_name, price, esewa_id, user_id, user_name, user_email, user_number, transaction_date FROM sold_products ORDER BY id");
    $stmt->execute();
    $sold_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Function to handle delete button action
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    try {
        // Prepare SQL statement to delete a product by id
        $stmt = $pdo->prepare("DELETE FROM sold_products WHERE id = ?");
        $stmt->execute([$delete_id]);
        header("Location: {$_SERVER['PHP_SELF']}"); // Refresh the page after deletion
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Products</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        /* Table header styles */
        th {
            background-color: #3498db;
            color: #ffffff;
            font-weight: bold;
            padding: 10px;
            text-align: left;
        }

        /* Table body row styles */
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #f2f2f2;
        }

        /* Alternating row background color */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover effect for rows */
        tbody tr:hover {
            background-color: #e2e2e2;
        }

        /* Delete button style */
        .delete-btn {
            background-color: #e74c3c;
            color: #ffffff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 3px;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a href="user_message.php">User Message</a></li> <br>
                <li><a href="addproduct.php">Add Products</a></li><br>
                <li><a href="productinfo.php">Products</a></li><br>
                <li><a href="booked.php">Book Request</a></li><br>
                <li><a href="approve.php">Booked Info</a></li><br>
                <li><a href="sold_product.php">Sold</a></li><br>
                <li>
                    <a href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </section>
    <center><br><h1>Sold Products</h1></center>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>eSewa ID</th>
                <th>User ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Number</th>
                <th>Transaction Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sold_products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($product['esewa_id']); ?></td>
                    <td><?php echo $product['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($product['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['user_email']); ?></td>
                    <td><?php echo htmlspecialchars($product['user_number']); ?></td>
                    <td><?php echo $product['transaction_date']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

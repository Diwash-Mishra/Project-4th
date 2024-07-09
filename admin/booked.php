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

    // Handle approve/reject action
    if (isset($_GET['id']) && isset($_GET['action'])) {
        $request_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $action = filter_var($_GET['action'], FILTER_SANITIZE_STRING);

        if ($request_id && is_numeric($request_id) && in_array($action, ['approve', 'reject'])) {
            // Update the status of the purchase request
            $status = ($action == 'approve') ? 'completed' : 'cancelled';
            $stmt = $pdo->prepare("UPDATE purchase_requests SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
            $stmt->execute();

            // If approved, insert into approved_requests table
            if ($action == 'approve') {
                // Fetch product details
                $stmt_product = $pdo->prepare("SELECT p.productname, r.name, r.number, r.email, pr.product_id 
                                               FROM purchase_requests pr 
                                               JOIN product p ON pr.product_id = p.id 
                                               JOIN registration r ON pr.user_id = r.id 
                                               WHERE pr.id = :request_id");
                $stmt_product->bindParam(':request_id', $request_id, PDO::PARAM_INT);
                $stmt_product->execute();
                $product_info = $stmt_product->fetch(PDO::FETCH_ASSOC);
            
                // Insert into approved_requests table
                $insertStmt = $pdo->prepare("INSERT INTO approved_requests (product_name, username, phone_number, email, status)
                                            VALUES (:productname, :username, :number, :email, 'completed')");
                $insertStmt->bindParam(':productname', $product_info['productname'], PDO::PARAM_STR);
                $insertStmt->bindParam(':username', $product_info['name'], PDO::PARAM_STR);
                $insertStmt->bindParam(':number', $product_info['number'], PDO::PARAM_STR);
                $insertStmt->bindParam(':email', $product_info['email'], PDO::PARAM_STR);
                $insertStmt->execute();
            
                // Delete from product table
                $product_id = $product_info['product_id']; // Retrieve product_id
                if ($product_id) {
                    $deleteProductStmt = $pdo->prepare("DELETE FROM product WHERE id = :product_id");
                    $deleteProductStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $deleteProductStmt->execute();
                }
            }
            

            // Redirect back to approve.php after processing
            header("Location: approve.php");
            exit;
        } else {
            echo "Invalid request.";
        }
    }

    // Fetch all pending purchase requests
    $stmt = $pdo->prepare("SELECT pr.id, p.productname, r.name, r.number, r.email, pr.status FROM purchase_requests pr 
        JOIN product p ON pr.product_id = p.id 
        JOIN registration r ON pr.user_id = r.id WHERE pr.status = 'pending'");
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Purchase Requests</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Add margin for spacing */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }

        /* Table header styles */
        th {
            background-color: #3498db; /* Header background color */
            color: #ffffff; /* Header text color */
            font-weight: bold;
            padding: 10px;
            text-align: left;
        }

        /* Table body row styles */
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #f2f2f2; /* Bottom border for rows */
        }

        /* Alternating row background color */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row color */
        }

        /* Hover effect for rows */
        tbody tr:hover {
            background-color: #e2e2e2; /* Hover color */
        }

        /* Link styles for actions */
        td a {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            background-color: #2ecc71; /* Approve button background color */
            color: #ffffff; /* Button text color */
            border-radius: 4px;
            margin-right: 5px;
            transition: background-color 0.3s;
        }

        /* Reject button style */
        td a:last-child {
            background-color: #e74c3c; /* Reject button background color */
        }

        /* Button hover effect */
        td a:hover {
            background-color: #27ae60; /* Darker shade on hover for approve */
        }

        td a:last-child:hover {
            background-color: #c0392b; /* Darker shade on hover for reject */
        }

    </style>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a href="userinfo.php">User Information</a></li> <br>
                <li><a href="addproduct.php">Add Products</a></li><br>
                <li><a href="productinfo.php">Product Info</a></li><br>
                <li><a href="booked.php">Booked Info</a></li><br>
                <li><a href="approve.php">Approved Info</a></li><br>
                <li>
                    <a href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </section>
    <center>
        <br> <br><h1>Pending Purchase Requests</h1><br><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($requests)): ?>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?php echo $request['id']; ?></td>
                            <td><?php echo $request['productname']; ?></td>
                            <td><?php echo $request['name']; ?></td>
                            <td><?php echo $request['number']; ?></td>
                            <td><?php echo $request['email']; ?></td>
                            <td><?php echo $request['status']; ?></td>
                            <td>
                                <a href="?id=<?php echo $request['id']; ?>&action=approve">Approve</a>
                                <a href="?id=<?php echo $request['id']; ?>&action=reject">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No pending requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </center>
</body>
</html>

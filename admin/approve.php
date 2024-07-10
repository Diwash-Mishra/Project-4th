<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'project';
$username = 'root';
$password = '';

// Function to delete a request by ID
function deleteRequest($pdo, $request_id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM approved_requests WHERE id = ?");
        $stmt->execute([$request_id]);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

try {
    // Establish a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch approved and rejected requests with product details
    $stmt = $pdo->prepare("SELECT id, product_name, username, phone_number, email, status FROM approved_requests ORDER BY id");
    $stmt->execute();
    $approved_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle deletion if delete button is clicked
    if (isset($_POST['delete_request'])) {
        $request_id = $_POST['request_id'];
        deleteRequest($pdo, $request_id);
        // Redirect to avoid resubmission on refresh
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved and Rejected Requests</title>
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

        /* Delete button style */
        .delete-btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
    <center>
    <br> <br> <h1>Booked Product by Users</h1><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Username</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approved_requests)): ?>
                <?php foreach ($approved_requests as $request): ?>
                <tr>
                    <td><?php echo $request['id']; ?></td>
                    <td><?php echo $request['product_name']; ?></td>
                    <td><?php echo $request['username']; ?></td>
                    <td><?php echo $request['phone_number']; ?></td>
                    <td><?php echo $request['email']; ?></td>
                    <td><?php echo $request['status']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="delete_request" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No approved or rejected requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </center>
</body>
</html>

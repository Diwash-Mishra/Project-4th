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

    // Fetch approved and rejected requests
    $stmt = $pdo->prepare("SELECT pr.id, p.productname, r.name, pr.status FROM purchase_requests pr 
        JOIN product p ON pr.product_id = p.id 
        JOIN registration r ON pr.user_id = r.id WHERE pr.status IN ('completed', 'cancelled')");
    $stmt->execute();
    $approved_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

/* No action links in this table, so no link styling needed */

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
  <br> <br> <h1>Approved and Rejected Requests</h1><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Username</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approved_requests)): ?>
                <?php foreach ($approved_requests as $request): ?>
                <tr>
                    <td><?php echo $request['id']; ?></td>
                    <td><?php echo $request['productname']; ?></td>
                    <td><?php echo $request['name']; ?></td>
                    <td><?php echo $request['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No approved or rejected requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </center>
</body>
</html>

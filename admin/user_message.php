<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete action
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM message_of_customer WHERE id = ?");
    $stmt->bind_param("i", $idToDelete);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve messages
$messages = [];
$result = $conn->query("SELECT id, name, email, number, subject, message, created_at FROM message_of_customer");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkred;
        }
    </style>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                window.location.href = "?delete=" + id; // Redirect to delete if confirmed
            }
        }
    </script>
</head>
<body>
<section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a href="userinfo.php">User Info</a></li> <br>
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
    <center><br><h1>Customer Messages</h1></center>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Number</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php
        if (!empty($messages)) {
            foreach ($messages as $message) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($message['id']) . "</td>";
                echo "<td>" . htmlspecialchars($message['name']) . "</td>";
                echo "<td>" . htmlspecialchars($message['email']) . "</td>";
                echo "<td>" . htmlspecialchars($message['number']) . "</td>";
                echo "<td>" . htmlspecialchars($message['subject']) . "</td>";
                echo "<td>" . htmlspecialchars($message['message']) . "</td>";
                echo "<td>" . htmlspecialchars($message['created_at']) . "</td>";
                echo "<td><button onclick='confirmDelete(" . htmlspecialchars($message['id']) . ")'>Delete</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No messages found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Table and button styles */
        table {
            width: 90%; /* Reduce table width */
            margin: 20px auto; /* Center-align the table */
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
            text-decoration: none;
            display: inline-block;
        }

        button:hover {
            background-color: darkred;
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
        <h2>Product Information</h2>
        <table border="2">
            <tr>
                <th>S.N</th>
                <th>Type</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            $i = 1;
            $con = new mysqli('localhost', 'root', '', 'project');
            $sql = "SELECT * FROM product";
            if ($result = mysqli_query($con, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $i++ . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "<td>" . $row['productname'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td><img src='images/" . $row['image'] . "' height='100px'></td>";
                    echo "<td><a href='edit.php?id=" . $row['id'] . "'><button>Edit</button>&ensp;&ensp;</a>";
                    echo "<a href='delete.php?id=" . $row['id'] . "'><button>Delete</button></a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </center>
</body>
</html>

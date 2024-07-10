

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
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
    </style>
    </style>
</head>
<body>
<section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a href="user_message.php">User Message</a></li> <br>
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
    <h2>Users Information</h2>

  
  <pre>
    <table border="2">
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Email </th>
            <th>Number </th>
            <th>Country </th>
            <th>Gender</th>
        </tr>
        <?php
        $i=1;
        $con = new mysqli('localhost','root','','project');
        $sql = "SELECT * FROM registration";
          if($result=mysqli_query($con,$sql)){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>". $i++ ."</td>" ;
                echo "<td>".$row['name']."</td>" ;
                echo "<td>".$row['email']."</td>" ;
                echo "<td>".$row['number']."</td>" ;
                echo "<td>".$row['country']."</td>" ;
                echo "<td>".$row['gender']."</td>" ;
                //echo "<td>Edit Delete</td>";
                echo "</tr>";


            }

          }
          ?>
          </center>
</table>
  </pre>



</body>
</html>


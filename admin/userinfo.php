

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a class="active" href="userinfo.php">User Information</a></li> <br>
                <li><a href="addproduct.php">Add Products</a></li><br>
                <li><a href="productinfo.php">Product Info</a></li>
                <li><button><a href="dash.php">Goto Dashboard </a></li></button>
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


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
                <li><a  href="userinfo.php">User Information</a></li> <br>
                <li><a  href="addproduct.php">Add Products</a></li><br>
                <li><a class="active" href="productinfo.php">Product Info</a></li>
                <li><button><a href="dash.php">Goto Dashboard </a></li></button>
            </ul>
        </div>
    </section>  
  <center>

    <h2>Product Information</h2>

  
  <pre>
    <table border="2">
        <tr>
            <th>S.N</th>
            <th>Type</th>
            <th>Product Name </th>
            <th>Price </th>
            <th>Image </th> 
        </tr>
        <?php
        $i=1;
        $con = new mysqli('localhost','root','','project');
        $sql = "SELECT * FROM product";
          if($result=mysqli_query($con,$sql)){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>". $i++ ."</td>" ;
                echo "<td>".$row['type']."</td>" ;
                echo "<td>".$row['productname']."</td>" ;
                echo "<td>".$row['price']."</td>" ;
                echo "<td> <img src='images/".$row['image']."' height='100px'></td>";
                echo "<td><a href=edit.php?id=".$row['id'].">Edit</td>";
                echo '<td><a href="delete.php?id='.$row['id'] . '">Delete</a></td>';
                //echo "<td>Edit Delete</td>";
                echo "</tr>";

              
            }

          }
          ?>
</table>
  </pre>
  </center>
</body>
</html>
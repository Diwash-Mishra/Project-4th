<?php
$con = new mysqli('localhost', 'root', '', 'project');

if (isset($_POST['signup'])) {
    $type = $_POST['type'];
    $productname = $_POST['productname'];
    $price = $_POST['price'];
    $detail = $_POST['detail'];

    if ($_FILES['file']['error'] > 0) {
        echo "Error: " . $_FILES['file']['error'];
    } else {
        $imgname = $_FILES['file']['name'];
        $targetPath = "images/" . $imgname;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            echo "File uploaded successfully.";
        } else {
            echo "There was an error uploading the file.";
        }

        $sql = "INSERT INTO product(type, productname, price, detail, image) VALUES ('$type', '$productname', '$price', '$detail', '$imgname')";
        if (mysqli_query($con, $sql)) {
            echo '<script>alert("Product Added");</script>';
            echo "<script>window.location='dash.php'</script>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>

    a{
        color: white;
        text-decoration: none;
    }
h1{
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-weight: bold;
    font-size: 50px;
    color: blue;
    text-decoration: dotted;
    padding-left: 10%;
}
fieldset{
    background-color: gray;
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
    color: #fff;
    padding: 4%; 
    margin-left: 30%;
    margin-right: 20%; 
}
.main{
    width: 400px;
    margin-top: -3%;
    margin-left: 0%;
}
label{
    font-family: 'Times New Roman', Times, serif;
    font-size: 27px;
 
}
input#productname,
input#type,
input#price,
input#file,
input#detail
{
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3) ;
    color: black;
}
input#submit{
    width: 200px;
    padding: 7px;
    font-size: 16px;
    font-family: 'Times New Roman', Times, serif;
    font-weight: 600;
    border-radius: 3px;
    background-color: rgba(250, 100, 0, 0.8);
    color: #fff;
    cursor: pointer;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3) ;
}
</style>
<body>
<section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a  href="userinfo.php">User Information</a></li> <br>
                <li><a class="active" href="addproduct.php">Add Products</a></li><br>
                <li><a href="productinfo.php">Product Info</a></li>
               <li> <button><a href="dash.php">Goto Dashboard </a></button></li>
            </ul>
        </div>
    </section>
    <center>
    
    <h1>Add Product </h1>
  
    <fieldset>
        <div class="main">
    <form method="post" action="" enctype="multipart/form-data">
    &emsp; <label for="type">Type:</label><br>
    <input type="text" id="type" name="type" /> <br><br>
    &emsp;&emsp; <label for="productname">Product Name:</label><br>
    <input type="text" id="productname" name="productname" /> <br><br>
    &emsp;&emsp; <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" /> <br><br>
    &emsp;&emsp;<label for="image">Image:</label><br>
    <input type="file" id="file" name="file" /> <br><br>
    &emsp;&emsp; <label for="detail">Product Information:</label><br>
    <input type="textbox" id="detail" name="detail" /> <br><br>
    <input type="submit" name="signup" id="submit" value="Add"/>
    </div>    
</fieldset>
    </form>
    </center>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<style>
    button{
        margin-left: 80%;
        background-color: red;
    }
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
        padding-left: 4%;
        margin-top: -0.8%;
    }
    fieldset{
        background-color: gray;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
        color: #fff;
        padding: 4%; 
        margin-left: 30%;
        margin-right: 30%; 
        margin-top: -1.5%;
    }
    .main{
        width: 400px;
        margin-top: -5%;
        margin-left: 10%;
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
    <h1>Update Products</h1>
    <button><a href="dash.php">Go to Dashboard </a></button>
    <fieldset>
        <div class="main">
            <?php
                $con = new mysqli('localhost','root','','project');
                $id = $_GET['id'];

                if (isset($_POST['update'])) {
                    // Retrieve form data
                    $type = $_POST['type'];
                    $productname = $_POST['productname'];
                    $price = $_POST['price'];

                    // Check if a new image is uploaded
                    if ($_FILES['file']['name'] != "") {
                        // If a new image is uploaded, update $image variable
                        $image = $_FILES['file']['name'];
                        $target = "images/" . basename($image);
                        move_uploaded_file($_FILES['file']['tmp_name'], $target);
                    } else {
                        // If no new image is uploaded, keep the existing one
                        $image = isset($_POST['image']) ? $_POST['image'] : '';
                    }
                    $detail = $_POST['detail'];
                    // Update the product in the database
                    $update_sql = "UPDATE product SET type='$type', productname='$productname', price='$price', image='$image', detail='$detail' WHERE id=$id";
                    if ($con->query($update_sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $con->error;
                    }
                }

                $sql = "SELECT * FROM product WHERE id=$id";
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <form method="post" action="" enctype="multipart/form-data">
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <label for="type">Type:</label><br>
                <input type="text" id="type" name="type" value="<?php echo $row['type']?>"/> <br><br>
                &emsp;&emsp;&emsp;&emsp; <label for="productname">Product Name:</label><br>
                <input type="text" id="productname" name="productname"  value="<?php echo $row['productname']?>"/> <br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <label for="price">Price:</label><br>
                <input type="number" id="price" name="price" value="<?php echo $row['price']?>"/> <br><br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<img src="images/<?php echo $row['image']?>" height="100px" /> <br>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<label for="file">Image:</label><br>
                <input type="file" id="file" name="file" /> <br><br>
                <input type="hidden" name="image" value="<?php echo $row['image']; ?>" /> <!-- Hidden input to send the existing image value -->
                &emsp;&emsp; <label for="detail">Product Information:</label><br>
                <input type="text" id="detail" name="detail" value="<?php echo $row['detail']?>"/> <br><br>
                &emsp;&emsp;&emsp;&emsp;<input type="submit" name="update" id="submit" value="Update"/>
            </form>
            <?php 
                }
                $con->close();
            ?>
        </div>
    </fieldset>
</body>
</html>

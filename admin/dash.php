<?php
session_start();
if(isset($_SESSION['username'])){
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
   
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

    <section id="hero">
        <h4>Hello Admin</h4>
        <h2>Welcome To Dashboard</h2>
    </section>
</body>
</html>
<?php }else{
    echo "<script>alert('Goto Login Page')</script>";
    echo "<script>window.location='index.php'</script>";
} ?>
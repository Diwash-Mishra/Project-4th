<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
   <style>

h2{
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-weight: bold;
    font-size: 30px;
    text-decoration: dotted;
}
fieldset{
    background-color: gray;
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
    color: #fff;
    padding: 4%; 
    margin-left: 35%;
    margin-right: 30%; 
}
.main{
    width: 400px;
    margin-top: -3%;
    margin-left: 10%;
}
label{
    font-family: 'Times New Roman', Times, serif;
    font-size: 27px;
 
}
input#username,
input#password{
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3) ;
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
.error-message{
    color: red;
    font-size: large;
    margin-left: 10%;
    margin-top: -4%;
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
   <h2>Admin Login</h2>
    <form action="" method="post">
        <fieldset>
            <div class="main">
            &emsp;&emsp; &emsp;&emsp;<label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        &emsp;&emsp; &emsp;&emsp; <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br><br>
        
        <?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $validUsername = "admin";
    $validPassword = "admin123";

    if ($username == $validUsername && $password == $validPassword) {
         // Set the session variable
  $_SESSION['username'] = $username;
        // Redirect to the admin panel or dashboard upon successful login
        header("Location: dash.php");
        exit();
    } else {
        // Display an error message for invalid credentials
        
        echo '<p class="error-message">Invalid username or password</p>';
    }
}
?>

        &emsp;&emsp;&emsp; <input id="submit" type="submit" value="Login">
            </div>
        </fieldset>
    </form>
</body>
</html>

    
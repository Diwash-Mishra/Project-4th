<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
*{
    margin: 0;
    padding: 0;
}
body{
    background-image: url(vehi.jpg);
    background-size: 100%;
    
}
fieldset{
    background-color: rgba(0, 0, 0, 0.5);
    background-size: cover;
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.3);
    color: #fff;
    padding-bottom: 9%;
}
.main{
    width: 400px;
    margin-top: -3%;
    margin-left: 45%;
}
h2{
    text-align: center;
    padding: 2%;
    margin-left: -20%;
    font-family: 'Times New Roman', Times, serif;
    font-weight: bold;
    color: #fff;
    text-decoration: dotted;
}


label{
    font-family: 'Times New Roman', Times, serif;
    font-size: 18px;
 
}
input#name,
input#email,
input#phone,
input#password,
input#repassword,
select#name{
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3) ;
}
input#Submit{
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
select#select,
input#dob{
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 3px;
    outline: 0;
    padding: 7px;
    background-color: #fff;
    box-shadow: inset 1px 1px 5px rgba(0, 0, 0, 0.3) ;
    cursor: pointer;
}
input#radio,
input#checkbox{
    cursor: pointer;
}
.login{
    width: 400px;
    margin-top: -17.9%;
    margin-left: 60%;
    margin-bottom: 12.4%;
}
#lhero{
    background-position: top 25% right 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    margin-left: 15%;
    margin-top: 14.8%;
}
#lhero h5{
    font-size: 46px;
}
#lhero h4{
    font-size: 20px;
    padding-bottom: 15px;
}
#lhero h1{
    color: #088178;
    font-size: 50px;
    line-height: 64px;
}
a{
    color: #fff;
    text-decoration: none;
}
h{
    font-size: large;
    margin-left: 10%;
}

    </style>
</head>
<body>
    <form action="login.php" method="POST">
    <fieldset>
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <section id="lhero">
            <h4>Get a Offer</h4>
            <h5>Super Value Deals</h5>
            <h1>On All Products</h1>
            <p>Save Money For Future Use</p>
        </section>
        <div class="login">
            
            
                <br><label>Email :  </label><br>
                
                <input type="email" id="email" name="email" placeholder="Enter your Email" required> <br> <br>
                <label>Password:</label>
                <br>
                <input type="password" id="password" name="password" placeholder="Minimum 8 characters, atleast 1 letter & 1 number" required> <br>
                <br>
                <?php
            // Display error message if it exists
            if (!empty($error_message)) {
                echo '<h style="color: red;">' . $error_message . '</h>';
            }
            ?>
                <input style="text-align: center; margin-left: 10%;" type="submit" name="SignIn" value="SignIn" id="Submit"><br><br>
            <label><a href="forgot_password.php">Forgot Password?</a></label>&emsp;&emsp;
            <label><a href="register.html">Create an Account</a></label>
        </div>
    </fieldset>
</form>
</body>
</html>
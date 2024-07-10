<?php
 $conn = new mysqli('localhost', 'root', '', 'project');

 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
// Set Nepali time zone
date_default_timezone_set('Asia/Kathmandu');

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT Email, reset_token_hash, reset_token_expires_at FROM registration WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['Email'];
        $token_hash = $row['reset_token_hash'];
        $expires_at = $row['reset_token_expires_at'];

        // Debugging information
        error_log("Token hash in DB: $token_hash");
        error_log("Expiration time in DB: $expires_at");
        error_log("Current time: " . date("Y-m-d H:i:s"));

        if(password_verify($token, $token_hash) && strtotime($expires_at) > time()) {
            if(isset($_POST['submit'])) {
                $new_password = $_POST['password'];
                // Validate the new password if needed

                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE registration SET password=?, reset_token=NULL, reset_token_hash=NULL, reset_token_expires_at=NULL WHERE Email=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $hashed_password, $email);
                $stmt->execute();

                echo '<script>alert("Your password has been reset successfully.");</script>';
                header("Location: index.php");
                exit; // Make sure to exit after redirection
            }
        } else {
            echo '<script>alert("Invalid or expired token.");</script>';
        }
    } else {
        echo '<script>alert("Invalid token.");</script>';
    }
} else {
    echo '<script>alert("No token provided.");</script>';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style type="text/css">
        body {
            height: 650px;
            background-image: url("images/7.jpg");
            background-repeat: no-repeat;
        }
        .wrapper {
            width: 400px;
            height: 400px;
            margin: 100px auto;
            background-color: black;
            opacity: .8;
            color: white;
            padding: 27px 15px;
        }
        .form-control {
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div style="text-align: center;">
            <h1 style="text-align: center; font-size: 35px; font-family: Lucida Console;">Reset Your Password</h1>
        </div>
        <div style="padding-left: 30px;">
            <form action="" method="post">
                <input type="password" name="password" class="form-control" placeholder="New Password" required=""><br>
                <button class="btn btn-default" type="submit" name="submit">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn = new mysqli('localhost', 'root', '', 'project');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assign the connection object to $db
$db = $conn;

require 'src/Exception.php'; 
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Set Nepali time zone
date_default_timezone_set('Asia/Kathmandu');

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Validate email existence
    $check_email_sql = "SELECT * FROM registration WHERE Email = ?";
    $check_stmt = $db->prepare($check_email_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        echo "
        <script>
        alert('Email address does not exist.');
        window.location.href='index.php';
        </script>
        ";
        exit();
    }

    $token = generateToken();
    $token_hash = password_hash($token, PASSWORD_DEFAULT);
    $expires_at = date("Y-m-d H:i:s", strtotime('+15 minutes'));

    // Debugging information
    error_log("Generated token: $token");
    error_log("Token hash: $token_hash");
    error_log("Expiration time: $expires_at");

    // Update database with reset token and expiry time
    $sql = "UPDATE registration SET reset_token=?, reset_token_hash=?, reset_token_expires_at=? WHERE Email=?";
    $stmt = $db->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($db->error));
    }

    $bind = $stmt->bind_param("ssss", $token, $token_hash, $expires_at, $email);

    if ($bind === false) {
        die('Bind failed: ' . htmlspecialchars($stmt->error));
    }

    $execute = $stmt->execute();

    if ($execute === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    if ($stmt->affected_rows === 0) {
        die('No rows updated. Check if the email exists in the database.');
    }

    // Send email with reset token
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'itspuranopasal@gmail.com';
        $mail->Password = 'puranopasal9825';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('puranopasal@gmail.com', 'Purano Pasal');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($email);
        } else {
            throw new Exception('Invalid email address');
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click <a href='http://localhost/library/student/reset_password.php?token=$token'>here</a> to reset your password. This link will expire in 15 minutes.";

        $mail->send();
        echo "
        <script>
        alert('A password reset link has been sent to your email.');
        window.location.href='index.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "
        <script>
        alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');
        window.location.href='index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
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
            <h1 style="text-align: center; font-size: 35px; font-family: Lucida Console;">Forgot Password</h1>
        </div>
        <div style="padding-left: 30px;">
            <form action="" method="post">
                <input type="text" name="email" class="form-control" placeholder="Email" required=""><br>
                <button class="btn btn-default" type="submit" name="submit">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>
</html>

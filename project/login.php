<?php
$error_message = "";
if(isset($_POST['SignIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conn = new mysqli('localhost', 'root', '', 'project');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM registration WHERE email='$email'";
    $_SESSION['username'] = $email;
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $registration = $result->fetch_assoc();

        if(password_verify($password, $registration['password'])){
            header("location: Home.html");
            exit();
        } else {
            $error_message = "Password does not match";
        }
    } else {
        $error_message = "Email does not exist";
    }

    $conn->close();
}
// Include the HTML file
include 'index.php';
?>
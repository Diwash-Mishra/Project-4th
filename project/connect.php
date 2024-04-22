<?php
$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$password = $_POST['password'];
// Retrieve and format date of birth
$dob = date('Y-m-d', strtotime($_POST['dob'])); 

$country = $_POST['country'];
$gender = $_POST['gender'];
// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
//database connection
$conn = new mysqli('localhost','root','','project');
if($conn-> connect_error){
    die('connection failed:' .$conn->connect_error);
}else{
    $stmt = $conn-> prepare("insert into registration(name, email, number, password, dob, country,gender)values(?,?,?,?,?,?,?)");
    $stmt-> bind_param("ssisiss", $name,$email,$number,$hashed_password,$dob,$country,$gender);
   if( $stmt->execute()){
        echo "Your account is created";
        header("location:index.php");
   }
    $stmt->close();
    $conn->close();
}
?>
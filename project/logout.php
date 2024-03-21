<?php
session_start();
if(isset($_SESSION['username'])){
    echo "<script>alert('Are You Sure Want to Logout')</script>";
    echo "<script>window.location='index.php'</script>";
session_destroy();
}else {
    echo "<script>alert('Are You Sure Want to Logout')</script>";
           echo "<script>window.location='index.php'</script>";
}

?>
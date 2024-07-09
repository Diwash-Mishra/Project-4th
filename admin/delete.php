<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Establish database connection
    $con = new mysqli('localhost', 'root', '', 'project');

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Display a confirmation prompt using JavaScript
    echo '<script>';
    echo 'var userConfirmation = confirm("Are you sure you want to delete this product?");';
    echo 'if (userConfirmation) {';
    
    // Delete the product from the database
    $sql = "DELETE FROM product WHERE id = '$product_id'";
    if (mysqli_query($con, $sql)) {
        echo 'alert("Product deleted successfully");';
    } else {
        echo 'alert("Error deleting product: ' . mysqli_error($con) . '");';
    }

    // Redirect to productinfo.php after deletion
    echo 'window.location.href = "productinfo.php";';
    echo '} else {';
    echo 'window.location.href = "productinfo.php";'; // Redirect if user cancels deletion
    echo '}';
    echo '</script>';

    // Close database connection
    mysqli_close($con);
} else {
    echo "Invalid product ID";
}
?>

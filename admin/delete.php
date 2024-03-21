<?php
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    $con = new mysqli('localhost', 'root', '', 'project');

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Display a confirmation prompt using JavaScript
    echo '<script>';
    echo 'var userConfirmation = confirm("Are you sure you want to delete this product?");';
    echo 'if (userConfirmation) {';
    // Delete the product from the database
    $sql = "DELETE FROM product WHERE id = '$product_id'"; // Corrected variable name
    echo 'if ('. mysqli_query($con, $sql) .') {';
    echo 'alert("Product deleted successfully");';
    echo 'window.location="productinfo.php";';
    echo '} else {';
    echo 'window.location="productinfo.php";'; // Redirect to product info if user cancels deletion
    echo '}';
    echo '}';
    echo '</script>';

    mysqli_close($con);
} else {
    echo "Invalid product ID";
}
?>

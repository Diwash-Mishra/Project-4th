<?php
session_start(); // Start the session
session_destroy(); // Destroy the session

// Redirect to index.php or any other page after logout
header("Location: index.php");
exit; // Ensure script termination after redirection
?>

<?php
session_start();

// Include database connection
require_once "db_config.php";

// Check if token is provided in URL
if (!isset($_GET["token"])) {
    // Redirect to forgot password page if token is not provided
    header("Location: forgot_password.php");
    exit;
}

$token = $_GET["token"];

// Check if token exists in database
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION["error_message"] = "Invalid or expired token.";
    header("Location: forgot_password.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate passwords
    if ($new_password !== $confirm_password) {
        $_SESSION["error_message"] = "Passwords do not match.";
    } else {
        // Update password in database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
        $stmt->execute([$hashed_password, $token]);

        $_SESSION["success_message"] = "Password reset successfully. You can now login with your new password.";
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php
    // Display error message if any
    if (isset($_SESSION["error_message"])) {
        echo '<p style="color: red;">' . $_SESSION["error_message"] . '</p>';
        unset($_SESSION["error_message"]);
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?token=$token";?>">
        <label>New Password:</label>
        <input type="password" name="new_password" required>
        <br><br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>

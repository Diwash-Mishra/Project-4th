<?php
session_start();

// Database configuration
$host = "localhost"; // Your host name
$dbname = "project"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If connection fails, display error message
    die("Connection failed: " . $e->getMessage());
}

// Function to generate random token
function generateToken($length = 20) {
    return bin2hex(random_bytes($length));
}

// Function to send email
function sendEmail($to, $subject, $message) {
    // Use your preferred method for sending emails (e.g., PHPMailer, mail() function)
    // Here, we're using the mail() function for simplicity
    return mail($to, $subject, $message);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if email exists in database
    $stmt = $pdo->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate token
        $token = generateToken();

        // Store token in database
        $stmt = $pdo->prepare("UPDATE registration SET reset_token = ? WHERE email = ?");
        $stmt->execute([$token, $email]);

        // Compose email message
        $subject = "Reset Your Password";
        $message = "Please click the following link to reset your password:\n\n";
        $message .= "http://example.com/reset_password.php?token=$token";

        // Send email
        if (sendEmail($email, $subject, $message)) {
            $_SESSION["success_message"] = "An email with instructions to reset your password has been sent.";
        } else {
            $_SESSION["error_message"] = "Failed to send email. Please try again later.";
        }
    } else {
        $_SESSION["error_message"] = "No user found with that email address.";
    }

    // Redirect to the same page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <?php
    // Display success or error messages
    if (isset($_SESSION["success_message"])) {
        echo '<p style="color: green;">' . $_SESSION["success_message"] . '</p>';
        unset($_SESSION["success_message"]);
    } elseif (isset($_SESSION["error_message"])) {
        echo '<p style="color: red;">' . $_SESSION["error_message"] . '</p>';
        unset($_SESSION["error_message"]);
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>

<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables and error array
$name = $email = $number = $subject = $message = "";
$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if (!$name) {
        $errors[] = "Please enter your name.";
    }
    if (!$email) {
        $errors[] = "Please enter a valid email address.";
    }
    if (strlen($number) != 10) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }
    if (!$subject) {
        $errors[] = "Please enter the subject.";
    }
    if (!$message) {
        $errors[] = "Please write your message.";
    }

    if (empty($errors)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO message_of_customer (name, email, number, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $name, $email, $number, $subject, $message);

        if ($stmt->execute()) {
            $successMessage = "Message successfully sent!";
            // Clear the form fields
            $name = $email = $number = $subject = $message = "";
        } else {
            $errors[] = "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Check if the user clicked the logout button
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to index.php
    header("Location: index.php");
    exit;
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>project</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style for the logout button */
        #nevbar li button {
            background-color: red; /* Button background color */
            color: white; /* Button text color */
            padding: 8px 16px; /* Padding inside the button */
            border: none; /* Remove button border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Change cursor to pointer */
        }

        #nevbar li button:hover {
            background-color: darkred; /* Darker red on hover */
        }
    </style>
    <script>
        function confirmLogout() {
            if(confirm("Are you sure you want to log out?")) {
                window.location.href = "?logout=true"; // Redirect to logout if confirmed
            }
        }
    </script>
</head>
<body>
    <section id="header">
        <a href="#"><img src="Purano.png" class="logo" alt=""></a>
        <div>
            <ul id="nevbar">
                <li><a  href="Home.php">Home</a></li>
                <li><a href="Shop.php">Shop</a> </li>
                <li><a  href="About.php">About</a></li>
                <li><a class="active" href="Contact.php">Contact</a></li>
                <?php
                // Check if user is logged in
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo "<li>".$_SESSION['username']."</li>";
                    echo '<li><button onclick="confirmLogout()">Log Out</button></li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <section id="page-header">
        <h2>#Let's_Talk</h2>
        <p>LEAVE A MESSAGE. We love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our Location or Contact us Today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fal fa-map"></i>
                    <p>Damak Chowk,Jhapa,Nepal</p>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <p>PuranoPasal@gmail.com</p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>982-5988376, 981-4333211</p>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p>24/7 Available</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3565.6847068356724!2d87.6832794747039!3d26.658575676799604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e58e3d12958f45%3A0x116ac5ec99c5b042!2sDamak%20Multiple%20Campus!5e0!3m2!1sen!2snp!4v1705313146174!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section id="form-details">
        <form action="" method="post">
            <span>LEAVE A MESSAGE</span>
            <h2>We Love to hear from you</h2>
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            }
            if ($successMessage) {
                echo "<p style='color:green;'>$successMessage</p>";
            }
            ?>
            <input type="text" name="name" placeholder="Your Name" required value="<?php echo htmlspecialchars($name); ?>">
            <input type="email" name="email" placeholder="E-Mail" required value="<?php echo htmlspecialchars($email); ?>">
            <input type="text" name="number" placeholder="Number" required pattern="\d{10}" value="<?php echo htmlspecialchars($number); ?>">
            <input type="text" name="subject" placeholder="Subject" required value="<?php echo htmlspecialchars($subject); ?>">
            <textarea name="message" cols="30" rows="10" placeholder="Write your Message Here" required><?php echo htmlspecialchars($message); ?></textarea>
            <button type="submit" class="normal">Submit</button>
        </form>
        <div class="hamro-details">
            <div>
                <img src="diwash.jpg" alt="">
                <p><span>Diwash Mishra</span>Malik honi haha <br>Phone: 9825988376 <br>Email: Diwashmishra12345@gmail.com</p>
            </div>
            <div>
                <img src="puskar.jpg" alt="">
                <p><span>Puskar Magar</span>Malik honi haha <br>Phone: 981-4333211 <br>Email: Puskarmagar12345@gmail.com</p>
            </div>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="Purano.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong>Shivasatakshi 11 Dudhe Jhapa</p>
            <p><strong>Phone: </strong>982-5988376, 981-4333211</p>
            <p><strong>Hours </strong>24/7 Available</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="#">About Us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>
        <div class="install">
            <h4>Coming Soon</h4>
            <p>In PlayStore </p>
            <div class="row">
                <img src="play.jpg" alt="">
            </div>
            <p><strong> Gateway </strong></p>
            <img class="esewa" src="esewa.jpg" alt="">
        </div>
        <div class="copyright">
            <p>Purano Pasal is Copyrighted under the Registrar of Copyright Act (Govt of Nepal) © 2000-2024</p>
        </div>
    </footer>
</body>
</html>

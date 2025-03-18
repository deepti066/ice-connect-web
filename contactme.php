<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("./mailing/mailfunction.php");

// Database Connection
$servername = "localhost";
$username = "root";
$password = "password";
$database = "contact_form_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("405 Method Not Allowed - Please use a POST request.");
}


$name = htmlspecialchars($_POST["name"]);
$phone = htmlspecialchars($_POST["phone"]);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST["message"]);
$captcha = $_POST["captcha"];

// CAPTCHA Validation
if (!isset($_SESSION["captcha"]) || $captcha != $_SESSION["captcha"]) {
    die("<h1>Incorrect CAPTCHA! Please try again.</h1><a href='contact.html'>Go Back</a>");
}

// Insert into MySQL
$sql = "INSERT INTO contacts (name, phone, email, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $phone, $email, $message);

if ($stmt->execute()) {
    // Send Email
    $body = "<ul>
                <li>Name: ".$name."</li>
                <li>Phone: ".$phone."</li>
                <li>Email: ".$email."</li>
                <li>Message: ".$message."</li>
             </ul>";

    $status = mailfunction("", "Company", $body);

    echo $status ? "<h1>Thanks! We will contact you soon.</h1>" : "<h1>Message saved, but email sending failed.</h1>";
} else {
    echo "<h1>Error saving message! Please try again.</h1>";
}

// Close connection
$stmt->close();
$conn->close();
?>

<?php
header('Content-Type: application/json'); // Set JSON response header


// Include config file to load environment variables
require_once "config.php";

// Database Connection using .env variables
$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_DATABASE');


// Database Connection
// $servername = "localhost";
// $username = "root";
// $password = "Optinet2025##";
// $database = "contact_form_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "405 Method Not Allowed - Please use a POST request."]);
    exit();
}

// Sanitize input
$name = htmlspecialchars($_POST["name"]);
$phone = htmlspecialchars($_POST["phone"]);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST["message"]);
// $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Google reCAPTCHA Secret Key
$secretKey = '6LfUM_kqAAAAAKS-eoYgSyL8-Q2SEDPhIHnIa0wk'; 

// Verify reCAPTCHA
// if (!empty($captchaResponse)) {
//     $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}");
//     $response = json_decode($verifyResponse);

//     if (!$response->success) {
//         echo json_encode(["status" => "error", "message" => "reCAPTCHA verification failed. Please try again."]);
//         exit();
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "Please complete the reCAPTCHA."]);
//     exit();
// }

// Insert into MySQL using Prepared Statements
$sql = $conn->prepare("INSERT INTO contacts (name, phone, email, message) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $name, $phone, $email, $message);

if ($sql->execute()) {
    echo json_encode(["status" => "success", "message" => "Thanks! We'll get back to you soon."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error: " . $sql->error]);
}

$sql->close();
$conn->close();
exit();
?>

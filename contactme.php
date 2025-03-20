<?php
// Database Connection
$servername = "localhost";
$username = "root"; 
$password = "password";
$database = "contact_form_db"; 

$conn = new mysqli($servername, $username, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(["status" => "error", "message" => "405 Method Not Allowed - Please use a POST request."]));
}

// Sanitize input
$name = htmlspecialchars($_POST["name"]);
$phone = htmlspecialchars($_POST["phone"]);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars($_POST["message"]);

// Google reCAPTCHA Secret Key
$secretKey = '6LfUM_kqAAAAAKS-eoYgSyL8-Q2SEDPhIHnIa0wk'; 
$captchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Verify reCAPTCHA
if (!empty($captchaResponse)) {
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}");
    $response = json_decode($verifyResponse);

    if (!$response->success) {
        echo json_encode(["status" => "error", "message" => "reCAPTCHA verification failed. Please try again."]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Please complete the reCAPTCHA."]);
    exit();
}

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

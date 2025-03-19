<?php   
    // require("./mailing/mailfunction.php");

    //print_r($_SERVER["REQUEST_METHOD"] );
    //exit();
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

// Insert into MySQL
$sql = "INSERT INTO contacts (name, phone, email, message) VALUES ('".$name."', '".$phone."', '".$email."', '".$message."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
  header("Location: http://iceconnectisp.local/html/contact-us.html");

//   redirect to html/contact-us.html

    $name = $_POST["name"];
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $message = $_POST["message"];

    

    $body = "<ul><li>Name: ".$name."</li><li>Phone: ".$phone."</li><li>Email: ".$email."</li><li>Message: ".$message."</li></ul>";

    // $status = mailfunction("", "Company", $body); //reciever
    // if($status)
    //     echo '<center><h1>Thanks! We will contact you soon.</h1></center>';
    // else
    //     echo '<center><h1>Error sending message! Please try again.</h1></center>';    
?>
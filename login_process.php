<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "user_auth";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Find user in database
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Start session and redirect to a welcome page
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
        
        header("Location: welcome.php");
        exit();
    } else {
        echo "Invalid password. <a href='Login.html'>Try again</a>";
    }
} else {
    echo "No user found with that email. <a href='SignUp.html'>Sign up</a>";
}

$conn->close();
?>
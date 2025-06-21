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
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate inputs
$errors = [];

// Check if email already exists
$check_email = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($check_email);
if ($result->num_rows > 0) {
    $errors[] = "Email already exists. Please use a different email.";
}

// Check if passwords match
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

// Check password length
if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

// If no errors, proceed with registration
if (empty($errors)) {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into database
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! <a href='Login.html'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Display errors
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo "<a href='SignUp.html'>Go back</a>";
}

$conn->close();
?>
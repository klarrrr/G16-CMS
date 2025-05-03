<?php

include 'connect.php';

// Sanitize inputs
$email = trim($_POST['email']);
$pass = $_POST['password'];
$re_pass = $_POST['re_password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@plpasig.edu.ph')) {
    echo "Invalid PLPasig email address.";
    exit;
}

if (strlen($pass) < 8) {
    echo "Password must be at least 8 characters.";
    exit;
}

if ($pass !== $re_pass) {
    echo "Passwords do not match.";
    exit;
}

$hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $hashedPassword);

if ($stmt->execute()) {
    header("Location: sample-page.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// i-iistore sa $session (cookies)
//  ma aaccess yung session sa secure HTTPS
// 


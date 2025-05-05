<?php
// Return JSON format
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'php-backend/connect.php';

// Get inputs safely
$first = trim($_POST['first'] ?? '');
$last = trim($_POST['last'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass = trim($_POST['pass'] ?? '');

// Validate fields
if (empty($first) || empty($last) || empty($email) || empty($pass)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@plpasig.edu.ph')) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid PLPasig email format.']);
    exit;
}

// Check if email already exists
$check = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    $check->close();
    $conn->close();
    exit;
}
$check->close();

// Insert user with plain password (⚠️ not secure for production)
$stmt = $conn->prepare("INSERT INTO users (user_first_name, user_last_name, user_email, user_pass, date_created) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("ssss", $first, $last, $email, $pass);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed.']);
}

$stmt->close();
$conn->close();
?>

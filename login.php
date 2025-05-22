<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/php-backend/connect.php';
session_start();

$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';

if (empty($email) || empty($pass)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
    exit;
}

// Prepare SQL to fetch the user with the email
$stmt = $conn->prepare("SELECT user_id, user_first_name, user_last_name, user_type, user_email, profile_picture, cover_photo, user_pass FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if user found
if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $user_first, $user_last, $user_type, $user_email, $profile_picture, $cover_photo, $db_pass);
    $stmt->fetch();

    // ✅ Check plain text password (not hashed)
    if (password_verify($pass, $db_pass)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_first'] = $user_first;
        $_SESSION['user_last'] = $user_last;
        $_SESSION['user_type'] = ucwords($user_type);
        $_SESSION['user_email'] = $user_email;
        $_SESSION['profile_picture'] = $profile_picture;
        $_SESSION['cover_photo'] = $cover_photo;
        echo json_encode([
            'status' => 'success'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
}

$stmt->close();
$conn->close();

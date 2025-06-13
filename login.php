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

$stmt = $conn->prepare("SELECT user_id, user_first_name, user_last_name, user_type, user_email, profile_picture, cover_photo, user_pass FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $user_first, $user_last, $user_type, $user_email, $profile_picture, $cover_photo, $db_pass);
    $stmt->fetch();

    if (password_verify($pass, $db_pass)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_first'] = $user_first;
        $_SESSION['user_last'] = $user_last;
        $_SESSION['user_type'] = ucwords($user_type);
        $_SESSION['user_email'] = $user_email;
        $_SESSION['profile_picture'] = $profile_picture;
        $_SESSION['cover_photo'] = $cover_photo;

        $redirect = (strtolower($user_type) === 'admin') ? 'admin-dashboard.php' : 'editor-dashboard.php';

        echo json_encode([
            'status' => 'success',
            'redirect' => $redirect,
            'user_type' => strtolower($user_type)
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
    }
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close(); 

$stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM admin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($admin_id, $first_name, $last_name, $admin_email, $admin_pass);
    $stmt->fetch();

    if (password_verify($pass, $admin_pass)) {
        $_SESSION['user_id'] = $admin_id;
        $_SESSION['user_first'] = $first_name;
        $_SESSION['user_last'] = $last_name;
        $_SESSION['user_type'] = 'Admin';
        $_SESSION['user_email'] = $admin_email;
        $_SESSION['profile_picture'] = null;
        $_SESSION['cover_photo'] = null;

        echo json_encode([
            'status' => 'success',
            'redirect' => 'admin-dashboard.php',
            'user_type' => 'admin'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
}

$stmt->close();
$conn->close();

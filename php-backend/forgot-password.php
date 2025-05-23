<?php
include 'connect.php';
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';

if (empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

// Check if email exists in the system
$stmt = $conn->prepare("SELECT user_id, user_first_name, user_last_name FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Email not found in our system']);
    exit;
}

$user = $result->fetch_assoc();
$userId = $user['user_id'];
$userName = $user['user_first_name'] . ' ' . $user['user_last_name'];

// Insert password reset request into admin inbox
$subject = "Password Reset Request";
$message = "User: $userName ($email) has requested a password reset.\n\nPlease reset their password and notify them.";

$insertStmt = $conn->prepare("
    INSERT INTO inbox 
    (sender_first_name, sender_last_name, sender_email, subject, message) 
    VALUES (?, ?, ?, ?, ?)
");

$adminFirstName = "System";
$adminLastName = "Notification";
$adminEmail = "no-reply@plpasig.edu.ph";

$insertStmt->bind_param(
    "sssss",
    $adminFirstName,
    $adminLastName,
    $adminEmail,
    $subject,
    $message
);

if ($insertStmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send request. Please try again.']);
}

$stmt->close();
$insertStmt->close();
$conn->close();

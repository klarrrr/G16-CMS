<?php
include 'connect.php';

header('Content-Type: application/json');

$messageId = intval($_POST['message_id'] ?? 0);
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Basic validation
if ($messageId <= 0 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

// In a real implementation, you would send the email here
// This is a placeholder for the email sending logic
$emailSent = true; // Assume email was sent successfully

if ($emailSent) {
    // Mark message as replied in database
    $query = "UPDATE inbox SET replied = 1 WHERE inbox_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $messageId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to send email']);
}

mysqli_close($conn);

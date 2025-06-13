<?php
include 'connect.php';

header('Content-Type: application/json');

$userId = $_POST['user_id'] ?? null;
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$userType = $_POST['user_type'] ?? 'writer';
$password = $_POST['password'] ?? '';

if (!$userId || !$firstName || !$lastName || !$email || !$userType) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

// Check if email is being changed to one that already exists
$checkStmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ? AND user_id != ?");
$checkStmt->bind_param("si", $email, $userId);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Email already in use by another user']);
    $checkStmt->close();
    exit;
}
$checkStmt->close();

// Prepare base query
$query = "UPDATE users SET 
            user_first_name = ?, 
            user_last_name = ?, 
            user_email = ?, 
            user_type = ?, 
            date_updated = CURRENT_TIMESTAMP()";
$types = "ssss";
$params = [$firstName, $lastName, $email, $userType];

// Add password update if provided
if (!empty($password)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query .= ", user_pass = ?";
    $types .= "s";
    $params[] = $passwordHash;
}

$query .= " WHERE user_id = ?";
$types .= "i";
$params[] = $userId;

$stmt = $conn->prepare($query);

 $stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => !empty($password) ? 'User and password updated successfully' : 'User updated successfully'
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update user: ' . $conn->error]);
}

$stmt->close();
$conn->close();

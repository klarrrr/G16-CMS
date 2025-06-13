<?php
include 'connect.php';

header('Content-Type: application/json');

$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$userType = $_POST['user_type'] ?? 'writer';
$password = $_POST['password'] ?? '';

if (!$firstName || !$lastName || !$email || !$userType) {
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

// Check if email already exists
$checkStmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Email already exists']);
    $checkStmt->close();
    exit;
}
$checkStmt->close();

if (empty($password)) {
    $password = bin2hex(random_bytes(8)); // Generate random password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
} else {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
}

$stmt = $conn->prepare("INSERT INTO users (user_first_name, user_last_name, user_email, user_pass, user_type) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $firstName, $lastName, $email, $passwordHash, $userType);

if ($stmt->execute()) {
    $newUserId = $stmt->insert_id;

    $defaultProfile = 'default-profile.png';
    $defaultCover = 'default-cover.png';

    $updateStmt = $conn->prepare("UPDATE users SET profile_picture = ?, cover_photo = ? WHERE user_id = ?");
    $updateStmt->bind_param("ssi", $defaultProfile, $defaultCover, $newUserId);
    $updateStmt->execute();
    $updateStmt->close();

    echo json_encode([
        'success' => true,
        'id' => $newUserId,
        'message' => empty($_POST['password']) ? 'User created with generated password' : 'User created successfully'
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to add user: ' . $conn->error]);
}

$stmt->close();
$conn->close();

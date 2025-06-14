<?php
session_start();
include 'connect.php';

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authorized']);
    exit;
}

$user_id = $_POST['user_id'];

if ($user_id != $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'User mismatch']);
    exit;
}

$query = "SELECT cover_photo FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Default image path
$default_image = 'pics/plp-outside.jpg';

if (!empty($user['cover_photo']) && $user['cover_photo'] !== $default_image) {
    try {
        if (file_exists($user['cover_photo']) && $user['cover_photo'] !== $default_image) {
            if (!unlink($user['cover_photo'])) {
                throw new Exception('Failed to delete old image file');
            }
        }
        
        // Update database
        $update_query = "UPDATE users SET cover_photo = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $default_image, $user_id);
        
        if (!$update_stmt->execute()) {
            throw new Exception('Database update failed');
        }
        
        // Update session
        $_SESSION['cover_photo'] = $default_image;
        
        echo json_encode(['success' => true]);
        $update_stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => true]);
}

$conn->close();
?>
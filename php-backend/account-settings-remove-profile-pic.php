<?php
session_start();
include 'connect.php';

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authorized']);
    exit;
}

// Get user ID from POST data
$user_id = $_POST['user_id'];

// Validate user ID matches session
if ($user_id != $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'User mismatch']);
    exit;
}

// Get current profile picture path
$query = "SELECT profile_picture FROM users WHERE user_id = ?";
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
$default_image = 'pics/no-pic.jpg';

// Only proceed if current image is not already the default
if (!empty($user['profile_picture']) && $user['profile_picture'] !== $default_image) {
    try {
        // Delete the old file if it exists and isn't the default
        if (file_exists($user['profile_picture']) && $user['profile_picture'] !== $default_image) {
            if (!unlink($user['profile_picture'])) {
                throw new Exception('Failed to delete old image file');
            }
        }
        
        // Update database
        $update_query = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $default_image, $user_id);
        
        if (!$update_stmt->execute()) {
            throw new Exception('Database update failed');
        }
        
        // Update session
        $_SESSION['profile_picture'] = $default_image;
        
        echo json_encode(['success' => true]);
        $update_stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    // Already using default image - return success
    echo json_encode(['success' => true]);
}

$conn->close();
?>
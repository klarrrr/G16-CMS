<?php
session_start();
include 'connect.php';

$user_id = $_POST['user_id'];

// Get current profile picture path
$query = "SELECT profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Only proceed if there's an image to remove
if (!empty($user['profile_picture']) && $user['profile_picture'] !== 'pics/no-pic.jpg') {
    // Delete the file from server if it exists
    if (file_exists($user['profile_picture'])) {
        unlink($user['profile_picture']);
    }
    
    // Update database with default image path
    $update_query = "UPDATE users SET profile_picture = 'pics/no-pic.jpg' WHERE user_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("i", $user_id);
    
    if ($update_stmt->execute()) {
        $_SESSION['profile_picture'] = 'pics/no-pic.jpg';
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update database']);
    }
    
    $update_stmt->close();
} else {
    // No image to remove, but return success anyway
    echo json_encode(['success' => true]);
}

$conn->close();
?>
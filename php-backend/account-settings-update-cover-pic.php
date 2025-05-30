<?php
session_start();
include 'connect.php';

$response = ['status' => 'error', 'message' => ''];

if (isset($_POST['user_id'], $_POST['base64String'])) {
    $user_id = (int) $_POST['user_id'];
    $base64String = $_POST['base64String'];

    // Decode Base64 string
    $imageData = base64_decode($base64String);
    if ($imageData === false) {
        $response['message'] = 'Invalid Base64 string.';
        echo json_encode($response);
        exit;
    }

    // Create upload directory if it doesn't exist
    $uploadDir = '../uploaded-pics/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename
    $fileName = 'cover_' . $user_id . '_' . time() . '.png';
    $filePath = $uploadDir . $fileName;
    $relativePath = 'uploaded-pics/' . $fileName;

    // Save decoded image
    if (file_put_contents($filePath, $imageData)) {
        // Update DB with path
        $query = "UPDATE users SET cover_photo = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $relativePath, $user_id);

        if ($stmt->execute()) {
            $_SESSION['cover_photo'] = $relativePath;
            $response['status'] = 'success';
            $response['filePath'] = $relativePath;
        } else {
            $response['message'] = 'Database update failed.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Failed to save image file.';
    }
} else {
    $response['message'] = 'Missing user_id or base64String.';
}

echo json_encode($response);

<?php
include 'connect.php';

$response = ['status' => 'error', 'message' => '', 'filePath' => ''];

if (isset($_FILES['image']) && isset($_POST['article_id'])) {
    $article_id = (int) $_POST['article_id'];
    $file = $_FILES['image'];

    $uploadDir = '../uploaded-pics/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $fileName = basename($file['name']);
    $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName); 
    $targetFilePath = $uploadDir . $fileName;
    $relativePath = 'uploaded-pics/' . $fileName; 

    // Validate file type

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file['type'], $allowedTypes)) {
        $response['message'] = 'Invalid file type.';
    } elseif (move_uploaded_file($file['tmp_name'], $targetFilePath)) {

        $stmt = $conn->prepare("UPDATE widgets SET widget_img = ? WHERE article_owner = ?");
        $stmt->bind_param("si", $relativePath, $article_id);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['filePath'] = $relativePath;
        } else {
            $response['message'] = 'Database update failed.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'File upload failed.';
    }
} else {
    $response['message'] = 'Missing image file or article ID.';
}

echo json_encode($response);

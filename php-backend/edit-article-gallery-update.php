<?php

include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $article_id = $_POST['article_id'];
    $uploadedFiles = $_FILES['image_files'];  
    $user_owner = $_POST['user_owner'];

    $uploadDir = '../gallery/';

    if (isset($uploadedFiles['tmp_name']) && is_array($uploadedFiles['tmp_name'])) {
        foreach ($uploadedFiles['tmp_name'] as $index => $tmpName) {
            $fileName = basename($uploadedFiles['name'][$index]);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $filePath = $uploadDir . $fileName; 

                $stmt = $conn->prepare("INSERT INTO article_gallery (pic_path, article_owner, user_owner) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $filePath, $article_id, $user_owner);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
                }

                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No files uploaded.']);
    }
}

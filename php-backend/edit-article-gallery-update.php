<?php

include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $article_id = $_POST['article_id'];
    $uploadedFiles = $_FILES['image_files'];  // Array of the uploaded files
    $user_owner = $_POST['user_owner'];

    // Set the directory path for saving images
    $uploadDir = '../gallery/'; // Ensure this folder exists and is writable

    // Check if files were uploaded
    if (isset($uploadedFiles['tmp_name']) && is_array($uploadedFiles['tmp_name'])) {
        // Loop through each uploaded file and save it
        foreach ($uploadedFiles['tmp_name'] as $index => $tmpName) {
            $fileName = basename($uploadedFiles['name'][$index]);
            $targetPath = $uploadDir . $fileName;

            // Move uploaded file to the gallery directory
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Insert the image path into the database
                $filePath = $uploadDir . $fileName; // Store the relative path

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

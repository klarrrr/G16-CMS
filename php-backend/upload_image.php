<?php
$uploadDir = '../upload-images/';
$response = [];

if (isset($_FILES['image'])) {
    $fileName = basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    // Optionally validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['image']['type'], $allowedTypes)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Success! You can save just $fileName to DB
            $response = ['success' => true, 'filename' => $fileName];
        } else {
            $response = ['error' => 'Upload failed'];
        }
    } else {
        $response = ['error' => 'Invalid file type'];
    }
} else {
    $response = ['error' => 'No file received'];
}

echo json_encode($response);

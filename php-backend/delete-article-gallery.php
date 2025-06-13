<?php

include('connect.php');

$pic_id = $_POST['pic_id'];

// Fetch the image path from the database before deleting
$sql = "SELECT pic_path FROM article_gallery WHERE pic_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pic_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Get the file path 
$filePath = $row['pic_path'];  // stored in 'gallery/' directory

// Check if the file exists before deleting

if (file_exists($filePath)) {

    // Delete the image file from the server storage
    if (unlink($filePath)) {

        // Delete the record from the database
        $sql = "DELETE FROM article_gallery WHERE pic_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pic_id);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $stmt->error
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'File deletion failed.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'File does not exist.'
    ]);
}

$stmt->close();

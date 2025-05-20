<?php
header('Content-Type: application/json');
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];

    $sql = "SELECT archive_status FROM articles WHERE article_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        $stmt->bind_result($archive_status);
        if ($stmt->fetch()) {
            echo json_encode([
                'status' => 'success',
                'archive_status' => $archive_status
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Article not found.'
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to prepare statement.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}

$conn->close();

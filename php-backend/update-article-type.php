<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;
    $article_type = $_POST['article_type'] ?? null;

    if (!$article_id || !$article_type) {
        echo json_encode(['status' => 'error', 'message' => 'Missing data']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE articles SET article_type = ? WHERE article_id = ?");
    $stmt->bind_param("si", $article_type, $article_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

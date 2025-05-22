<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;

    if (!$article_id) {
        echo json_encode(['status' => 'error', 'message' => 'Missing article ID']);
        exit;
    }

    $stmt = $conn->prepare("SELECT article_type FROM articles WHERE article_id = ?");
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $stmt->bind_result($article_type);

    if ($stmt->fetch()) {
        echo json_encode(['status' => 'success', 'article_type' => $article_type]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Article not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

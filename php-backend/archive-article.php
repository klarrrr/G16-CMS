<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'];

    $getStatusSQL = "SELECT archive_status FROM articles WHERE article_id = ?";
    $stmt = $conn->prepare($getStatusSQL);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $stmt->bind_result($currentStatus);
    $stmt->fetch();
    $stmt->close();

    $newStatus = ($currentStatus === 'archived') ? 'active' : 'archived';

    $updateSQL = "UPDATE articles SET archive_status = ? WHERE article_id = ?";

    $stmt = $conn->prepare($updateSQL);
    if ($stmt) {
        $stmt->bind_param("si", $newStatus, $article_id);
        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => $newStatus === 'archived' ? 'Article archived successfully.' : 'Article unarchived successfully.',
                'archive_status' => $newStatus
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update article status.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare update statement.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();

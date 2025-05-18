<?php

include 'connect.php';

$commentId = $_POST['comment_id'];
$newCommentText = $_POST['comment_text'];

// Prepare the query
$stmt = $conn->prepare("UPDATE comments SET comment_content = ? WHERE comment_id = ?");
$stmt->bind_param("si", $newCommentText, $commentId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();

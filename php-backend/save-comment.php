<?php

include 'connect.php';

$commentText = $_GET['commentText'];
$userId = $_GET['user_id'];
$articleId = $_GET['article_id'];

// Use prepared statement to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO comments (comment_content, user_owner, article_owner) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $commentText, $userId, $articleId);
$stmt->execute();

// Get the last inserted comment ID securely
$latestCommentId = $conn->insert_id;

// Return as JSON
echo json_encode(["comment_id" => $latestCommentId]);

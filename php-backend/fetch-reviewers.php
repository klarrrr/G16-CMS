<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

$query = "SELECT u.user_id, u.user_first_name, u.user_last_name 
          FROM users u
          WHERE u.user_type = 'reviewer'
          AND u.user_id NOT IN (
              SELECT reviewer_id 
              FROM article_review_invites 
              WHERE article_id = ? AND status != 'rejected'
          )";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['article_id']);
$stmt->execute();
$result = $stmt->get_result();

$reviewers = [];
while ($row = $result->fetch_assoc()) {
    $reviewers[] = $row;
}

echo json_encode($reviewers);

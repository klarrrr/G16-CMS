<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

// Verify user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

$article_id = $_GET['article_id'] ?? null;
if (!$article_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Article ID required']));
}

$query = "SELECT i.invite_id, i.status, 
                 u.user_id, u.user_first_name, u.user_last_name
          FROM article_review_invites i
          JOIN users u ON i.reviewer_id = u.user_id
          WHERE i.article_id = ?
          ORDER BY i.invite_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

$invites = [];
while ($row = $result->fetch_assoc()) {
    $invites[] = $row;
}

echo json_encode($invites);

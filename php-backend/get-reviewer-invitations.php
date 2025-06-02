<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

$status = $_GET['status'] ?? 'pending';
$reviewer_id = $_SESSION['user_id'];

$query = "SELECT i.invite_id, i.status, i.invite_date,
                 a.article_id, a.article_title,
                 CONCAT(u.user_first_name, ' ', u.user_last_name) as inviter_name
          FROM article_review_invites i
          JOIN articles a ON i.article_id = a.article_id
          JOIN users u ON i.inviter_id = u.user_id
          WHERE i.reviewer_id = ? AND i.status = ?
          ORDER BY i.invite_date DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("is", $reviewer_id, $status);
$stmt->execute();
$result = $stmt->get_result();

$invitations = [];
while ($row = $result->fetch_assoc()) {
    $invitations[] = $row;
}

echo json_encode($invitations);

<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

$invite_id = $_POST['invite_id'] ?? null;
if (!$invite_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Invite ID required']));
}

// Verify user owns the invitation
$checkQuery = "SELECT i.inviter_id 
               FROM article_review_invites i
               JOIN articles a ON i.article_id = a.article_id
               WHERE i.invite_id = ? AND (i.inviter_id = ? OR a.user_owner = ?)";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("iii", $invite_id, $_SESSION['user_id'], $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    die(json_encode(['error' => 'You cannot cancel this invitation']));
}

// Update status to rejected
$updateQuery = "UPDATE article_review_invites SET status = 'rejected' WHERE invite_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $invite_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to cancel invitation']);
}

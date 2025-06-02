<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

$invite_id = $_POST['invite_id'] ?? null;
$response = $_POST['response'] ?? null;

if (!$invite_id || !in_array($response, ['accepted', 'rejected'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid request']));
}

// Verify the invite belongs to the current user
$checkQuery = "SELECT invite_id FROM article_review_invites 
               WHERE invite_id = ? AND reviewer_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("ii", $invite_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    die(json_encode(['error' => 'Not authorized to respond to this invitation']));
}

// Update the invitation status
$updateQuery = "UPDATE article_review_invites SET status = ? WHERE invite_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("si", $response, $invite_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Invitation updated']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update invitation']);
}

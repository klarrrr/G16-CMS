<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

// Verify user is logged in and is the article owner
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    die(json_encode(['error' => 'Unauthorized']));
}

$data = json_decode(file_get_contents('php://input'), true);
$article_id = $data['article_id'] ?? null;
$reviewer_id = $data['reviewer_id'] ?? null;

// Validate input
if (!$article_id || !$reviewer_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Missing required fields']));
}

// Check if user owns the article
$checkQuery = "SELECT user_owner FROM articles WHERE article_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    die(json_encode(['error' => 'Article not found']));
}

$article = $result->fetch_assoc();
if ($article['user_owner'] != $_SESSION['user_id']) {
    http_response_code(403);
    die(json_encode(['error' => 'You can only invite reviewers for your own articles']));
}

// Check if invitation already exists (pending or accepted)
$inviteQuery = "SELECT invite_id, status FROM article_review_invites 
                WHERE article_id = ? AND reviewer_id = ?";
$stmt = $conn->prepare($inviteQuery);
$stmt->bind_param("ii", $article_id, $reviewer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $existingInvite = $result->fetch_assoc();

    // If invitation is already pending or accepted
    if ($existingInvite['status'] != 'rejected') {
        http_response_code(400);
        die(json_encode(['error' => 'Reviewer already invited']));
    }

    // If invitation was previously rejected, update it to pending
    $updateQuery = "UPDATE article_review_invites 
                    SET status = 'pending', 
                        invite_date = NOW(),
                        inviter_id = ?
                    WHERE invite_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $_SESSION['user_id'], $existingInvite['invite_id']);

    if ($stmt->execute()) {
        // TODO: Send notification to reviewer
        echo json_encode(['success' => true, 'message' => 'Invitation resent successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to resend invitation']);
    }
    exit;
}

// Create new invitation if no existing record found
$insertQuery = "INSERT INTO article_review_invites 
                (article_id, reviewer_id, inviter_id, status, invite_date) 
                VALUES (?, ?, ?, 'pending', NOW())";
$stmt = $conn->prepare($insertQuery);
$stmt->bind_param("iii", $article_id, $reviewer_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    // TODO: Send notification to reviewer
    echo json_encode(['success' => true, 'message' => 'Invitation sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to send invitation']);
}

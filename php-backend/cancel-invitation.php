<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

$invite_id = $_POST['invite_id'] ?? null;
$article_id = $_POST['article_id'] ?? null;

if (!$invite_id) {
    http_response_code(400);
    die(json_encode(['error' => 'Invite ID required']));
}

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

$updateQuery = "UPDATE article_review_invites SET status = 'rejected' WHERE invite_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("i", $invite_id);

if ($stmt->execute()) {
    checkAllReviewsApproved($conn, $article_id);
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to cancel invitation']);
}

function checkAllReviewsApproved($conn, $articleId) {
    $query = "
    SELECT 
    COUNT(DISTINCT ari.invite_id) AS total_reviewers,
    SUM(CASE WHEN ar.decision = 'approved' THEN 1 ELSE 0 END) AS approved_reviews
    FROM 
    article_review_invites ari
    LEFT JOIN 
    article_reviews ar ON ari.invite_id = ar.invite_id
    WHERE 
    ari.article_id = ?
    AND
    ari.status != 'rejected'
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    
    if ($stats['total_reviewers'] > 0 && $stats['approved_reviews'] == $stats['total_reviewers']) {
        $updateArticle = "UPDATE articles SET approve_status = 'yes' WHERE article_id = ?";
        $stmt = $conn->prepare($updateArticle);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
    }else{
        $updateArticle = "UPDATE articles SET approve_status = 'no' WHERE article_id = ?";
        $stmt = $conn->prepare($updateArticle);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
    }
}
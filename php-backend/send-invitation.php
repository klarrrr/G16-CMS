<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

$now = date('Y-m-d H:i:s', time());

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

$conn->begin_transaction(); // Start transaction

try {
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
        $stmt->execute();

        // Update or create review record
        // First check if review exists for this invite
        $checkQuery = "SELECT review_id FROM article_reviews WHERE invite_id = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("i", $existingInvite['invite_id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Update existing review
            $reviewQuery = "UPDATE article_reviews 
                            SET decision = 'unapproved', 
                                comments = 'Pending review',
                                review_date = NOW()
                            WHERE invite_id = ?";
        } else {
            // Insert new review
            $reviewQuery = "INSERT INTO article_reviews 
                            (invite_id, decision, comments, review_date)
                            VALUES (?, 'unapproved', 'Pending review', NOW())";
        }

        $stmt = $conn->prepare($reviewQuery);
        $stmt->bind_param("i", $existingInvite['invite_id']);
        $stmt->execute();

        // Check and change approve status first
        checkAllReviewsApproved($conn, $article_id);

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Invitation resent successfully']);
        exit;
    }

    // Create new invitation if no existing record found
    $insertQuery = "INSERT INTO article_review_invites 
                    (article_id, reviewer_id, inviter_id, status, invite_date) 
                    VALUES (?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iii", $article_id, $reviewer_id, $_SESSION['user_id']);
    $stmt->execute();
    
    $newInviteId = $conn->insert_id;

    // Create default review record
    $reviewQuery = "INSERT INTO article_reviews 
                    (invite_id, decision, comments)
                    VALUES (?, 'unapproved', 'Pending review')";
    $stmt = $conn->prepare($reviewQuery);
    $stmt->bind_param("i", $newInviteId);
    $stmt->execute();

    $conn->commit();

    // Check and change approve status first
    checkAllReviewsApproved($conn, $article_id);
    
    echo json_encode(['success' => true, 'message' => 'Invitation sent successfully']);
    
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to process invitation: ' . $e->getMessage()]);
    exit;
}


// Function to check if all reviewers have approved
function checkAllReviewsApproved($conn, $articleId) {
    // Get all accepted invitations for this article
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
    
    // If all reviewers have approved, update article status
    if ($stats['total_reviewers'] > 0 && $stats['approved_reviews'] == $stats['total_reviewers']) {
        // If greater than 0 and total reviews and total reviewers are equal, set approve status to yes
        $updateArticle = "UPDATE articles SET approve_status = 'yes' WHERE article_id = ?";
        $stmt = $conn->prepare($updateArticle);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
    }else{
        // If 0 or less, update approve status to no
        $updateArticle = "UPDATE articles SET approve_status = 'no' WHERE article_id = ?";
        $stmt = $conn->prepare($updateArticle);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
    }
}
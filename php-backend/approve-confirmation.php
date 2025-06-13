<?php
include 'connect.php';

$articleId = $_POST['article_id'];
$userId = $_POST['user_id'];

// Get user type
$userType = null;
$query = "SELECT user_type FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $userType = strtolower($row['user_type']);
}
$stmt->close();

$response = ['status' => 'error', 'message' => 'Invalid user type'];

// Only reviewers can approve articles
if ($userType === 'reviewer') {
    // Check if user was invited to review this article
    $inviteQuery = "SELECT invite_id FROM article_review_invites 
                   WHERE article_id = ? AND reviewer_id = ? AND status = 'accepted'";
    $stmt = $conn->prepare($inviteQuery);
    $stmt->bind_param("ii", $articleId, $userId);
    $stmt->execute();
    $inviteResult = $stmt->get_result();
    
    if ($inviteResult->num_rows > 0) {
        $invite = $inviteResult->fetch_assoc();
        $inviteId = $invite['invite_id'];
        
        // Check if review already exists
        $reviewQuery = "SELECT review_id FROM article_reviews WHERE invite_id = ?";
        $stmt = $conn->prepare($reviewQuery);
        $stmt->bind_param("i", $inviteId);
        $stmt->execute();
        $reviewResult = $stmt->get_result();
        
        if ($reviewResult->num_rows > 0) {
            // Update existing review
            $updateQuery = "UPDATE article_reviews 
                           SET decision = IF(decision = 'approved', 'unapproved', 'approved'),
                               review_date = CURRENT_TIMESTAMP()
                           WHERE invite_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("i", $inviteId);
            $stmt->execute();
            
            $response = [
                'status' => 'success',
                'action' => $stmt->affected_rows > 0 ? 'updated' : 'unchanged',
                'decision' => $stmt->affected_rows > 0 ? 
                    ($_POST['decision'] ?? 'toggle') : 'no_change'
            ];
        } else {
            // Create new review 
            $insertQuery = "INSERT INTO article_reviews 
                          (invite_id, decision, comments) 
                          VALUES (?, 'approved', 'Approved via system')";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("i", $inviteId);
            $stmt->execute();
            
            $response = [
                'status' => 'success',
                'action' => 'created',
                'decision' => 'approved'
            ];
        }
        
        // Check if all reviewers have approved
        checkAllReviewsApproved($conn, $articleId);
    } else {
        $response = ['status' => 'error', 'message' => 'Not authorized to review this article'];
    }
}

echo json_encode($response);

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
?>
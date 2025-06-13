<?php

header('Content-Type: application/json');



// Database connection

require_once 'connect.php';



// Get POST data

$article_id = isset($_POST['article_id']) ? intval($_POST['article_id']) : null;

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;



// Validate input

if (!$article_id || !$user_id) {

    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);

    exit;
}



try {

    // Begin transaction

    $conn->begin_transaction();



    //First find the invite_id for this user and article

    $findInviteQuery = "SELECT invite_id FROM article_review_invites 

                       WHERE article_id = ? AND reviewer_id = ?";

    $stmt = $conn->prepare($findInviteQuery);

    $stmt->bind_param("ii", $article_id, $user_id);

    $stmt->execute();

    $result = $stmt->get_result();



    if ($result->num_rows === 0) {

        throw new Exception("No invitation found for this user and article");
    }



    $invite = $result->fetch_assoc();

    $invite_id = $invite['invite_id'];



    // Delete from article_reviews (if exists)

    $deleteReviewQuery = "DELETE FROM article_reviews WHERE invite_id = ?";

    $stmt = $conn->prepare($deleteReviewQuery);

    $stmt->bind_param("i", $invite_id);

    $stmt->execute();



    // Delete from article_review_invites

    $deleteInviteQuery = "DELETE FROM article_review_invites WHERE invite_id = ?";

    $stmt = $conn->prepare($deleteInviteQuery);

    $stmt->bind_param("i", $invite_id);

    $stmt->execute();



    // Commit transaction

    $conn->commit();



    checkAllReviewsApproved($conn, $article_id);



    // Return success

    echo json_encode([

        'status' => 'success',

        'message' => 'Successfully unsubscribed as reviewer'

    ]);
} catch (Exception $e) {

    // Rollback transaction on error

    $conn->rollback();

    echo json_encode([

        'status' => 'error',

        'message' => 'Failed to unsubscribe: ' . $e->getMessage()

    ]);
}


$conn->close();



// Function to check if all reviewers have approved

function checkAllReviewsApproved($conn, $articleId)
{

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
    } else {

        // If 0 or less, update approve status to no

        $updateArticle = "UPDATE articles SET approve_status = 'no' WHERE article_id = ?";

        $stmt = $conn->prepare($updateArticle);

        $stmt->bind_param("i", $articleId);

        $stmt->execute();
    }
}

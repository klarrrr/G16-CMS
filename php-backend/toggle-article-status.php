<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;
    $date_posted = $_POST['date_posted'] ?? null;
    $date_expired = $_POST['date_expired'] ?? null;

    // Validate required fields
    if (!$article_id || !$date_posted || !$date_expired) {
        echo json_encode(['status' => 'error', 'message' => 'Missing data.']);
        exit;
    }

    try {
        // Get current status
        $stmt = $conn->prepare("SELECT completion_status, user_owner FROM articles WHERE article_id = ?");
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        $stmt->bind_result($current_status, $article_author);
        $stmt->fetch();
        $stmt->close();

        if (!$current_status) {
            echo json_encode(['status' => 'error', 'message' => 'Article not found.']);
            exit;
        }

        // Determine new status
        $new_status = ($current_status === 'published') ? 'draft' : 'published';

        // Only check review approvals when trying to publish (not when unpublishing)
        if ($new_status === 'published') {
            // Check if article has any reviewers assigned
            $hasReviewers = hasReviewers($article_id, $conn);

            if ($hasReviewers) {
                // Verify all reviewers have approved
                $canPublish = canPublishArticle($article_id, $conn);

                if (!$canPublish) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Cannot publish - not all reviewers have approved yet.'
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Cannot publish - assign reviewers first to approve your article.'
                ]);
                exit;
            }
        }

        // Determine archive status
        $currentDate = date('Y-m-d H:i:s');
        $archive_status = ($currentDate > $date_expired) ? 'archived' : 'active';

        $conn->begin_transaction();

        // Update article
        $stmt1 = $conn->prepare("UPDATE articles SET date_posted = ?, date_expired = ?, archive_status = ?, completion_status = ? WHERE article_id = ?");
        $stmt1->bind_param("ssssi", $date_posted, $date_expired, $archive_status, $new_status, $article_id);
        $stmt1->execute();
        $stmt1->close();

        // Update widgets
        $stmt2 = $conn->prepare("UPDATE widgets SET date_posted = ?, date_expired = ? WHERE article_owner = ?");
        $stmt2->bind_param("ssi", $date_posted, $date_expired, $article_id);
        $stmt2->execute();
        $stmt2->close();

        $conn->commit();
        echo json_encode(['status' => 'success', 'new_status' => $new_status]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}


// Check if article has any reviewers assigned

function hasReviewers($article_id, $conn)
{
    $query = "SELECT COUNT(*) as total FROM article_review_invites WHERE article_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    return $stats['total'] > 0;
}


// Check if article can be published (all reviewers approved)

function canPublishArticle($article_id, $conn)
{
    $query = "SELECT COUNT(*) as total, 
                     SUM(CASE WHEN status = 'accepted' THEN 1 ELSE 0 END) as accepted
              FROM article_review_invites
              WHERE article_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();

    // Article can be published if all invited reviewers have accepted
    return ($stats['total'] > 0) && ($stats['accepted'] == $stats['total']);
}

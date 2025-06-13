<?php
// check-review-status.php
header('Content-Type: application/json');
require_once 'connect.php';

$article_id = isset($_GET['article_id']) ? intval($_GET['article_id']) : null;
$reviewer_id = isset($_GET['reviewer_id']) ? intval($_GET['reviewer_id']) : null;

if (!$article_id || !$reviewer_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

try {
    $query = "SELECT ar.decision 
              FROM article_reviews ar
              JOIN article_review_invites ari ON ar.invite_id = ari.invite_id
              WHERE ari.article_id = ? AND ari.reviewer_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $article_id, $reviewer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'decision' => $row['decision']]);
    } else {
        echo json_encode(['status' => 'success', 'decision' => 'unreviewed']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
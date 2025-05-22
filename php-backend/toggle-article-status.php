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
        $stmt = $conn->prepare("SELECT completion_status FROM articles WHERE article_id = ?");
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        $stmt->bind_result($current_status);
        $stmt->fetch();
        $stmt->close();

        if (!$current_status) {
            echo json_encode(['status' => 'error', 'message' => 'Article not found.']);
            exit;
        }

        $new_status = ($current_status === 'published') ? 'draft' : 'published';

        // Determine archive status
        $currentDate = date('Y-m-d H:i:s');
        $archive_status = ($currentDate > $date_expired) ? 'archived' : 'active';

        $conn->begin_transaction();

        // Update article
        $stmt1 = $conn->prepare("UPDATE articles SET date_posted = ?, date_expired = ?, archive_status = ?, completion_status = ? WHERE article_id = ?");
        $stmt1->bind_param("ssssi", $date_posted, $date_expired, $archive_status, $new_status, $article_id);
        $stmt1->execute();
        $stmt1->close();

        // Update widgets (optional)
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

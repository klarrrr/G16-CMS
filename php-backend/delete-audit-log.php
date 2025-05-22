<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $log_id = intval($_POST['log_id'] ?? 0);

    if ($log_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid log ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM audit_logs WHERE log_id = ?");
    $stmt->bind_param('i', $log_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete log.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

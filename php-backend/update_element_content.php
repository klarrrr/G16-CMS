<?php
include 'connect.php';
$now = date('Y-m-d H:i:s', time());
if (isset($_POST['element_id']) && isset($_POST['new_content'])) {
    $element_id = $_POST['element_id'];
    $new_content = json_encode(['content' => $_POST['new_content']]);

    $stmt = $conn->prepare("UPDATE elements SET content = ?, date_updated = '$now' WHERE element_id = ?");
    $stmt->bind_param("si", $new_content, $element_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'DB update failed']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Missing data']);
}

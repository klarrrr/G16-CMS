<?php
include 'connect.php';
session_start();

header('Content-Type: application/json');

// Check for required POST fields
if (empty($_POST['title']) || empty($_POST['content']) || empty($_POST['shortDesc'])) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$title = $_POST['title'];
$content = $_POST['content'];
$shortDesc = $_POST['shortDesc'];
$userOwner = $_SESSION['user_id'] ?? null;

if (!$userOwner) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Start transaction
$conn->begin_transaction();

try {
    $articleStmt = $conn->prepare("INSERT INTO articles (article_title, article_content, user_owner, edit_status, completion_status) VALUES (?, ?, ?, 'available', 'draft')");
    $articleStmt->bind_param("ssi", $title, $content, $userOwner);
    $articleStmt->execute();

    // Get inserted article ID
    $articleId = $conn->insert_id;

    // Insert into widgets
    $widgetStmt = $conn->prepare("INSERT INTO widgets (widget_title, widget_paragraph, article_owner, user_owner) VALUES (?, ?, ?, ?)");
    $widgetStmt->bind_param("ssii", $title, $shortDesc, $articleId, $userOwner);
    $widgetStmt->execute();

    // Commit transaction
    $conn->commit();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['error' => 'Failed to insert data', 'details' => $e->getMessage()]);
}

$conn->close();

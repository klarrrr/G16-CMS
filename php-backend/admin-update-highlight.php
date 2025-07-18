<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allArticleIds = array_keys($_POST['highlight'] ?? []);

    $resetQuery = "UPDATE articles SET highlight = 0";
    $stmt = $conn->prepare($resetQuery);
    $stmt->execute();

    if (!empty($allArticleIds)) {
        // Prepare placeholders for IN clause
        $placeholders = implode(',', array_fill(0, count($allArticleIds), '?'));

        $highlightQuery = "UPDATE articles SET highlight = 1 WHERE article_id IN ($placeholders)";
        $stmt = $conn->prepare($highlightQuery);

        // Bind parameters
        $types = str_repeat('i', count($allArticleIds));
        $stmt->bind_param($types, ...$allArticleIds);
        $stmt->execute();
    }

    $_SESSION['success_message'] = 'Article highlights updated successfully!';
    header('Location: ../admin-settings.php?section=highlights');
    exit();
} else {
    header('Location: ../admin-settings.php?section=highlights');
    exit();
}

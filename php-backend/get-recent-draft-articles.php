<?php

include 'connect.php';

$user_id = $_GET['user_id'];

// Step 1: Get user type
$userTypeQuery = "SELECT user_type FROM users WHERE user_id = ?";
$userTypeStmt = $conn->prepare($userTypeQuery);
$userTypeStmt->bind_param("i", $user_id);
$userTypeStmt->execute();
$userTypeResult = $userTypeStmt->get_result();

$user_type = null;
if ($row = $userTypeResult->fetch_assoc()) {
    $user_type = strtolower($row['user_type']);
}

// Step 2: Build the article query dynamically
if ($user_type === 'writer') {
    $query = "
        SELECT a.*, w.*
        FROM articles a
        LEFT JOIN widgets w ON a.article_id = w.article_owner
        WHERE a.completion_status = 'draft'
        AND a.user_owner = ?
        ORDER BY a.date_updated DESC
        LIMIT 5
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
} else {
    $query = "
        SELECT a.*, w.*
        FROM articles a
        LEFT JOIN widgets w ON a.article_id = w.article_owner
        WHERE a.completion_status = 'draft'
        AND a.approve_status = 'no'
        ORDER BY a.date_updated DESC
        LIMIT 5
    ";
    $stmt = $conn->prepare($query);
}

// Step 3: Execute and fetch results
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
$widgets = [];

while ($row = $result->fetch_assoc()) {
    // Add article to the articles array
    $article = [
        'article_id' => $row['article_id'],
        'article_title' => $row['article_title'],
        'article_content' => $row['article_content'],
        'date_updated' => $row['date_updated'],
    ];

    // Add widget if it exists
    if (!empty($row['widget_id'])) {
        $widgets[] = [
            'widget_id' => $row['widget_id'],
            'widget_img' => $row['widget_img'],
        ];
    }

    $articles[] = $article;
}

echo json_encode([
    'articles' => $articles,
    'widgets' => $widgets,
    'user_type' => $user_type
]);

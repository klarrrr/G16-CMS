<?php

session_start();

include 'connect.php';

$user_id = $_SESSION['user_id'];
$user_type = strtolower($_SESSION['user_type']);

if ($user_type === 'writer') {
    $query = "
        SELECT 
        a.article_id, a.article_title, a.article_content, a.date_updated,
        w.widget_id, w.widget_img
        FROM articles a
        LEFT JOIN widgets w ON a.article_id = w.article_owner
        WHERE a.completion_status = 'draft' 
        AND a.user_owner = ?
        ORDER BY a.date_updated DESC
        LIMIT 5
    ";
} elseif ($user_type === 'reviewer') {
    $query = "
        SELECT 
        a.article_id, a.article_title, a.article_content, a.date_updated,
        w.widget_id, w.widget_img
        FROM articles a
        LEFT JOIN widgets w ON a.article_id = w.article_owner
        INNER JOIN article_review_invites i ON a.article_id = i.article_id
        WHERE a.completion_status = 'draft'
        AND a.archive_status = 'active'
        AND a.approve_status = 'no'
        AND i.reviewer_id = ?
        AND i.status = 'accepted'
        ORDER BY a.date_updated DESC
        LIMIT 5
    ";
} else {
    echo json_encode(['error' => 'Invalid user type']);
    exit;
}

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
$widgets = [];
$widget_ids = [];

while ($row = $result->fetch_assoc()) {
    $articles[] = [
        'article_id' => $row['article_id'],
        'article_title' => $row['article_title'],
        'article_content' => $row['article_content'],
        'date_updated' => $row['date_updated'],
    ];

    if (!empty($row['widget_id']) && !in_array($row['widget_id'], $widget_ids)) {
        $widgets[] = [
            'widget_id' => $row['widget_id'],
            'widget_img' => $row['widget_img'],
        ];
        $widget_ids[] = $row['widget_id'];
    }
}

$stmt->close();
$conn->close();

echo json_encode([
    'articles' => $articles,
    'widgets' => $widgets,
    'user_type' => $user_type
]);

<?php

include 'connect.php';

$user_id = $_GET['user_id'];

// Prepare the query to fetch articles and associated widgets
$query = "
SELECT a.*, w.*
FROM articles a
LEFT JOIN widgets w ON a.article_id = w.article_owner
WHERE a.completion_status = 'draft'
AND
a.user_owner = $user_id
ORDER BY a.date_updated DESC
LIMIT 5;
";

// Use prepared statements to avoid SQL injection and increase security
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch the result
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
        // Add other article fields here
    ];

    // Add widget if it exists
    if ($row['widget_id']) {
        $widgets[] = [
            'widget_id' => $row['widget_id'],
            'widget_img' => $row['widget_img'],
            // Add other widget fields here
        ];
    }

    $articles[] = $article;
}

echo json_encode([
    'articles' => $articles,
    'widgets' => $widgets
]);

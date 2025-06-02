<?php
include 'connect.php';
session_start();

$query = "
    SELECT a.article_id, a.article_title, a.date_posted, a.highlight, 
           w.widget_title, w.widget_img
    FROM articles a
    LEFT JOIN widgets w ON a.article_id = w.article_owner
    WHERE a.approve_status = 'yes'
      AND a.completion_status = 'published'
    ORDER BY a.date_posted DESC
";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

// Convert to UTF-8 if needed
foreach ($articles as &$article) {
    foreach ($article as &$value) {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}

header('Content-Type: application/json');
echo json_encode($articles);

<?php
include 'connect.php';

$query = "
    SELECT w.* 
    FROM widgets w
    INNER JOIN articles a ON w.article_owner = a.article_id
    WHERE a.approve_status = 'yes'
      AND a.completion_status = 'published'
      AND a.date_posted IS NOT NULL
      AND a.article_type = 'regular'
      AND NOW() >= a.date_posted
      AND NOW() <= a.date_expired
    ORDER BY a.date_posted DESC
    LIMIT 1
";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$widget = $result->fetch_assoc();

// Convert to UTF-8 if needed
if ($widget) {
    foreach ($widget as &$value) {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}

header('Content-Type: application/json');
echo json_encode(['widget' => $widget]);

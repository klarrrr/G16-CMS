<?php

include 'connect.php';

$widgetArray = [];

$stmt = $conn->prepare("
    SELECT w.* 
    FROM widgets w
    INNER JOIN articles a ON w.article_owner = a.article_id
    WHERE a.approve_status = 'yes'
      AND a.completion_status = 'published'
      AND a.date_posted IS NOT NULL
      AND NOW() >= a.date_posted
      AND NOW() <= a.date_expired
    ORDER BY a.date_posted DESC
    LIMIT 7
");

$stmt->execute();
$results = $stmt->get_result();

while ($row = $results->fetch_assoc()) {
    $widgetArray[] = $row;
}

foreach ($widgetArray as &$widget) {
    foreach ($widget as &$value) {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}

$jsonOutput = json_encode([
    'widget' => $widgetArray
]);

echo $jsonOutput;

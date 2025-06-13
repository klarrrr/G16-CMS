<?php

include 'connect.php';

$widgetArray = [];
$search = isset($_GET['search']) ? $_GET['search'] : ''; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; 
$offset = ($page - 1) * $limit;


$searchTerm = '%' . $search . '%';

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM widgets w
    JOIN articles a ON w.article_owner = a.article_id
    WHERE (w.widget_title LIKE ? OR w.widget_paragraph LIKE ?)
    AND a.approve_status = 'yes'
    AND a.completion_status = 'published'
");
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$totalRecords = $stmt->get_result()->fetch_row()[0];

$stmt = $conn->prepare("
    SELECT w.* 
    FROM widgets w
    JOIN articles a ON w.article_owner = a.article_id
    WHERE (w.widget_title LIKE ? OR w.widget_paragraph LIKE ?)
    AND a.approve_status = 'yes'
    AND a.completion_status = 'published'
    ORDER BY w.widget_id DESC
    LIMIT ?, ?
");
$stmt->bind_param("ssii", $searchTerm, $searchTerm, $offset, $limit);
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
    'widget' => $widgetArray,
    'totalRecords' => $totalRecords,
    'totalPages' => ceil($totalRecords / $limit)
]);

echo $jsonOutput;

<?php

include 'connect.php';

$widgetArray = [];

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$stmt = $conn->prepare("SELECT COUNT(*) FROM widgets");
$stmt->execute();
$totalRecords = $stmt->get_result()->fetch_row()[0];

$stmt = $conn->prepare("SELECT * FROM widgets ORDER BY widget_id DESC LIMIT ?, ? ");
$stmt->bind_param("ii", $offset, $limit);
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

<?php

include 'connect.php';

$widgetArray = [];

$stmt = $conn->prepare("SELECT * FROM widgets ORDER BY widget_id DESC LIMIT 7");
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

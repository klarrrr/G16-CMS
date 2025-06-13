<?php
include 'connect.php';

$highlightQuery = "
    SELECT a.highlight, w.* 
    FROM widgets w
    INNER JOIN articles a ON w.article_owner = a.article_id
    WHERE a.approve_status = 'yes'
      AND a.completion_status = 'published'
      AND a.date_posted IS NOT NULL
      AND a.highlight = 1
    ORDER BY a.date_posted DESC
";

$stmt = $conn->prepare($highlightQuery);
$stmt->execute();
$highlightResult = $stmt->get_result();
$highlightedWidgets = $highlightResult->fetch_all(MYSQLI_ASSOC);

if ($highlightedWidgets) {
    foreach ($highlightedWidgets as &$widget) {
        foreach ($widget as &$value) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
    }
}

// date_default_timezone_set('Asia/Manila');
$now = date('Y-m-d H:i:s', time());

if (empty($highlightedWidgets)) {
    $latestQuery = "
        SELECT w.* 
        FROM widgets w
        INNER JOIN articles a ON w.article_owner = a.article_id
        WHERE a.approve_status = 'yes'
          AND a.completion_status = 'published'
          AND a.date_posted IS NOT NULL
          AND a.article_type = 'regular'
          AND '$now' >= a.date_posted
          AND NOW() <= a.date_expired
        ORDER BY a.date_posted DESC
        LIMIT 1
    ";

    $stmt = $conn->prepare($latestQuery);
    $stmt->execute();
    $latestResult = $stmt->get_result();
    $latestWidget = $latestResult->fetch_assoc();

    if ($latestWidget) {
        foreach ($latestWidget as &$value) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
        $highlightedWidgets = [$latestWidget];
    }
}

// Prepare response
$response = [
    'widgets' => $highlightedWidgets ? $highlightedWidgets : null,
    'hasHighlights' => !empty($highlightedWidgets) && $highlightedWidgets[0]['highlight'] == 1,
    $highlightedWidgets
];

header('Content-Type: application/json');
echo json_encode($response);

<?php
include 'connect.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 6; // Only cards now
$offset = ($page - 1) * $limit;

$widgetArray = [];

// First get total count (excluding the latest which is shown as highlight)
$countQuery = "
    SELECT COUNT(*) as total 
    FROM widgets w
    INNER JOIN articles a ON w.article_owner = a.article_id
    WHERE a.approve_status = 'yes'
      AND a.completion_status = 'published'
      AND a.date_posted IS NOT NULL
      AND a.article_type = 'regular'
      AND NOW() >= a.date_posted
      AND NOW() <= a.date_expired
";
$countResult = mysqli_query($conn, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil(($totalRecords > 0 ? $totalRecords - 1 : 0) / $limit); // Subtract 1 for highlight

// Then get paginated results (skip the first/latest article)
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
    LIMIT $limit OFFSET $offset
";

$stmt = $conn->prepare($query);
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
    'totalRecords' => $totalRecords > 0 ? $totalRecords - 1 : 0, // Subtract highlight
    'totalPages' => $totalPages,
    'currentPage' => $page
]);

header('Content-Type: application/json');
echo $jsonOutput;

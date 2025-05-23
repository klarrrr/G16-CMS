<?php

include 'connect.php';

$widgetArray = [];
$search = isset($_GET['search']) ? $_GET['search'] : ''; // Get search term, default to empty if not set

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; // Number of records per page
$offset = ($page - 1) * $limit;

// Prepare the search term for SQL (use LIKE for partial matching)
$searchTerm = '%' . $search . '%';

// Step 1: Get the total number of matching records with article filters
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

// Step 2: Fetch the paginated records with filtering
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

// Step 3: Populate the results array with the fetched rows
while ($row = $results->fetch_assoc()) {
    $widgetArray[] = $row;
}

// Step 4: Ensure all values are UTF-8 encoded
foreach ($widgetArray as &$widget) {
    foreach ($widget as &$value) {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}

// Step 5: Prepare the response as a JSON object
$jsonOutput = json_encode([
    'widget' => $widgetArray,
    'totalRecords' => $totalRecords,
    'totalPages' => ceil($totalRecords / $limit)
]);

echo $jsonOutput;

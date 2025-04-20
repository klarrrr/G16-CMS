<?php
header('Content-Type: application/json');
include '../connect.php';

$currentProject = 1; // This will be dynamic later

$response = [
    'pages' => [],
    'sections' => [],
    'elements' => [],
];

// PAGES
$queryPages = "SELECT * FROM pages WHERE template_owner = $currentProject";
$resPages = mysqli_query($conn, $queryPages);
while ($row = mysqli_fetch_assoc($resPages)) {
    $response['pages'][] = $row;
}

// SECTIONS
$querySections = "SELECT * FROM sections WHERE page_owner IN (
    SELECT page_id FROM pages WHERE template_owner = $currentProject
)";
$resSections = mysqli_query($conn, $querySections);
while ($row = mysqli_fetch_assoc($resSections)) {
    $response['sections'][] = $row;
}

// ELEMENTS
$queryElements = "SELECT * FROM elements WHERE section_owner IN (
    SELECT section_id FROM sections WHERE page_owner IN (
        SELECT page_id FROM pages WHERE template_owner = $currentProject
    )
)";
$resElements = mysqli_query($conn, $queryElements);
while ($row = mysqli_fetch_assoc($resElements)) {
    $response['elements'][] = $row;
}

echo json_encode($response);

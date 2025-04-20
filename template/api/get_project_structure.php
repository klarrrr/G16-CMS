<?php
header('Content-Type: application/json');
include '../connect.php';

// THESE ARRAYS ARE FOR REAL TIME DISPLAYING THE SITE IN THE PREVIEW IFRAME

$currentProject = 1; // This will be dynamic later

$response = [
    'navigation' => [],
    'pages' => [],
    'sections' => [],
    'elements' => []
];

//NAVIGATION
$queryNav = "SELECT * FROM elements WHERE nav_owner = (SELECT id FROM navigation WHERE template_owner = $currentProject)"; // TODO Change the template_owner to project owner later

$resNav = mysqli_query($conn, $queryNav);
while ($row = mysqli_fetch_assoc($resNav)) {
    $response['navigation'][] = $row;
}

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

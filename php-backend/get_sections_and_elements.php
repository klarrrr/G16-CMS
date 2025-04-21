<?php
include 'connect.php';

// Post Page ID here
$pageOwner = $_POST['page_id'] ?? 1;

// check
if (!$pageOwner) {
    echo json_encode(['error' => 'No page ID provided']);
    exit;
}

// Store sections and elements
$sectionsArray = [];
$elementsArray = [];

// Query Sections and store into sections array
$querySections = "SELECT * FROM sections WHERE page_owner = $pageOwner";
$sectionResult = mysqli_query($conn, $querySections);

while ($row = mysqli_fetch_assoc($sectionResult)) {
    $sectionsArray[] = $row; // Add section row
}

// Query Elements per Section and store into elements array
foreach ($sectionsArray as $section) {
    $sectionId = $section['section_id']; // Extract the ID properly
    $queryElements = "SELECT * FROM elements WHERE section_owner = $sectionId";
    $elementResult = mysqli_query($conn, $queryElements);

    while ($row = mysqli_fetch_assoc($elementResult)) {
        $elementsArray[] = $row; // Add each element
    }
}

// Return combined result as JSON
echo json_encode([
    'sections' => $sectionsArray,
    'elements' => $elementsArray
]);

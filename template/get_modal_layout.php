<?php

$page_id = $_GET['page_id'] ?? null;

if (!$page_id) {
    echo "Page ID missing.";
    exit;
}

// Get project data as JSON
$projectData = json_decode(file_get_contents('api/get_project_structure.php'), true);

if (!$projectData) {
    echo "Failed to load project structure.";
    exit;
}

$pagesArray = [];
foreach ($projectData['pages'] as $page) {
    $pagesArray[$page['page_id']] = [
        "page_name" => $page['page_name'],
        "project_owner" => $page['template_owner']
    ];
}

$sectionsArray = [];
foreach ($projectData['sections'] as $section) {
    $sectionsArray[$section['section_id']] = [
        "section_name" => $section['section_name'],
        "page_owner" => $section['page_owner']
    ];
}

$elementsArray = [];
foreach ($projectData['elements'] as $element) {
    $elementsArray[$element['element_id']] = [
        "element_name" => $element['element_name'],
        "element_content" => $element['content'],
        "element_type" => $element['element_type'],
        "section_owner" => $element['section_owner']
    ];
}

$pageName = ucwords(strtolower($pagesArray[$page_id]['page_name']));
include 'modal_builder.php';
echo buildModalLayout($page_id, $pageName, $sectionsArray, $elementsArray);

<?php

include 'connect.php';

// Algorithm that will scourge Pages Table in Database
// SELECT every page that is related to the project that the user is currently using
// SELECT every section that is related to the page
// SELECT every elements that is related to the section

// $current_project = 1 // Id of the project, but since this is still testing, get the id of template 1
$currentProject = 1; // TODO : This is temporary change to be whatver the user is going to use. In the future.

// SELECT page_id, page_name FROM pages WHERE template_owner = 1; // Store this in an array
$queryPages = "SELECT page_id, page_name FROM pages WHERE template_owner = $currentProject";
$pages = mysqli_query($conn, $queryPages);

// This is where the page id of the related pages are stored
$pagesArray = [];

// Select all the Sections related to each pages
if ($pages) {
    // Store to row until it reach the end of $pages
    while ($row = mysqli_fetch_assoc($pages)) {
        $pagesArray[$row['page_id']] = [
            "page_name" => $row['page_name'],
            "project_owner" => $currentProject
        ];
    }
    mysqli_free_result($pages);
} else {
    echo "Error " . mysqli_error($conn);
}

// Stores section id with its associated name
$sectionsArray = [];

foreach ($pagesArray as $pageId => $pageName) {
    $querySections = "SELECT section_id, section_name FROM sections WHERE page_owner = $pageId";
    $sections = mysqli_query($conn, $querySections);

    // Select all the Sections related to each pages
    if ($sections) {
        // Store to row until it reach the end of $sections
        while ($row = mysqli_fetch_assoc($sections)) {
            $sectionsArray[$row['section_id']] = [
                "section_name" => $row['section_name'],
                "page_owner" => $pageId
            ];
        }
        mysqli_free_result($sections);
    } else {
        echo "Error " . mysqli_error($conn);
    }
}

// Stores element id with its associated name and content
$elementsArray = [];

foreach ($sectionsArray as $sectionId => $sectionName) {
    $queryElements = "SELECT element_id, element_name, element_type, content FROM elements WHERE section_owner = $sectionId";
    $elements = mysqli_query($conn, $queryElements);

    // Select all the Elements related to each Section
    if ($elements) {
        // Store to row until it reach the end of $Elements
        while ($row = mysqli_fetch_assoc($elements)) {
            $elementsArray[$row['element_id']] = [
                "element_name" => $row['element_name'],
                "element_content" => $row['content'],
                "element_type" => $row['element_type'],
                "section_owner"      => $sectionId
            ];
        }
        mysqli_free_result($elements);
    } else {
        echo "Error " . mysqli_error($conn);
    }
}

// After storing everything into ARRAYS
// Here goes PHP algorithm that lays out everything in the array into an html file

// Upper part of the HTML
$htmlLayout = "
    <!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Template 1 : Home</title>
        <link rel='stylesheet' href='pages/styles/styles_template1_nav.css'>
        <link rel='stylesheet' href='pages/styles/styles_template1.css'>
    </head>

    <body>
";

// Insert the NAV
$htmlLayout .= file_get_contents('test_nav_layout.php');

// Then the body
ob_start();
include 'template1_home_dynamic.php';
$htmlLayout .= ob_get_clean();

$footer = file_get_contents('pages/template1/template1_footer.php');
$htmlLayout .= $footer;

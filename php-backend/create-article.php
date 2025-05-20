<?php
include 'connect.php';
session_start();
// Insert 

$title = $_POST['title'];
$content = $_POST['content'];
$shortDesc = $_POST['shortDesc'];
// $title = 'sampul title';
// $content = '<p>Hello</p>';
// $shortDesc = 'short desc';
$userOwner = $_SESSION['user_id'];

$sanitizedContent = htmlentities($content, ENT_QUOTES, 'UTF-8');

if (!$content || !$title || !$shortDesc) {
    echo json_encode([
        'error' => 'Bruh may error'
    ]);
}

// Insert article to db

$articleQuery = "INSERT INTO articles 
(
article_title,
article_content,
user_owner,
edit_status,
completion_status
) 
VALUES 
(
'$title',
'$content',
$userOwner,
'available',
'draft'
)";

mysqli_query($conn, $articleQuery);

// Get max id article

$currentArticle = "SELECT max(article_id) FROM articles";
$result = mysqli_query($conn, $currentArticle);
$row = mysqli_fetch_assoc($result);

foreach ($row as $a) {
    $curArticle = $a;
    break;
}

// Insert to widgets

$widgetQuery = "INSERT INTO widgets
(
widget_title,
widget_paragraph,
article_owner,
user_owner
)
VALUES
(
'$title',
'$shortDesc',
$curArticle,
$userOwner
)
";

mysqli_query($conn, $widgetQuery);

mysqli_close($conn);

echo json_encode([
    'status' => 'success'
]);

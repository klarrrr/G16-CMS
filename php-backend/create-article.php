<?php
include 'connect.php';

// Insert 

/*

title = Article Title
content = Your content goes here...
user_owner = session_id of user
edit status = editing 
completion_status = draft 

S

*/

$title = $_POST['title'];
$content = $_POST['content'];
$shortDesc = $_POST['shortDesc'];
//  Temporary Use session in the future
$userOwner = 1;

if (!$content || !$title || $shortDesc) {
    echo json_encode([
        'error' => 'Bruh may error'
    ]);
}

$articleQuery = "INSERT FROM articles 
(
article_title,
article_content,
user_owner,
edit_status,
completion_status,
) 
VALUES 
(
$title,
$content,
$userOwner,
'available',
'draft'
)";

$widgetQuery = ""


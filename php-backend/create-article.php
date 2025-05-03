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

// $title = $_POST['title'];
// $content = $_POST['content'];
// $shortDesc = $_POST['shortDesc'];
// //  Temporary, Use session in the future
// $userOwner = 1;

// if (!$content || !$title || $shortDesc) {
//     echo json_encode([
//         'error' => 'Bruh may error'
//     ]);
// }

// // Insert article to db

// $articleQuery = "INSERT FROM articles 
// (
// article_title,
// article_content,
// user_owner,
// edit_status,
// completion_status,
// ) 
// VALUES 
// (
// $title,
// $content,
// $userOwner,
// 'available',
// 'draft'
// )";

// mysqli_query($conn, $articleQuery);

// // Get max id article

// $currentArticle = "SELECT max(article_id) FROM articles";
// $result = mysqli_query($conn, $currentArticle);
// $row = mysqli_fetch_assoc($result);

// foreach ($row as $a) {
//     $curArticle = $a;
//     break;
// }

// // INsert to widgets

// $widgetQuery = "INSERT FROM widgets
// (
// widget_title,
// widget_paragraph,
// article_owner,
// user_owner
// )
// VALUES
// (
// $title,
// $shortDesc,
// $curArticle,
// $userOwner
// )
// ";

// mysqli_query($conn, $widgetQuery);






// After inserting all required details, get all of them.

// Article

$articleAttribs = [];

$getArticleQuery = "SELECT * FROM articles WHERE article_id = (SELECT max(article_id) FROM articles)";

$result = mysqli_query($conn, $getArticleQuery);
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $a) {
        $articleAttribs[] = $a;
    }
    break;
}


// Widgets

$widgetAttribs = [];

$getWidgetQuery = "SELECT * FROM widgets WHERE widget_id = (SELECT max(widget_id) FROM widgets)";

$result = mysqli_query($conn, $getWidgetQuery);
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $a) {
        $widgetAttribs[] = $a;
    }
    break;
}

echo json_encode([
    'article' => $articleAttribs,
    'widgets' => $widgetAttribs
]);

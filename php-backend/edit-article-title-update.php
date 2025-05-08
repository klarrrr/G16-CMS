<?php

include 'connect.php';

$article_id = $_POST['article_id'];
$newTitle = htmlspecialchars($_POST['newTitle']);

$query = "UPDATE articles SET article_title = '$newTitle' WHERE article_id = $article_id";
mysqli_query($conn, $query);

$query2 = "UPDATE widgets SET widget_title = '$newTitle' WHERE article_owner = $article_id ";
mysqli_query($conn, $query2);

echo json_encode([
    'status' => 'success'
]);

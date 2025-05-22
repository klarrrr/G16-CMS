<?php

include 'connect.php';

$base64img = $_POST['base64String'];
$article_id = $_POST['article_id'];

$query = "UPDATE widgets SET widget_img = '$base64img' WHERE article_owner = $article_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'success'
]);

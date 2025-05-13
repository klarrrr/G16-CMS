<?php

include 'connect.php';

$article_id = $_POST['article_id'];

$query = "DELETE FROM articles WHERE article_id = $article_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'Article Deletion Success'
]);

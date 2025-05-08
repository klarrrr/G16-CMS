<?php

include 'connect.php';

$article_id = $_POST['article_id'];
$content = htmlspecialchars($_POST['content']);

$query = "UPDATE articles SET article_content = '$content' WHERE article_id = $article_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'success'
]);

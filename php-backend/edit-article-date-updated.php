<?php

include 'connect.php';


$article_id = $_POST['article_id'];

$query = "UPDATE articles SET date_updated = NOW() WHERE article_id = $article_id";
mysqli_query($conn, $query);
$query = "UPDATE widgets SET date_updated = NOW() WHERE article_owner = $article_id";

$query = "SELECT date_updated FROM articles WHERE  article_id = $article_id";
$result = mysqli_query($conn, $query);
$date_updated = null;
if ($row = mysqli_fetch_assoc($result)) {
    $date_updated = $row['date_updated'];
}

echo json_encode([
    'date_updated' => $date_updated
]);

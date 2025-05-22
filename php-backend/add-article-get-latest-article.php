<?php

session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT MAX(article_id) FROM articles WHERE user_owner = $user_id";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        'latestArticle' => $row['MAX(article_id)'],
        'status' => 'success'
    ]);
}

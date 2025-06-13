<?php

include 'connect.php';

$article_id = $_POST['article_id'];
$newShortDesc = htmlspecialchars($_POST['newShortDesc']);

// Update short desc 
$query = "UPDATE widgets SET widget_paragraph = '$newShortDesc' WHERE article_owner = $article_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'success'
]);

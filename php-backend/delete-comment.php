<?php

include 'connect.php';

$comment_id = $_POST['comment_id'];

$query = "DELETE FROM comments WHERE comment_id = $comment_id";

mysqli_query($conn, $query);

echo json_encode([
    'success' => true
]);

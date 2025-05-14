<?php

use Dom\Comment;

include 'connect.php';

$article_id = $_POST['article_id'];

// Select all the comments
$query = "SELECT c.comment_id, c.comment_content, c.user_owner, c.article_owner, c.date_created, u.user_first_name, u.user_last_name, u.profile_picture FROM comments AS c JOIN users AS u ON c.user_owner = u.user_id AND c.article_owner = $article_id";
$result = mysqli_query($conn, $query);
$comments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $comments[] = $row;
}

echo json_encode($comments);

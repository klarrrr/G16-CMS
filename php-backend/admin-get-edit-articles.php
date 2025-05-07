<?php
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM articles WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$articles = [];
while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row;
}

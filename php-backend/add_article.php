<?php
include 'connect.php';

$user_id = $_POST['user_id'];
// $user_id = 3; // // for testing

$query = "SELECT * FROM widgets WHERE user_owner = $user_id ORDER BY user_owner DESC";

$result = mysqli_query($conn, $query);

$widgets = [];

while ($row = mysqli_fetch_assoc($result)) {
    $widgets[] = $row;
}

$articleOwnerId = [];

foreach ($widgets as $widget) {
    array_push($articleOwnerId, $widget['article_owner']);
}

$articleStatus = [];

$articleIds = json_encode($articleOwnerId);
$articleIds = str_replace('[', '', $articleIds);
$articleIds = str_replace(']', '', $articleIds);

$query = "SELECT edit_status FROM articles WHERE article_id IN ($articleIds) ORDER BY article_id DESC";

$result = mysqli_query($conn, $query);

$articles = [];

while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row['edit_status'];
}

echo json_encode(
    [
        'article_status' => $articles,
        'widgets' => $widgets
    ]
);

// echo json_encode($widgets);

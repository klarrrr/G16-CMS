<?php

session_start();

include 'connect.php';

$user_id = $_SESSION['user_id'];
// $user_id = 3; // // for testing

$query = "SELECT * FROM widgets WHERE user_owner = $user_id ORDER BY widget_id DESC";

$result = mysqli_query($conn, $query);

$widgets = [];

while ($row = mysqli_fetch_assoc($result)) {
    $widgets[] = $row;
}

$articleOwnerId = [];

foreach ($widgets as $widget) {
    array_push($articleOwnerId, $widget['article_owner']);
}

$articleIds = json_encode($articleOwnerId);
$articleIds = str_replace('[', '', $articleIds);
$articleIds = str_replace(']', '', $articleIds);

$query = "SELECT * FROM articles WHERE article_id IN ($articleIds) ORDER BY article_id DESC";

$result = mysqli_query($conn, $query);

$articles = [];

while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row;
}

$owners = [];

foreach ($widgets as $a) {
    $user_owner = $a['user_owner'];
    $query = "SELECT user_first_name, user_last_name FROM users WHERE user_id = $user_owner";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $owners[] = $row;
    }
}

echo json_encode(
    [
        'articles' => $articles,
        'widgets' => $widgets,
        'authors' => $owners
    ]
);

// echo json_encode($widgets);

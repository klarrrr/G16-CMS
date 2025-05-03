<?php

include 'connect.php';

// $page = $_POST['page'];
$tag_ids = [1, 2];

$string = json_encode($tag_ids);
$string = str_replace('[', '', $string);
$string = str_replace(']', '', $string);

$tagsArray = [];

$query = "SELECT * FROM tags WHERE tag_id IN ($string)";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $tagsArray[] = $row;
}

// Get all the articles based on tag ids

$articles = [];

$query = "SELECT assigned_article FROM tag_assign WHERE assigned_tag IN ($string)";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row['assigned_article'];
}

$string = json_encode($articles);
$string = str_replace('[', '', $string);
$string = str_replace(']', '', $string);

// Get the widget

$widgets = [];

$query = "SELECT * FROM widgets WHERE article_owner IN ($string)";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $widgets[] = $row;
}

echo json_encode($widgets);

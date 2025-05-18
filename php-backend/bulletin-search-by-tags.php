<?php

include 'connect.php';

$page = $_POST['page'];
$tag_ids = $_POST['tag_ids'];

// Convert the tag_ids array to a comma-separated string
$tag_ids_string = implode(",", $tag_ids);

// Get all the articles based on tag ids

$articles = [];

// Update query to ensure that only articles assigned to all the selected tags are fetched
$query = "
    SELECT assigned_article 
    FROM tag_assign 
    WHERE assigned_tag IN ($tag_ids_string)
    GROUP BY assigned_article
    HAVING COUNT(DISTINCT assigned_tag) = " . count($tag_ids);

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row['assigned_article'];
}

// If there are no articles, return an empty result
if (empty($articles)) {
    echo json_encode([]);
    exit();
}

// Convert article IDs to a string for the next query
$articles_string = implode(",", $articles);

// Get the widgets for these articles
$widgets = [];

$query = "SELECT * FROM widgets WHERE article_owner IN ($articles_string)";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $widgets[] = $row;
}

// Return the widgets
echo json_encode($widgets);

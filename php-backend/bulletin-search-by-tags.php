<?php

include 'connect.php';

$page = $_POST['page'];
$tag_ids = $_POST['tag_ids'];

// Convert the tag_ids array to a comma-separated string
$tag_ids_string = implode(",", array_map('intval', $tag_ids)); // Sanitize input

$articles = [];

// Updated query: Join with articles and filter by approve_status and completion_status
$query = "
    SELECT ta.assigned_article 
    FROM tag_assign ta
    JOIN articles a ON ta.assigned_article = a.article_id
    WHERE ta.assigned_tag IN ($tag_ids_string)
    AND a.approve_status = 'yes'
    AND a.completion_status = 'published'
    GROUP BY ta.assigned_article
    HAVING COUNT(DISTINCT ta.assigned_tag) = " . count($tag_ids);

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
$articles_string = implode(",", array_map('intval', $articles)); // Sanitize input

// Get the widgets for these articles
$widgets = [];

$query = "
    SELECT * 
    FROM widgets 
    WHERE article_owner IN ($articles_string)";

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $widgets[] = $row;
}

// Return the widgets
echo json_encode($widgets);

<?php
include 'connect.php';

if (!isset($_GET['article_id'])) {
    echo json_encode(['tags' => []]);
    exit;
}

$article_id = intval($_GET['article_id']); // Sanitize input

$query = "
    SELECT t.tag_id, t.tag_name 
    FROM tags t
    JOIN tag_assign ta ON ta.assigned_tag = t.tag_id
    WHERE ta.assigned_article = ?
";

$tagsArray = [];

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $tagsArray[] = $row;
}

echo json_encode([
    'tags' => $tagsArray
]);

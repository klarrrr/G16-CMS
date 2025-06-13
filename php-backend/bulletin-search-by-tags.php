<?php

include 'connect.php';

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$tag_ids = isset($_POST['tag_ids']) ? $_POST['tag_ids'] : [];

if (empty($tag_ids)) {
    echo json_encode([]);
    exit();
}

// Sanitize tag_ids
$tag_ids = array_map('intval', $tag_ids);
$tag_ids_string = implode(",", $tag_ids);

$query = "
    SELECT ta.assigned_article 
    FROM tag_assign ta
    JOIN articles a ON ta.assigned_article = a.article_id
    WHERE ta.assigned_tag IN ($tag_ids_string)
    AND a.approve_status = 'yes'
    AND a.completion_status = 'published'
    GROUP BY ta.assigned_article
    HAVING COUNT(DISTINCT ta.assigned_tag) = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $tagCount);
$tagCount = count($tag_ids);
$stmt->execute();
$result = $stmt->get_result();

$matchedArticleIds = [];
while ($row = $result->fetch_assoc()) {
    $matchedArticleIds[] = intval($row['assigned_article']);
}

if (empty($matchedArticleIds)) {
    echo json_encode([]);
    exit();
}

$total = count($matchedArticleIds);
$limit = 9;
$totalPages = ceil($total / $limit);
$offset = ($page - 1) * $limit;

$paginatedArticleIds = array_slice($matchedArticleIds, $offset, $limit);
$articles_string = implode(",", $paginatedArticleIds);

$widgets = [];

$query = "SELECT * FROM widgets WHERE article_owner IN ($articles_string)";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $widgets[] = $row;
}

echo json_encode([
    'widget' => $widgets,
    'totalPages' => $totalPages,
    'totalRecords' => $total
]);

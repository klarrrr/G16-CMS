<?php
include 'connect.php';

$response = [
    'success' => false,
    'tags' => []
];

if (isset($_POST['article_id'])) {
    $articleId = $_POST['article_id'];

    // Query to fetch assigned tags for the given article
    $query = "
        SELECT t.tag_name
        FROM tags t
        JOIN tag_assign ta ON ta.assigned_tag = t.tag_id
        WHERE ta.assigned_article = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();

    $tags = [];
    while ($row = $result->fetch_assoc()) {
        $tags[] = $row;
    }

    if (count($tags) > 0) {
        $response['success'] = true;
        $response['tags'] = $tags;
    }
}

echo json_encode($response);

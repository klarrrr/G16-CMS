<?php
include('connect.php');

$article_id = isset($_GET['article_id']) ? $_GET['article_id'] : null;

if ($article_id) {
    $sql = "SELECT pic_id, pic_path FROM article_gallery WHERE article_owner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = array();

    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $images
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Article ID is missing or invalid.'
    ]);
}

$stmt->close();
$conn->close();

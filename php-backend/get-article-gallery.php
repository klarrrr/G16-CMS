<?php
// Include your database connection
include('connect.php');

if (isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];

    // Get images for this article from the database
    $sql = "SELECT pic_id, pic_path FROM article_gallery WHERE article_owner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $images
    ]);

    $stmt->close();
}

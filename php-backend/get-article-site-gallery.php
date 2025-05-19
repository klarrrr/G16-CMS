<?php
// Include your database connection
include('connect.php');

// Get the article_id from the request (you can pass this via GET)
$article_id = isset($_GET['article_id']) ? $_GET['article_id'] : null;

// Check if the article_id is valid
if ($article_id) {
    // Prepare the SQL query to fetch images for the given article_id
    $sql = "SELECT pic_id, pic_path FROM article_gallery WHERE article_owner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to hold the images
    $images = array();

    // Fetch each image and add it to the images array
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }

    // Return the image data in JSON format
    echo json_encode([
        'status' => 'success',
        'data' => $images
    ]);
} else {
    // Return an error if the article_id is not provided
    echo json_encode([
        'status' => 'error',
        'message' => 'Article ID is missing or invalid.'
    ]);
}

$stmt->close();
$conn->close();

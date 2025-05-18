<?php
include 'connect.php';

$response = ['success' => false];

if (isset($_POST['article_id']) && isset($_POST['tags'])) {
    $articleId = $_POST['article_id'];
    $tags = $_POST['tags'];

    // First, clear existing tags from the article
    $deleteQuery = "DELETE FROM tag_assign WHERE assigned_article = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();

    // Now, insert the new tags
    $insertQuery = "INSERT INTO tag_assign (assigned_article, assigned_tag) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);

    // Loop through the tags and insert them
    foreach ($tags as $tagName) {
        // Check if the tag already exists in the tags table
        $selectQuery = "SELECT tag_id FROM tags WHERE tag_name = ?";
        $stmtSelect = $conn->prepare($selectQuery);
        $stmtSelect->bind_param("s", $tagName);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();

        if ($result->num_rows > 0) {
            // If the tag exists, use the existing tag_id
            $tag = $result->fetch_assoc();
            $tagId = $tag['tag_id'];
        } else {
            // If the tag does not exist, insert it into the tags table
            $insertTagQuery = "INSERT INTO tags (tag_name) VALUES (?)";
            $stmtInsertTag = $conn->prepare($insertTagQuery);
            $stmtInsertTag->bind_param("s", $tagName);
            $stmtInsertTag->execute();
            $tagId = $stmtInsertTag->insert_id;
        }

        // Now insert the tag assignment into tag_assign
        $stmt->bind_param("ii", $articleId, $tagId);
        $stmt->execute();
    }

    // Respond with success
    $response['success'] = true;
}

echo json_encode($response);

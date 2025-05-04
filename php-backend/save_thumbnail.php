<?php
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['widget_img']) && isset($data['article_owner']) && isset($data['user_owner'])) {
    $base64Image = $data['widget_img'];
    $articleOwner = $data['article_owner'];
    $userOwner = $data['user_owner'];

    $stmt = $conn->prepare("INSERT INTO widgets (widget_img, article_owner, user_owner) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $base64Image, $articleOwner, $userOwner);

    if ($stmt->execute()) {
        echo $stmt->insert_id; // Success: return ID only
    } else {
        echo "ERROR: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing required fields.";
}

$conn->close();
?>

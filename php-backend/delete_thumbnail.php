<?php
include 'connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id'])) {
    $widgetId = $data['id'];

    // Correct the column name if it's not 'widget_id'
    $stmt = $conn->prepare("DELETE FROM widgets WHERE widget_id = ?");
    $stmt->bind_param("i", $widgetId);

    if ($stmt->execute()) {
        echo "Image deleted successfully.";
    } else {
        echo "Failed to delete image: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No ID provided.";
}

$conn->close();

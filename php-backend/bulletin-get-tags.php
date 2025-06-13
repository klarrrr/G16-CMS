<?php

include 'connect.php';

// Get all available tags
$query = "SELECT * FROM tags";

$tagsArray = [];

$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $tagsArray[] = $row;
}

echo json_encode([
    'tags' => $tagsArray
]);

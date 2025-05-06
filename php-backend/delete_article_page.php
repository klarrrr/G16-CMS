<?php

include 'connect.php';

$sectionId = $_POST['section_id'] ?? null;

if (!$sectionId) {
    echo json_encode(['error' => 'No Section ID provided']);
    exit;
}

$stmt1 = $conn->prepare("DELETE FROM sections WHERE section_id = ?");
$stmt1->bind_param("i", $sectionId);
$stmt1->execute();

echo json_encode(["success" => 'Successful Deletion']);

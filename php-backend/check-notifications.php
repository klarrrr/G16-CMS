<?php
include 'connect.php';
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Count unread notifications
$query = "SELECT COUNT(*) as count FROM notifications 
          WHERE user_id = ? AND is_read = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];

echo json_encode(['count' => $count]);

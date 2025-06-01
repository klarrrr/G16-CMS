<?php
session_start();
include 'connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

$query = "SELECT user_id, user_first_name, user_last_name, user_type FROM users ORDER BY user_last_name, user_first_name";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

header('Content-Type: application/json');
echo json_encode($users);
?>
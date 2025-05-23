<?php
include 'connect.php';

header('Content-Type: application/json');

$messageId = intval($_GET['id'] ?? 0);

if ($messageId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid message ID']);
    exit;
}

$query = "SELECT * FROM inbox WHERE inbox_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $messageId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Message not found']);
    exit;
}

$message = mysqli_fetch_assoc($result);
echo json_encode($message);

mysqli_stmt_close($stmt);
mysqli_close($conn);

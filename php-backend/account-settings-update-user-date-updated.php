<?php
include 'connect.php';

$user_id = $_POST['user_id'];

$now = date('Y-m-d H:i:s', time());

// Update date
$query = "UPDATE users SET date_updated = '$now' WHERE user_id = $user_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'success'
]);

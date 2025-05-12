<?php
include 'connect.php';

$user_id = $_POST['user_id'];

$query = "UPDATE users SET date_updated = NOW() WHERE user_id = $user_id";
mysqli_query($conn, $query);

echo json_encode([
    'status' => 'success'
]);

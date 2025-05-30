<?php
session_start();
include 'connect.php';

$user_id = $_POST['user_id'];
$base64String = $_POST['base64String'];

$query = "UPDATE users SET cover_photo = '$base64String' WHERE user_id = $user_id";

mysqli_query($conn, $query);

$_SESSION['cover_photo'] = $base64String;

echo json_encode([
    'status' => 'success'
]);

<?php
include 'connect.php';
header('Content-Type: application/json');

$query = "SELECT DISTINCT tag_name FROM tags ORDER BY tag_name";
$result = mysqli_query($conn, $query);

$tags = array_column(mysqli_fetch_all($result, MYSQLI_ASSOC), 'tag_name');
echo json_encode($tags);
?>
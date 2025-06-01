<?php
include 'connect.php';

header('Content-Type: application/json');

$query = "SELECT * FROM inbox WHERE replied = 0 ORDER BY date_created DESC";
$result = mysqli_query($conn, $query);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

echo json_encode($messages);

mysqli_close($conn);

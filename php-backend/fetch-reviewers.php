<?php
include 'connect.php';
header('Content-Type: application/json');

$query = "SELECT user_id, user_first_name, user_last_name 
          FROM users 
          WHERE user_type = 'reviewer'";
$result = mysqli_query($conn, $query);

$reviewers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviewers[] = $row;
}

echo json_encode($reviewers);

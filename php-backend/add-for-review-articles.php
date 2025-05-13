<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];
$user_type = strtolower($_SESSION['user_type']);

$query = "
    SELECT 
        w.*,
        a.article_id, a.edit_status,
        u.user_first_name, u.user_last_name
    FROM widgets w
    LEFT JOIN articles a ON w.article_owner = a.article_id
    LEFT JOIN users u ON w.user_owner = u.user_id
    ORDER BY w.widget_id DESC
";

$result = mysqli_query($conn, $query);

$finalData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $finalData[] = $row;
}

echo json_encode(['data' => $finalData]);

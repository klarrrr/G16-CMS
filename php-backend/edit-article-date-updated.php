<?php
include 'connect.php';

session_start();

$article_id = intval($_POST['article_id']);
$action = mysqli_real_escape_string($conn, $_POST['action']);
$user_id = $_SESSION['user_id']; // Ensure user_id is set

// Update timestamps
mysqli_query($conn, "UPDATE articles SET date_updated = NOW() WHERE article_id = $article_id");
mysqli_query($conn, "UPDATE widgets SET date_updated = NOW() WHERE article_owner = $article_id");

// Insert into audit_logs
$insertLogQuery = "
    INSERT INTO audit_logs (user_owner, article_owner, action, log_time)
    VALUES ($user_id, $article_id, '$action', NOW())
";
mysqli_query($conn, $insertLogQuery);

// Get the updated date
$result = mysqli_query($conn, "SELECT date_updated FROM articles WHERE article_id = $article_id");
$date_updated = null;

if ($row = mysqli_fetch_assoc($result)) {
    $date_updated = $row['date_updated'];
}

echo json_encode([
    'date_updated' => $date_updated
]);

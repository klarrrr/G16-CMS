<?php

include 'connect.php';

$articleId = $_POST['article_id'];
$user_id = $_POST['user_id'];

// $articleId = 51;
// $user_id = 4;

$user_type = null;
$query = "SELECT user_type FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $user_type = $row['user_type'];
}

$status = 'Invalid User Type';

// Confirm if user is a reviewer
// ONly reviewer can approve an article
if ($user_type == 'reviewer') {

    // Confirm first if approve status of article is not approved yet
    $flag = false;

    $query = "SELECT approve_status FROM articles WHERE article_id = $articleId";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['approve_status'] == 'no') {
            $flag = true;
        }
    }

    if ($flag) {
        $query1 = "UPDATE articles SET approve_status = 'yes' WHERE article_id = $articleId";
        mysqli_query($conn, $query1);
        $status = "yes";
    } else {
        $query1 = "UPDATE articles SET approve_status = 'no' WHERE article_id = $articleId";
        mysqli_query($conn, $query1);
        $status = "no";
    }
}

echo json_encode([
    'status' => $status
]);

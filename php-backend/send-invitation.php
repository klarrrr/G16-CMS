<?php
include 'connect.php';
session_start();

$article_id = $_POST['article_id'];
$reviewer_id = $_POST['reviewer_id'];
$inviter_id = $_POST['inviter_id'];

// Check if there's already an approver for this article
$checkApproverQuery = "SELECT * FROM invitations 
                      WHERE article_id = $article_id AND is_approver = 1";
$checkResult = mysqli_query($conn, $checkApproverQuery);

if (mysqli_num_rows($checkResult) > 0) {
    echo json_encode(['success' => false, 'message' => 'This article already has an approver']);
    exit;
}

// Insert new invitation
$query = "INSERT INTO invitations (article_id, reviewer_id, inviter_id, is_approver, status)
          VALUES ($article_id, $reviewer_id, $inviter_id, 1, 'pending')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}

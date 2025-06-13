<?php

session_start();

include 'connect.php';

$user_id = $_POST['user_id'];
$userFirstName = $_POST['userFirstName'];
$userLastName = $_POST['userLastName'];
$userEmail = $_POST['userEmail'];

// Prepare user query update
$query = "UPDATE users SET user_first_name = ?, user_last_name = ?, user_email = ? WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("sssi", $userFirstName, $userLastName, $userEmail, $user_id);

$_SESSION['user_first'] = $userFirstName;
$_SESSION['user_last'] = $userLastName;
$_SESSION['user_email'] = $userEmail;

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execute failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

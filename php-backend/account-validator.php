<?php

include 'connect.php';

// $email = 'kc@plpasig.edu.ph';
// $pass = '123';
$email = $_POST['email'] ?? null;
$pass = $_POST['pass'] ?? null;

if (!$email || !$pass) {
    echo json_encode(['error' => 'No Email or Pass provided']);
    exit;
}

$userArray = [];

$queryUser = "SELECT * FROM users WHERE user_email = '$email' AND user_pass = '$pass'";

$userResult = mysqli_query($conn, $queryUser);

while ($row = mysqli_fetch_assoc($userResult)) {
    $userArray[] = $row; // Add section row
}

echo json_encode([
    'user' => $userArray
]);

<?php

include 'connect.php';

// Prepare and execute query
$query = 'SELECT * FROM users';
$result = mysqli_query($conn, $query);

// Check for query success
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch users']);
    exit;
}

// Fetch all users
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Output as JSON
header('Content-Type: application/json');
echo json_encode($users);

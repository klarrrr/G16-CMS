<?php
include 'connect.php';

// Temporary, change to be dynamic later
$currentTemplate = 1;
$selectedPages = [];

// Temporarily template first, change to project later
$querySelectPages = "SELECT * FROM pages WHERE template_owner = $currentTemplate";
$result = mysqli_query($conn, $querySelectPages);

while ($row = mysqli_fetch_assoc($result)) {
    $selectedPages[] = $row; // <-- append each row to the array
}

echo json_encode(['result' => $selectedPages]);

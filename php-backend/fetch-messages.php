<?php
include 'connect.php';

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$offset = ($page - 1) * $perPage;

// Get total count
$countStmt = $conn->query("SELECT COUNT(*) as total FROM inbox");
$total = $countStmt->fetch_assoc()['total'];

// Get paginated messages
$stmt = $conn->prepare("
    SELECT inbox_id, sender_first_name, sender_last_name, sender_email, subject, message, date_created 
    FROM inbox 
    WHERE replied = 0
    ORDER BY date_created DESC 
    LIMIT ? OFFSET ?
");
$stmt->bind_param("ii", $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode([
    'messages' => $messages,
    'total' => $total,
    'page' => $page,
    'per_page' => $perPage
]);

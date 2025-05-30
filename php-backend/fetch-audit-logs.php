<?php
include 'connect.php';

// Get filter parameters
$user_id = $_GET['user_id'] ?? '';
$action = $_GET['action'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$page = intval($_GET['page'] ?? 1);
$limit = 10; // Items per page
$offset = ($page - 1) * $limit;

// Build WHERE conditions
$conditions = [];
$params = [];
$types = '';

if (!empty($user_id)) {
    $conditions[] = "audit_logs.user_owner = ?";
    $params[] = $user_id;
    $types .= 'i';
}

if (!empty($action)) {
    $conditions[] = "audit_logs.action = ?";
    $params[] = $action;
    $types .= 's';
}

if (!empty($date_from)) {
    $conditions[] = "audit_logs.log_time >= ?";
    $params[] = $date_from . ' 00:00:00';
    $types .= 's';
}

if (!empty($date_to)) {
    $conditions[] = "audit_logs.log_time <= ?";
    $params[] = $date_to . ' 23:59:59';
    $types .= 's';
}

$where = empty($conditions) ? '1=1' : implode(' AND ', $conditions);

// Count total records
$countQuery = "SELECT COUNT(*) as total FROM audit_logs WHERE $where";
$countStmt = $conn->prepare($countQuery);

if (!empty($params)) {
    $countStmt->bind_param($types, ...$params);
}

$countStmt->execute();
$total = $countStmt->get_result()->fetch_assoc()['total'];
$countStmt->close();

// Fetch logs with user and article info
$query = "
    SELECT 
        audit_logs.*, 
        CONCAT(users.user_first_name, ' ', users.user_last_name) AS user_name,
        users.user_type,
        articles.article_title
    FROM audit_logs
    LEFT JOIN users ON audit_logs.user_owner = users.user_id
    LEFT JOIN articles ON audit_logs.article_owner = articles.article_id
    WHERE $where
    ORDER BY audit_logs.log_time DESC
    LIMIT ? OFFSET ?
";

$stmt = $conn->prepare($query);
$types .= 'ii';
$params[] = $limit;
$params[] = $offset;

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$logs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'data' => $logs,
    'total' => $total,
    'page' => $page,
    'per_page' => $limit,
    'total_pages' => ceil($total / $limit)
]);

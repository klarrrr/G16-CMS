<?php
session_start();
include 'connect.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Get filter parameters with sanitization
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : '';
$user_type = isset($_GET['user_type']) ? $_GET['user_type'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
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

if (!empty($user_type)) {
    $conditions[] = "users.user_type = ?";
    $params[] = $user_type;
    $types .= 's';
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
$countQuery = "SELECT COUNT(*) as total 
              FROM audit_logs
              LEFT JOIN users ON audit_logs.user_owner = users.user_id
              WHERE $where";
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
        articles.article_title,
        audit_logs.action
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

// Get all unique actions for filter population
$actionsQuery = "SELECT DISTINCT action FROM audit_logs ORDER BY action";
$actionsResult = $conn->query($actionsQuery);
$availableActions = [];
while ($row = $actionsResult->fetch_assoc()) {
    $availableActions[] = $row['action'];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'data' => $logs,
    'total' => $total,
    'page' => $page,
    'per_page' => $limit,
    'total_pages' => ceil($total / $limit),
    'available_actions' => $availableActions
]);
?>
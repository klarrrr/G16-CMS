<?php

include 'connect.php';

$user_id = $_GET['user_id'] ?? '';
$action = $_GET['action'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

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

$query = "
    SELECT 
        audit_logs.log_id,
        CONCAT(users.user_first_name, ' ', users.user_last_name) AS user_name,
        articles.article_title,
        audit_logs.action,
        audit_logs.log_time
    FROM audit_logs
    LEFT JOIN users ON audit_logs.user_owner = users.user_id
    LEFT JOIN articles ON audit_logs.article_owner = articles.article_id
    WHERE $where
    ORDER BY audit_logs.log_time DESC
";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=audit_logs_export_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

fputcsv($output, [
    'Log ID',
    'User',
    'Article',
    'Action',
    'Timestamp'
]);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['log_id'],
        $row['user_name'] ?? 'N/A',
        $row['article_title'] ?? 'N/A',
        $row['action'],
        $row['log_time']
    ]);
}

fclose($output);
$stmt->close();
$conn->close();

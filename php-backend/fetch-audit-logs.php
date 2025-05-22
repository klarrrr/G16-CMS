<?php
session_start();
include 'connect.php';

$limit = intval($_GET['limit'] ?? 10);
$page = intval($_GET['page'] ?? 1);
$offset = ($page - 1) * $limit;
$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'desc';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Sanitize
$sort = ($sort === 'asc') ? 'ASC' : 'DESC';

// Date filters
$dateFilter = "";
if ($start_date && $end_date) {
    $dateFilter = "AND audit_logs.log_time BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
} elseif ($start_date) {
    $dateFilter = "AND audit_logs.log_time >= '$start_date 00:00:00'";
} elseif ($end_date) {
    $dateFilter = "AND audit_logs.log_time <= '$end_date 23:59:59'";
}


$user_id = $_SESSION['user_id'];
$user_type = strtolower($_SESSION['user_type'] ?? '');

// Base search SQL
$searchSql = $search ? "AND (
    users.user_first_name LIKE '%$search%' OR 
    users.user_last_name LIKE '%$search%' OR 
    articles.article_title LIKE '%$search%' OR 
    audit_logs.action LIKE '%$search%'
)" : "";

// Restrict if writer
$ownershipSql = ($user_type === 'writer') ? "AND audit_logs.user_owner = $user_id" : "";

// Count total
$totalQuery = "
    SELECT COUNT(*) as total 
    FROM audit_logs 
    JOIN users ON audit_logs.user_owner = users.user_id 
    JOIN articles ON audit_logs.article_owner = articles.article_id 
    WHERE 1=1 $searchSql $dateFilter $ownershipSql
";
$totalResult = mysqli_query($conn, $totalQuery);
$total = mysqli_fetch_assoc($totalResult)['total'];

// Fetch data
$query = "
    SELECT 
        audit_logs.*, 
        CONCAT(users.user_first_name, ' ', users.user_last_name) AS user_name, 
        articles.article_title AS article_title 
    FROM audit_logs 
    JOIN users ON audit_logs.user_owner = users.user_id 
    JOIN articles ON audit_logs.article_owner = articles.article_id 
    WHERE 1=1 $searchSql $dateFilter $ownershipSql
    ORDER BY audit_logs.log_time $sort
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $logs[] = $row;
}

echo json_encode([
    'logs' => $logs,
    'total' => $total,
    'page' => $page,
    'limit' => $limit
]);

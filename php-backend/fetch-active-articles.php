<?php
include 'connect.php';

$user_id = $_POST['user_id'];
$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$sort = (isset($_POST['sort']) && $_POST['sort'] === 'asc') ? 'ASC' : 'DESC';

$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$limit = isset($_POST['limit']) ? (int) $_POST['limit'] : 6;
$offset = ($page - 1) * $limit;

// Base query
$baseSql = "FROM articles AS a
            LEFT JOIN widgets AS w 
                ON w.article_owner = a.article_id 
                AND w.user_owner = a.user_owner
            INNER JOIN users AS u 
                ON u.user_id = a.user_owner
            WHERE a.archive_status = 'active'
              AND a.user_owner = ?";

$params = [$user_id];
$types = 'i';

if (!empty($search)) {
    $baseSql .= " AND (a.article_title LIKE ? OR w.widget_paragraph LIKE ?)";
    $searchParam = '%' . $search . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'ss';
}

// Get total count for pagination
$countSql = "SELECT COUNT(DISTINCT a.article_id) AS total " . $baseSql;
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param($types, ...$params);
$countStmt->execute();
$countResult = $countStmt->get_result()->fetch_assoc();
$totalRows = $countResult['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch paginated articles
$dataSql = "SELECT 
                a.article_id, 
                a.article_title, 
                a.completion_status,
                a.approve_status, 
                a.date_posted, 
                a.article_type,
                a.date_updated,
                w.widget_img,
                w.widget_paragraph,
                u.user_first_name,
                u.user_last_name
            $baseSql
            GROUP BY a.article_id
            ORDER BY a.date_updated $sort
            LIMIT ? OFFSET ?";

$params[] = $limit;
$params[] = $offset;
$types .= 'ii';

$dataStmt = $conn->prepare($dataSql);
$dataStmt->bind_param($types, ...$params);
$dataStmt->execute();
$result = $dataStmt->get_result();

$activeArticles = [];
while ($row = $result->fetch_assoc()) {
    $activeArticles[] = $row;
}

echo json_encode([
    'articles' => $activeArticles,
    'totalPages' => $totalPages
]);

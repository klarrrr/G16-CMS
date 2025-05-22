<?php
include 'connect.php';

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$sort = isset($_POST['sort']) && $_POST['sort'] === 'asc' ? 'ASC' : 'DESC';

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$perPage = 6; // articles per page
$offset = ($page - 1) * $perPage;

// Count query
$countSql = "SELECT COUNT(*) as total FROM articles AS a
LEFT JOIN widgets AS w ON w.article_owner = a.article_id AND w.user_owner = a.user_owner
WHERE a.archive_status = 'active'";

if (!empty($search)) {
    $countSql .= " AND (a.article_title LIKE ? OR w.widget_paragraph LIKE ?)";
    $countStmt = $conn->prepare($countSql);
    $searchParam = '%' . $search . '%';
    $countStmt->bind_param('ss', $searchParam, $searchParam);
} else {
    $countStmt = $conn->prepare($countSql);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$total = $countResult->fetch_assoc()['total'];
$countStmt->close();

$sql = "SELECT 
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
        FROM articles AS a
        LEFT JOIN widgets AS w 
            ON w.article_owner = a.article_id 
            AND w.user_owner = a.user_owner
        INNER JOIN users AS u 
            ON u.user_id = a.user_owner
        WHERE a.archive_status = 'active'";

if (!empty($search)) {
    $sql .= " AND (a.article_title LIKE ? OR w.widget_paragraph LIKE ?)";
}

$sql .= " ORDER BY a.date_updated $sort LIMIT ? OFFSET ?";

if (!empty($search)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssii', $searchParam, $searchParam, $perPage, $offset);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $perPage, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$activeArticles = [];

while ($row = $result->fetch_assoc()) {
    $activeArticles[] = $row;
}

echo json_encode([
    'articles' => $activeArticles,
    'total' => $total,
    'per_page' => $perPage,
    'current_page' => $page
]);

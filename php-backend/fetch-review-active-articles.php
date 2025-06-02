<?php
session_start();

$user_id = $_SESSION['user_id'];
include 'connect.php';

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$sort = isset($_POST['sort']) && $_POST['sort'] === 'asc' ? 'ASC' : 'DESC';

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$perPage = 6;
$offset = ($page - 1) * $perPage;

// Count query with article_review_invites check
$countSql = "SELECT COUNT(DISTINCT a.article_id) as total 
             FROM articles AS a
             LEFT JOIN widgets AS w ON w.article_owner = a.article_id AND w.user_owner = a.user_owner
             INNER JOIN users AS u ON u.user_id = a.user_owner
             INNER JOIN article_review_invites i ON a.article_id = i.article_id AND i.reviewer_id = ? AND i.status = 'accepted'
             WHERE a.archive_status = 'active'";

if (!empty($search)) {
    $countSql .= " AND (a.article_title LIKE ? OR w.widget_paragraph LIKE ?)";
}

$countStmt = $conn->prepare($countSql);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $countStmt->bind_param('iss', $user_id, $searchParam, $searchParam);
} else {
    $countStmt->bind_param('i', $user_id);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$total = $countResult->fetch_assoc()['total'];
$countStmt->close();

// Main query with article_review_invites check
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
        LEFT JOIN widgets AS w ON w.article_owner = a.article_id AND w.user_owner = a.user_owner
        INNER JOIN users AS u ON u.user_id = a.user_owner
        INNER JOIN article_review_invites i ON a.article_id = i.article_id AND i.reviewer_id = ? AND i.status = 'accepted'
        WHERE a.archive_status = 'active'";

if (!empty($search)) {
    $sql .= " AND (a.article_title LIKE ? OR w.widget_paragraph LIKE ?)";
}

$sql .= " ORDER BY a.date_updated $sort LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

if (!empty($search)) {
    $searchParam = '%' . $search . '%';
    $stmt->bind_param('issii', $user_id, $searchParam, $searchParam, $perPage, $offset);
} else {
    $stmt->bind_param('iii', $user_id, $perPage, $offset);
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

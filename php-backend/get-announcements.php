<?php
include 'connect.php';

try {
    $query = "
        SELECT 
            a.article_id, 
            a.article_title, 
            a.date_posted,
            w.widget_img
        FROM articles a
        LEFT JOIN widgets w 
            ON w.article_owner = a.article_id 
            AND w.date_created = (
                SELECT MIN(date_created) 
                FROM widgets 
                WHERE article_owner = a.article_id
            )
        WHERE 
            a.archive_status = 'active' AND
            a.completion_status = 'published' AND
            a.approve_status = 'yes' AND
            a.article_type = 'announcement' AND
            a.date_posted IS NOT NULL
        ORDER BY a.date_posted DESC
        LIMIT 5
    ";

    $result = mysqli_query($conn, $query);

    $announcements = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $announcements[] = [
            'article_id' => $row['article_id'],
            'article_title' => $row['article_title'],
            'date_posted' => date("F j, Y", strtotime($row['date_posted'])),
            'widget_img' => $row['widget_img'] ?? 'pics/sample1.jpg',
        ];
    }

    echo json_encode($announcements);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

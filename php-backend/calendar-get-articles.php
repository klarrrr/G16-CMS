<?php
include 'connect.php';

try {
    $query = "
        SELECT 
            a.article_id, 
            a.article_title, 
            a.date_posted,
            w.widget_title,
            w.widget_img,
            w.widget_paragraph
        FROM articles a
        LEFT JOIN widgets w ON w.article_owner = a.article_id
            AND w.date_created = (
                SELECT MIN(date_created) 
                FROM widgets 
                WHERE article_owner = a.article_id
            )
        WHERE 
            a.completion_status = 'published' AND
            a.approve_status = 'yes' AND
            a.date_posted IS NOT NULL
        ORDER BY a.date_posted DESC
    ";

    $result = mysqli_query($conn, $query);

    $articles = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }

    echo json_encode($articles);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

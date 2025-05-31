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
            w.widget_paragraph,
            u.user_first_name,
            u.user_last_name
        FROM articles a
        LEFT JOIN widgets w ON w.article_owner = a.article_id
            AND w.date_created = (
                SELECT MIN(date_created) 
                FROM widgets 
                WHERE article_owner = a.article_id
            )
        LEFT JOIN users u ON u.user_id = a.user_owner
        WHERE 
            a.completion_status = 'published' AND
            a.approve_status = 'yes' AND
            a.date_posted IS NOT NULL
        ORDER BY a.date_posted DESC
    ";

    $result = mysqli_query($conn, $query);
    $articles = [];

    $minYear = PHP_INT_MAX;
    $maxYear = PHP_INT_MIN;

    $fallbackImage = 'pics/plp-outside.jpg';

    while ($row = mysqli_fetch_assoc($result)) {
        // Apply image fallback logic here:
        $row['widget_img'] = !empty($row['widget_img']) ? $row['widget_img'] : $fallbackImage;

        $articles[] = $row;

        $year = (int)date('Y', strtotime($row['date_posted']));
        if ($year < $minYear) $minYear = $year;
        if ($year > $maxYear) $maxYear = $year;
    }

    $response = [
        'articles' => $articles,
        'minYear' => $minYear === PHP_INT_MAX ? null : $minYear,
        'maxYear' => $maxYear === PHP_INT_MIN ? null : $maxYear
    ];

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

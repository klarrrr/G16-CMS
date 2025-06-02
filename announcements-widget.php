<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'php-backend/connect.php';

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$limit = max(1, min(10, $limit));
$layout = isset($_GET['layout']) && $_GET['layout'] === 'row' ? 'row' : 'column';
$isPreview = isset($_GET['preview']);

try {
    $query = "SELECT 
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
        LIMIT ?";
        
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $announcements = [];
    while ($row = $result->fetch_assoc()) {
        $announcements[] = [
            'article_id' => $row['article_id'],
            'article_title' => $row['article_title'],
            'date_posted' => date("F j, Y", strtotime($row['date_posted'])),
            'widget_img' => $row['widget_img'] ?? 'pics/sample1.jpg',
        ];
    }

} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$baseURL = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/article.php';
?>
<!DOCTYPE html>
<html>
<head>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }
    .announcements-widget {
      width: 100%;
      padding: 15px;
      background: <?= $isPreview ? 'transparent' : '#f8f9fa' ?>;
    }
    .layout-column .event {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
      background: #14452F;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.2s;
      color: white;
    }
    .layout-row #upcoming-events-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }
    .layout-row .event {
      flex: 1 1 300px;
      display: flex;
      flex-direction: column;
      min-height: 200px;
      background: #14452F;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.2s;
      color: white;
    }
    .layout-row .event img {
      width: 100%;
      height: 120px;
      object-fit: cover;
    }
    .event:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
      background: #0d301f;
    }
    .layout-column .event img {
      width: 120px;
      height: 100px;
      object-fit: cover;
    }
    .event-text-container {
      padding: 15px;
      flex: 1;
    }
    .event-text-container h3 {
      font-size: 1.1rem;
      margin-bottom: 5px;
      color: white;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      min-height: 2.4em;
    }
    .event-text-container p {
      font-size: 0.85rem;
      color: rgba(255,255,255,0.8);
    }
    .no-events-message {
      padding: 20px;
      text-align: center;
      color: #666;
      font-style: italic;
    }
  </style>
</head>
<body class="layout-<?= $layout ?>">
  <div class="announcements-widget">
    <div id="upcoming-events-container">
      <?php if (empty($announcements)): ?>
        <div class="no-events-message">No upcoming announcements at the moment 😔</div>
      <?php else: ?>
        <?php foreach ($announcements as $article): ?>
          <div class="event" data-articleid="<?= $article['article_id'] ?>">
            <img src="<?= htmlspecialchars($article['widget_img']) ?>" alt="">
            <div class="event-text-container">
              <h3 title="<?= htmlspecialchars($article['article_title']) ?>">
                <?= htmlspecialchars(mb_strimwidth($article['article_title'], 0, 60, '...')) ?>
              </h3>
              <p>Posted on <?= $article['date_posted'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

<script>
  function goToArticle(element) {
    const articleId = element.dataset.articleid;
    const isLocal = window.location.hostname === 'localhost';

    const basePath = isLocal
      ? 'https://localhost/G16-CMS/lundayan-site-article.php'
      : 'https://<?= $_SERVER['HTTP_HOST'] ?>/lundayan-site-article.php';

    if (articleId) {
      window.top.location.href = `${basePath}?article_id=${articleId}`;
    }
  }

  document.querySelectorAll('.event').forEach(event => {
    event.addEventListener('click', function () {
      goToArticle(this);
    });
  });
</script>

</body>
</html>

<?php

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$domain = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];
$fullUrl = $protocol . $domain . $uri;

include 'php-backend/connect.php';

if (!isset($_GET['article_id'])) {
    header('Location: lundayan-site-home.php');
    exit;
}

$article_id = $_GET['article_id'];

$query = "SELECT * FROM articles WHERE article_id = $article_id";
$result = mysqli_query($conn, $query);
$article = null;
if ($row = mysqli_fetch_assoc($result)) {
    $article = $row;
}

$title = $article['article_title'];
$articleUrl = $protocol . $domain . "/article/" . $article_id . "/" . urlencode(strtolower(str_replace(" ", "-", $title)));

$content = $article['article_content'];
$datePosted = $article['date_posted'];

// Pag di pa published or di pa approved yung article WAG.
if ($article['completion_status'] == 'draft' || $article['approve_status'] == 'no') {
    header('Location: lundayan-site-home.php');
    exit;
}

$query = "SELECT * FROM widgets WHERE article_owner = $article_id";
$result = mysqli_query($conn, $query);
$widget = null;
if ($row = mysqli_fetch_assoc($result)) {
    $widget = $row;
}

$image = $widget['widget_img']

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="<?php echo $fullUrl; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>" />
    <meta property="og:description" content="<?php echo substr(strip_tags(html_entity_decode($content)), 0, 150); ?>..." />
    <meta property="og:image" content="data:image/png;base64,<?php echo $image; ?>" />

    <title>Lundayan : Article</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="quill.css" rel="stylesheet" />
    <script src="scripts/quill.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <!-- <div class="news-banner">
            <div class="scrolling-text">
                <span>
                    | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE
                    | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE |
                </span>
            </div>
        </div> -->
        <section class="article-image-container" style='background-image: url(<?php echo 'data:image/png;base64,' . $image; ?>);'>
            <div class="article-image">
                <div class="image-gradient">
                    <!-- <img src="<?php echo 'data:image/png;base64,' . $image; ?>" alt="<?php echo $title; ?>"> -->
                </div>
                <div class="back-next">
                    <a href="#">« Older Post</a>
                    <a href="#">Newer Post »</a>
                </div>
                <div class="text-container-article">
                    <div class='article-time-title-tags-container'>
                        <p class="time-posted"><span id="latest-news-day-posted"></span></p>
                        <h1><?php echo $title ?></h1>
                        <!-- Tags Here -->
                        <div class="filter-tags tags-article" id='filter-tags'>

                        </div>
                    </div>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <!-- <a href="lundayan-site-article.php" id='latest-read-more'>Read More</a> -->
                </div>
            </div>
        </section>





        <div class="ql-snow" id='article-information'>
            <div class="ql-editor" style="padding: 0;">
                <?php echo html_entity_decode($content); ?>
            </div>
        </div>
        <section class="article-gallery">
            <div class="gallery-title-container">
                <h2>Gallery</h2>
            </div>
            <div class="gallery-images">
                <!-- Images will be placed here -->
            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>

    <script src="scripts/date-formatter.js"></script>
    <script>
        const datePosted = document.getElementById('latest-news-day-posted');
        datePosted.innerHTML = formatDateTime("<?php echo $datePosted; ?>");
    </script>

    <!-- Script for gettings tags -->
    <script>
        const articleId = <?php echo $article_id; ?>;
    </script>
    <script src="scripts/lundayan-article-get-tags.js"></script>


    <!-- Load Galllery -->
    <script>
        const galleryContainer = document.querySelector('.gallery-images');
    </script>
    <script src="scripts/lundayan-load-article.js"></script>
</body>

</html>
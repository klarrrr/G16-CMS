<?php

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
$content = $article['article_content'];
// Change this in the future to date_posted
$datePosted = $article['date_updated'];

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
    <title>Lundayan : Article</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <link href="quill.css" rel="stylesheet" />
    <script src="scripts/quill.js"></script>
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
                    <div>
                        <p class="time-posted">Posted <small>●</small> <span id="latest-news-day-posted"></span></p>
                        <h1><?php echo $title ?></h1>
                    </div>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <!-- <a href="lundayan-site-article.php" id='latest-read-more'>Read More</a> -->
                </div>
            </div>
        </section>
        <!-- <div class="news-banner">
            <div class="scrolling-text">
                <span> | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | ARTICLE | </span>
            </div>
        </div> -->
        <section id="article-information" class='ql-editor'>
            <!-- This is where content will go -->
            <?php echo html_entity_decode($content); ?>
        </section>
        <!-- <div class="news-banner">
            <div class="scrolling-text">
                <span>
                    | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY
                    | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY | GALLERY |
                </span>
            </div>
        </div> -->
        <section class="article-gallery">
            <div class="gallery-title-container">
                <h2>Gallery</h2>
            </div>
            <div class="gallery-images">
                <img src="gallery/1.jpg" alt="">
                <img src="gallery/2.jpg" alt="">
                <img src="gallery/3.jpg" alt="">
                <img src="gallery/4.jpg" alt="">
                <img src="gallery/5.jpg" alt="">
                <img src="gallery/6.jpg" alt="">
                <img src="gallery/7.jpg" alt="">
                <img src="gallery/8.jpg" alt="">
                <img src="gallery/9.jpg" alt="">
                <img src="gallery/10.jpg" alt="">
                <img src="gallery/11.jpg" alt="">
                <img src="gallery/12.jpg" alt="">
                <img src="gallery/13.jpg" alt="">
                <img src="gallery/14.jpg" alt="">
                <img src="gallery/15.jpg" alt="">
                <img src="gallery/16.jpg" alt="">
            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>

    <script src="scripts/date-formatter.js"></script>
    <script>
        const datePosted = document.getElementById('latest-news-day-posted');
        datePosted.innerHTML = formatDateTime("<?php echo $datePosted; ?>");
    </script>
</body>

</html>
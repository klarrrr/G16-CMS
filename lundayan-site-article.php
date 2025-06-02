<?php session_start(); ?>

<?php

include 'php-backend/connect.php';

if (!isset($_GET['article_id'])) {
    header('Location: index.php');
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
$title = mb_convert_encoding($title, 'UTF-8', 'UTF-8');
$content = $article['article_content'];
$datePosted = $article['date_posted'];

if ($article['completion_status'] == 'draft' || $article['approve_status'] == 'no') {
    header('Location: index.php');
    exit;
}

$query = "SELECT * FROM widgets WHERE article_owner = $article_id";
$result = mysqli_query($conn, $query);
$widget = null;
if ($row = mysqli_fetch_assoc($result)) {
    $widget = $row;
}

$image = !empty($widget['widget_img']) ? $widget['widget_img'] : null;
$fallbackImage = 'pics/plp-outside.jpg';

// --- Find Older Article (posted before current one) ---
$olderQuery = "SELECT article_id, article_title FROM articles 
    WHERE date_posted < '{$article['date_posted']}' 
    AND approve_status = 'yes' 
    AND completion_status = 'published' 
    ORDER BY date_posted DESC 
    LIMIT 1";

$olderResult = mysqli_query($conn, $olderQuery);
$olderArticle = mysqli_fetch_assoc($olderResult);

// --- Find Newer Article (posted after current one) ---
$newerQuery = "SELECT article_id, article_title FROM articles 
    WHERE date_posted > '{$article['date_posted']}' 
    AND approve_status = 'yes' 
    AND completion_status = 'published' 
    ORDER BY date_posted ASC 
    LIMIT 1";

$newerResult = mysqli_query($conn, $newerQuery);
$newerArticle = mysqli_fetch_assoc($newerResult);

function shortenTitle($title, $maxLength = 40)
{
    $decoded = htmlspecialchars_decode($title);
    return strlen($decoded) > $maxLength ? substr($decoded, 0, $maxLength - 3) . '...' : $decoded;
}

function timeAgoLimited($datetime)
{
    if (!$datetime || strtotime($datetime) === false) {
        return "unknown time";
    }

    $timestamp = strtotime($datetime);
    $now = time();

    if ($timestamp > $now) {
        return "just now";
    }

    $difference = $now - $timestamp;

    if ($difference < 60) {
        return "$difference minutes ago";
    } elseif ($difference < 3600) {
        $minutes = floor($difference / 60);
        return "$minutes minutes ago";
    } elseif ($difference < 86400) {
        $hours = floor($difference / 3600);
        return "$hours hours ago";
    } elseif ($difference < 2592000) {
        $days = floor($difference / 86400);
        return "$days days ago";
    } else {
        return "more than 30 days ago";
    }
}


// Get writer info
$writerId = $article['user_owner'];
$writerQuery = "SELECT user_first_name, user_last_name, user_type, profile_picture FROM users WHERE user_id = $writerId";
$writerResult = mysqli_query($conn, $writerQuery);
$writer = mysqli_fetch_assoc($writerResult);
$writerName = $writer['user_first_name'] . ' ' . $writer['user_last_name'];
$writerType = ucfirst($writer['user_type']); // "Writer"
$writerPfp = $writer['profile_picture'];
$timeAgo = timeAgoLimited($article['date_posted']);



$reviewersQuery = "
    SELECT DISTINCT u.user_id, u.user_first_name, u.user_last_name, u.profile_picture
    FROM article_review_invites ari
    JOIN users u ON ari.reviewer_id = u.user_id
    WHERE ari.article_id = $article_id
    AND ari.status = 'accepted'
";
$reviewersResult = mysqli_query($conn, $reviewersQuery);

// Function to safely limit HTML content
function limitHtmlContent($content, $limit = 600)
{
    $decoded = html_entity_decode($content);
    $plainText = strip_tags($decoded);

    if (strlen($plainText) <= $limit) {
        return $content;
    }

    $truncated = substr($plainText, 0, $limit);
    $lastSpace = strrpos($truncated, ' ');
    if ($lastSpace !== false) {
        $truncated = substr($truncated, 0, $lastSpace);
    }

    return htmlspecialchars($truncated) . '... <a href="#" class="read-more">Read More</a>';
}
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
    <meta property="og:image" content="<?php echo $image; ?>" />

    <title>Lundayan : Article</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Online Quill Css -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <!-- Offline Quill css -->
    <!-- <link href="quill.css" rel="stylesheet" /> -->
    <!-- Online Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- Offline Quill JS -->
    <!-- <script src="scripts/quill.js"></script> -->
    <style>
        /* Share button styles */
        .article-share-container {
            margin: 20px 0;
            display: flex;
        }

        .share-button {
            background-color: #fcb404;
            color: #161616;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .share-button:hover {
            background-color: rgb(185, 134, 4);
        }

        .share-button svg {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="article-image-container" style='background-image: url("<?php echo $image ? $image : $fallbackImage; ?>");'>

            <div class="article-image">
                <div class="image-gradient">
                </div>

                <div class="text-container-article">

                    <div>
                        <?php if ($olderArticle): ?>
                            <a href="lundayan-site-article.php?article_id=<?php echo $olderArticle['article_id']; ?>"
                                title="<?php echo htmlspecialchars_decode($olderArticle['article_title']); ?>">
                                « <?php echo mb_convert_encoding(shortenTitle($olderArticle['article_title']), 'UTF-8', 'UTF-8') ?>
                            </a>

                        <?php endif; ?>
                    </div>

                    <div class='article-time-title-tags-container'>
                        <p class="time-posted"><span id="latest-news-day-posted"></span></p>
                        <h1><?php echo $title ?></h1>
                        <!-- Tags Here -->
                        <div class="filter-tags tags-article" id='filter-tags'>

                        </div>
                    </div>

                    <div>
                        <?php if ($newerArticle): ?>
                            <a style='justify-self: flex-end;' href="lundayan-site-article.php?article_id=<?php echo $newerArticle['article_id']; ?>"
                                title="<?php echo htmlspecialchars_decode($newerArticle['article_title']); ?>">
                                <?php echo mb_convert_encoding(shortenTitle($newerArticle['article_title']), 'UTF-8', 'UTF-8') ?> »
                            </a>

                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </section>

        <!-- WRITERS, READERS AND ARTICLE CONTENT -->
        <div class="writers-readers-article-content-container">

            <!-- WRITERS AND READERS -->
            <div class="writers-readers-container">
                <!-- OPTIONS -->
                <div class="article-options">
                    <h3>Options</h3>
                    <!-- Add this inside the article-image-container section, after the title -->
                    <div class="article-share-container">
                        <button id="share-button" class="share-button">
                            <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M11 6C12.6569 6 14 4.65685 14 3C14 1.34315 12.6569 0 11 0C9.34315 0 8 1.34315 8 3C8 3.22371 8.02449 3.44169 8.07092 3.65143L4.86861 5.65287C4.35599 5.24423 3.70652 5 3 5C1.34315 5 0 6.34315 0 8C0 9.65685 1.34315 11 3 11C3.70652 11 4.35599 10.7558 4.86861 10.3471L8.07092 12.3486C8.02449 12.5583 8 12.7763 8 13C8 14.6569 9.34315 16 11 16C12.6569 16 14 14.6569 14 13C14 11.3431 12.6569 10 11 10C10.2935 10 9.644 10.2442 9.13139 10.6529L5.92908 8.65143C5.97551 8.44169 6 8.22371 6 8C6 7.77629 5.97551 7.55831 5.92908 7.34857L9.13139 5.34713C9.644 5.75577 10.2935 6 11 6Z" fill="#161616"></path>
                                </g>
                            </svg>
                            <span>Share</span>
                        </button>
                    </div>
                </div>

                <!-- WRITERS -->
                <div class="article-meta writer">
                    <h3><?php echo $writerType; ?></h3>
                    <div class="user-card">
                        <img class="pfp" src="<?php echo $writerPfp; ?>" alt="Writer PFP">
                        <div class="user-info">
                            <p class="name"><?php echo $writerName; ?></p>
                            <p class="time"><?php echo $timeAgo; ?></p>
                        </div>
                    </div>
                </div>


                <!-- READERS -->
                <div class="article-meta reviewers">
                    <h3>Reviewers</h3>
                    <?php while ($reviewer = mysqli_fetch_assoc($reviewersResult)) : ?>
                        <div class="user-card">
                            <img class="pfp" src="<?php echo $reviewer['profile_picture']; ?>" alt="Reviewer PFP">
                            <div class="user-info">
                                <p class="name"><?php echo $reviewer['user_first_name'] . ' ' . $reviewer['user_last_name']; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
            <!-- ARTICLE CONTENT -->
            <div class="ql-snow" id='article-information'>
                <div class="ql-editor" style="padding: 0;">
                    <div class="limited-content">
                        <?php echo htmlspecialchars_decode($content, 600); ?>
                    </div>
                    <div class="full-content">
                        <?php echo htmlspecialchars_decode($content); ?>
                    </div>
                    <div class="read-more-container">
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
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
    <!-- Load Galllery -->
    <script src="scripts/lundayan-load-article.js"></script>
    <!-- Limit Article -->
    <script src="scripts/article-limiter.js"></script>

    <!-- Share Button -->
    <script>
        document.getElementById('share-button').addEventListener('click', function() {
            // Get the current article URL
            const articleUrl = window.location.href;
            const articleTitle = "<?php echo addslashes($title); ?>";

            // Check if Web Share API is available (mobile devices)
            if (navigator.share) {
                navigator.share({
                    title: articleTitle,
                    text: 'Check out this article from Lundayan:',
                    url: articleUrl
                }).catch(err => {
                    console.log('Error sharing:', err);
                    fallbackShare(articleUrl, articleTitle);
                });
            } else {
                // Fallback for desktop browsers
                fallbackShare(articleUrl, articleTitle);
            }
        });

        function fallbackShare(url, title) {
            // Create a temporary input element
            const tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Show a message to the user
            alert('Article link copied to clipboard!\n\nShare this URL: ' + url);

            // Alternatively, open a popup with social sharing options
            // window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url), '_blank');
            // window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(title + ' ' + url), '_blank');
        }
    </script>

</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

if (strtolower($_SESSION['user_type']) != 'reviewer') {
    header('Location: editor-dashboard.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : For Review Articles</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container">
        <div class="main-page" id='main-page'>
            <div class="add-article-title-container">
                <div class="article-page-title">
                    <h1>Articles</h1>
                    <p>Review Articles</p>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Search for articles" id='search-your-articles'>
                </div>
            </div>
            <div class="articles-boxes-container" id='articles-boxes-container'>

            </div>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- populate article container with articles -->
    <script src="scripts/add-for-review-articles.js"></script>
</body>

</html>
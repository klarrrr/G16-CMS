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

$user_id = $_SESSION['user_id'];
$profile_pic = $_SESSION['profile_picture'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : For Review Articles</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="pics/lundayan-logo.png">
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
                    <select id="sort-articles-dropdown" class="sort-dropdown">
                        <option value="desc" selected>Date Updated Descending</option>
                        <option value="asc">Date Updated Ascending</option>
                    </select>
                    <input type="text" placeholder="Search for you articles" id='search-your-active-articles' class='search-your-articles'>
                    <div class="pfp-container">
                        <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" alt="" id='pfp-circle'>
                    </div>
                </div>
            </div>
            <div class="articles-boxes-container" id='articles-boxes-container'>

            </div>
            <div id="pagination" class="pagination-container"></div>

        </div>
    </div>

    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>

    <!-- Grab active articles -->
    <script src="scripts/fetch-review-active-articles.js"></script>

</body>

</html>
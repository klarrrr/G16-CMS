<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

if (strtolower($_SESSION['user_type']) == 'reviewer') {
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
    <title>Contento : Add Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const openPage = 'add-article';
    </script>
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
                    <p>Owned Articles</p>
                </div>
                <div class="search-container">
                    <select id="sort-articles-dropdown" class="sort-dropdown">
                        <option value="desc" selected>Date Updated Descending</option>
                        <option value="asc">Date Updated Ascending</option>
                    </select>
                    <input type="text" placeholder="Search for you articles" id='search-your-active-articles' class='search-your-articles'>
                    <div class="pfp-container" id='add-article-pfp-container'>
                        <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : $profile_pic; ?>" alt="" id='pfp-circle-in-page' style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <div class="articles-boxes-container" id='articles-boxes-container'>

            </div>
            <div id="pagination" class="pagination-container"></div>
            <button class='article-add-article-button' id='article-add-article-button'>+</button>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- event for adding new article -->
    <script>
        const addArticleBtn = document.getElementById('article-add-article-button');
        addArticleBtn.addEventListener('click', () => {
            $.ajax({
                url: 'php-backend/create-article.php',
                type: 'post',
                dataType: 'json',
                data: {
                    title: 'Article Default Title',
                    content: '<p>Your article content journey starts here...</p>',
                    shortDesc: 'Your short description is here...'
                },
                success: (res) => {
                    if (res.status == 'success') {
                        // Get the latest article's id
                        $.ajax({
                            url: 'php-backend/add-article-get-latest-article.php',
                            type: 'post',
                            dataType: 'json',
                            data: {},
                            success: (res) => {
                                if (res.status == 'success') {
                                    // go to edit page with the get id
                                    window.location.href = 'edit-article.php?article_id=' + res.latestArticle;
                                }
                            },
                            error: (error) => {
                                console.log("Create Article Error :" + error);
                            }
                        });
                    }
                },
                error: (error) => {
                    console.log("Create Article Error :" + error);
                }
            });
        });
    </script>


    <!-- Grab active articles -->
    <script>
        const user_id = '<?php echo $user_id ?>';
    </script>
    <script src="scripts/fetch-active-articles.js"></script>

    <!-- \Go to account settings -->
    <script src="scripts/pfp-go-to-account-settings.js"></script>

    <!-- PFP In page -->
    <script>
        const pfpCircleInPage = document.getElementById('pfp-circle-in-page');
        pfpCircleInPage.addEventListener('click', () => {
            window.location.href = 'account-settings.php';
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Add Article Page</title>
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
                    <p>Article Drafts</p>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Search for you articles" id='search-your-articles'>
                </div>
            </div>
            <div class="articles-boxes-container" id='articles-boxes-container'>

            </div>
            <button class='article-add-article-button' id='article-add-article-button'>+</button>
            <!-- Include Font Settings Box -->
            <?php include 'font-settings.php'; ?>
            <!-- Include Color Settings Box -->
            <?php include 'color-settings.php'; ?>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- Populate the Selection Input of all the pages -->
    <!-- Design Dropdown -->
    <script src="scripts/nav_panel_switcher.js"></script>
    <!-- event for adding new article -->
    <script>
        const addArticleBtn = document.getElementById('article-add-article-button');
        addArticleBtn.addEventListener('click', () => {
            window.location.href = 'create-new-article.php'
            createArticle();
        });
    </script>
    <!-- populate article container with articles -->
    <script src="scripts/add_article.js"></script>
</body>

</html>
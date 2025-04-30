<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Add Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cms-preview-styles.css">
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
                <button class='article-add-article-button'>Create New Article</button>
            </div>
            <div class="articles-boxes-container">
                <div class="article-box">
                    <div class="article-img-container">
                        <img src="upload-images/PPK1.jpg" alt="" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>Sample Captivating Title that will entrap you</h2>
                        <h3>Status</h3>
                    </div>
                    <button class='edit-article-button'>Edit Page</button>
                </div>
                <div class="article-box">
                    <div class="article-img-container">
                        <img src="upload-images/PPK1.jpg" alt="" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>Sample Captivating Title that will entrap you</h2>
                        <h3>Status</h3>
                    </div>
                    <button class='edit-article-button'>Edit Page</button>
                </div>
                <div class="article-box">
                    <div class="article-img-container">
                        <img src="upload-images/PPK1.jpg" alt="" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>Sample Captivating Title that will entrap you</h2>
                        <h3>Status</h3>
                    </div>
                    <button class='edit-article-button'>Edit Page</button>
                </div>
                <div class="article-box">
                    <div class="article-img-container">
                        <img src="upload-images/PPK1.jpg" alt="" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>Sample Captivating Title that will entrap you</h2>
                        <h3>Status</h3>
                    </div>
                    <button class='edit-article-button'>Edit Page</button>
                </div>
            </div>
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
</body>

</html>
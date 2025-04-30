    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Content Management System</title>
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
            <?php include 'editor-website-editor-nav.php' ?>
            <div class="main-page" id='main-page'>
                <!-- CHOOSE AND EDIT DETAILS CONTAINER -->
                <div class="edit-page-details">
                    <!-- CHOOSE PAGE CONTAINER -->
                    <div class="choose-page-container">
                        <!-- CHOOSE PAGE BOX -->
                        <select name="" id="select-pages" title="select-page"></select>
                        <!-- ADD PAGE BTN -->
                        <button id="add-article-page-btn">Add Article</button>
                        <!-- <button id="add-element-btn">Add Element</button> -->
                    </div>
                    <!-- EDIT PAGE DETAILS CONTAINERS -->
                    <div id="edit-details-box" class="page-details-container">
                        <h2>Current Articles</h2>
                    </div>
                    <!-- Include Font Settings Box -->
                    <?php include 'font-settings.php'; ?>
                    <!-- Include Color Settings Box -->
                    <?php include 'color-settings.php'; ?>
                </div>
            </div>
            <!-- This is where the Preview Site will show -->
            <div id='preview-site-box' class='preview-site'></div>
        </div>
        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>
        <!-- Populate the Selection Input of all the pages -->
        <script src="scripts/populate_selection_page.js"></script>
        <!-- When Selection Input changes pages -->
        <script src="scripts/build_preview_site.js"></script>
        <!-- When Delete Button for each section is clicked -->
        <script src="scripts/delete_btn.js"></script>
        <!-- Builds The Edit Details based on page -->
        <script src="scripts/build_edit_details.js"></script>
        <!-- Events to execute when something changed on edit details -->
        <script src="scripts/when_input_details_change.js"></script>
        <!-- Upload Image function -->
        <script src="scripts/upload_image.js"></script>
        <!-- Add Article Page with Floating Container Function -->
        <!-- <script src="scripts/add_article_page_with_container.js"></script> -->
        <!-- Add Article Button, adds it to edit details and live preview -->
        <script src="scripts/add_article.js"></script>
        <!-- Builder Function -->
        <script src="scripts/add_article_builder_function.js"></script>
        <!-- Design Dropdown -->
        <script src="scripts/nav_panel_switcher.js"></script>
    </body>

    </html>
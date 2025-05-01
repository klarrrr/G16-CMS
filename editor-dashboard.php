    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contento : Dashboard Page</title>
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
            <section class="dashboard-main-page" id='dashboard-main-page'>
                <div class="dashboard-welcome-title">
                    <h1>User P. Name</h1>
                    <p>Article Writer</p>
                </div>
                <div class="dashboard-quick-action-buttons">
                    <!-- Shortcut for all the main buttons of all pages -->
                    <h2>Quick Action Buttons</h2>
                    <div class="quick-button-container">
                        <button>Create Article</button>
                        <button>Audit Log</button>
                        <button>Account Settings</button>
                    </div>
                </div>
                <div class="dashboard-recent-articles">
                    <!-- Recenter Articles posted by the user -->
                    <h2>Recent Posts</h2>
                </div>
                <div class="dashboard-draft-articles">
                    <!-- All the unposted/unfinished articles of the user -->
                    <h2>Recent Drafts</h2>
                </div>
            </section>
            <!-- Script for Menu Button on Top Left -->
            <script src="scripts/menu_button.js"></script>
            <!-- Populate the Selection Input of all the pages -->
            <script src="scripts/nav_panel_switcher.js"></script>
    </body>

    </html>
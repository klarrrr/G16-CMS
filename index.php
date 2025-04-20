<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="nav-container">
        <nav>
            <ul>
                <li><a href=""><img src="svg/menu-svgrepo-com.svg" alt=""></a></li>
                <li>
                    <h1>contento</h1>
                </li>
                <li><a href=""><img src="svg/circle-user-svgrepo-com.svg" alt=""></a></li>
            </ul>
        </nav>
    </div>
    <!-- USER WEBSITE NAV -->
    <div class="second-nav-container">
        <nav>
            <ul>
                <li><a href="">Pages</a></li>
                <li><a href="">Design</a></li>
                <li><a href="">Settings</a></li>
                <li><a href="">Domain</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-page">
        <!-- CHOOSE AND EDIT DETAILS CONTAINER -->
        <div class="edit-page-details">
            <!-- CHOOSE PAGE CONTAINER -->
            <div class="choose-page-container">
                <!-- CHOOSE PAGE BOX -->
                <select name="" id="select-pages" title="select-page">
                </select>
                <!-- ADD PAGE BTN -->
                <button id="add-page-btn">Add Page</button>
            </div>
            <!-- EDIT PAGE DETAILS CONTAINERS -->
            <div id="edit-details-box" class="page-details-container">
                <h2>Edit Page Details</h2>
            </div>
        </div>
        <div class="preview-site" id="preview-site-box">
            <!-- PREVIEW SITE HERE -->
        </div>
    </div>
    <!-- Populate the Selection Input of all the pages -->
    <script src="scripts/populate_selection_page.js"></script>
    <!-- When Selection Input changes pages -->
    <script src="scripts/build_preview_site.js"></script>
    <!-- Builds The Edit Details based on page -->
    <script src="scripts/build_edit_details.js"></script>
    <!-- Events to execute when something changed on edit details -->
    <script src="scripts/when_input_details_change.js"></script>
</body>

</html>
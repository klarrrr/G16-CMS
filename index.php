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
        <div class="edit-page-details">
            <div class="choose-page-container">
                <select name="" id="select-pages">
                </select>
                <button id="add-page-btn">Add Page</button>
            </div>
            <div class="page-details-container"></div>
        </div>
        <div class="preview-site">
            <iframe src="example.php" frameborder="0"></iframe>
        </div>
    </div>
    <!-- Populate the Selection Input of all the pages -->
    <script src="scripts/populate_selection_page.js"></script>
    <!-- When Selection Input changes pages -->
    <script src="scripts/on_select_page_change.js"></script>
</body>

</html>
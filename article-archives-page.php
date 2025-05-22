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
    <title>Contento : Article Archives Page</title>
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
                    <h1>Article Archives</h1>
                    <p>Old Articles</p>
                </div>
                <div class="search-container">
                    <select id="sort-archived-dropdown" class="sort-dropdown">
                        <option value="desc" selected>Date Posted Descending</option>
                        <option value="asc">Date Posted Ascending</option>
                    </select>
                    <input type="text" placeholder="Search for you articles" id='search-your-archived-articles' class='search-your-articles'>
                    <div class="pfp-container" title="Account Settings">
                        <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" alt="" id='pfp-circle'>
                    </div>
                </div>
            </div>
            <div class="archives-boxes-container" id='archives-boxes-container'>

            </div>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- \Go to account settings -->
    <script>
        const pfpCircle = document.getElementById('pfp-circle');
        pfpCircle.addEventListener('click', () => {
            window.location.href = 'account-settings.php';
        });
    </script>

    <!-- Grab archived articles -->
    <script>
        const user_id = '<?php echo $user_id ?>';
    </script>
    <script src="scripts/fetch-archived-articles.js"></script>

</body>

</html>
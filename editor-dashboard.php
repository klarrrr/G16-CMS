<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

include 'php-backend/connect.php';

$user_id = $_SESSION['user_id'];
$fname = $_SESSION['user_first'];
$lname = $_SESSION['user_last'];
$email = $_SESSION['user_email'];
$profile_pic = $_SESSION['profile_picture'];
$cover_photo = $_SESSION['cover_photo'];


$articles = [];
$query = "SELECT * FROM articles LIMIT 5";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Dashboard Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container" id='dashboard-right-container'>
        <div class="cover-photo-container">
            <!-- Cover Photo IMG -->
            <div class="cover-photo">
                <img src="<?php echo (!$cover_photo) ? 'pics/plp-outside.jpg' : 'data:image/png;base64,' . $cover_photo; ?>" alt="" id="account-cover-photo">

                <!-- Profile Picture -->
                <div class="profile-info">

                    <!-- Person -->
                    <div class="person-container">
                        <!-- Picture -->
                        <div class="profile-pic-dashboard">
                            <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" id="output" width="200" />
                        </div>

                        <!-- Personal Infos -->
                        <div class="perso-info">
                            <h5><?php echo $_SESSION['user_first'] . ' ' . $_SESSION['user_last'] ?></h5>
                            <p class="bio"><?php echo 'Article ' . $_SESSION['user_type']; ?></p>
                        </div>
                    </div>

                    <!-- Quick Action Buttons -->
                    <div class="dashboard-quick-action-buttons">
                        <!-- Shortcut for all the main buttons of all pages -->

                        <button>Create Article</button>
                        <button>Audit Log</button>
                        <button>Account Settings</button>

                    </div>

                </div>

            </div>
        </div>

        <section class="dashboard-main-page" id='dashboard-main-page'>
            <div class="dashboard-recent-articles">
                <!-- Recenter Articles posted by the user -->
                <h2>Recent Posts</h2>

                <div class="recent-post-container" id='recent-post-container'>
                    <!-- Populate here -->
                </div>

            </div>
            <div class="dashboard-draft-articles">
                <!-- All the unposted/unfinished articles of the user -->
                <h2>Recent Drafts</h2>

                <div class="recent-drafts-container" id='recent-drafts-container'>
                    <!-- Populate her -->

                </div>
            </div>
        </section>

        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>

        <!-- Populate the Selection Input of all the pages -->
        <script src="scripts/nav_panel_switcher.js"></script>

        <!-- Populate recent posts -->
        <script src='scripts/dashboard-get-recent-posted-articles.js'></script>

        <!-- Populate recent drafts -->
        <script src='scripts/dashboard-get-recent-draft-articles.js'></script>

</body>

</html>
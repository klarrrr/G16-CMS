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

$user_type = null;

$query = "SELECT user_type FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $user_type = $row['user_type'];
}

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
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <!-- echo (!$cover_photo) ? 'pics/plp-outside.jpg' : 'data:image/png;base64,' . $cover_photo;  -->
    <div class="right-editor-container" id='dashboard-right-container' style="background-image: url('pics/plp-outside.jpg');">
        <!-- To Blur Background -->
        <div class='dashboard-bg-filter'></div>

        <!-- Profile Picture -->
        <div class="profile-info">

            <!-- Person -->
            <div class="person-container">
                <!-- Picture -->
                <div class="profile-pic-dashboard">
                    <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : $profile_pic; ?>" id="output" width="200" />
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

                <!-- Create Article Button -->
                <button id='shortcut-create-article'><svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.29289 3.70711L1 11V15H5L12.2929 7.70711L8.29289 3.70711Z" fill="#f4f4f4" />
                        <path d="M9.70711 2.29289L13.7071 6.29289L15.1716 4.82843C15.702 4.29799 16 3.57857 16 2.82843C16 1.26633 14.7337 0 13.1716 0C12.4214 0 11.702 0.297995 11.1716 0.828428L9.70711 2.29289Z" fill="#f4f4f4" />
                    </svg>Create Article</button>

                <!-- Review Article Button -->
                <button id='shortcut-review-article'>
                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 1H4V11H8L10 13L12 11H16V1Z" fill="#f4f4f4" />
                        <path d="M2 5V13H7.17157L8.70711 14.5355L7.29289 15.9497L6.34315 15H0V5H2Z" fill="#f4f4f4" />
                    </svg>Review Article</button>

                <!-- Audit Log Button -->
                <button id='shortcut-audit-log'><svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 2H0V5H16V2Z" fill="#f4f4f4" />
                        <path d="M1 7H5V9H11V7H15V15H1V7Z" fill="#f4f4f4" />
                    </svg>Audit Log</button>

                <!-- Account Settings button -->
                <button id='shortcut-account-settings'><svg fill="#f4f4f4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.6,3.32a3.86,3.86,0,1,0,3.86,3.85A3.85,3.85,0,0,0,9.6,3.32M16.35,11a.26.26,0,0,0-.25.21l-.18,1.27a4.63,4.63,0,0,0-.82.45l-1.2-.48a.3.3,0,0,0-.3.13l-1,1.66a.24.24,0,0,0,.06.31l1,.79a3.94,3.94,0,0,0,0,1l-1,.79a.23.23,0,0,0-.06.3l1,1.67c.06.13.19.13.3.13l1.2-.49a3.85,3.85,0,0,0,.82.46l.18,1.27a.24.24,0,0,0,.25.2h1.93a.24.24,0,0,0,.23-.2l.18-1.27a5,5,0,0,0,.81-.46l1.19.49c.12,0,.25,0,.32-.13l1-1.67a.23.23,0,0,0-.06-.3l-1-.79a4,4,0,0,0,0-.49,2.67,2.67,0,0,0,0-.48l1-.79a.25.25,0,0,0,.06-.31l-1-1.66c-.06-.13-.19-.13-.31-.13L19.5,13a4.07,4.07,0,0,0-.82-.45l-.18-1.27a.23.23,0,0,0-.22-.21H16.46M9.71,13C5.45,13,2,14.7,2,16.83v1.92h9.33a6.65,6.65,0,0,1,0-5.69A13.56,13.56,0,0,0,9.71,13m7.6,1.43a1.45,1.45,0,1,1,0,2.89,1.45,1.45,0,0,1,0-2.89Z" />
                    </svg>Account Settings</button>

            </div>

        </div>

        <div class="dashboard-main-page" id='dashboard-main-page'>
            <div class="dashboard-recent-articles">
                <!-- Recenter Articles posted by the user -->
                <h2 style='color:#f4f4f4;'>
                    <?php echo ($user_type == 'Reviewer') ? 'Pending Published Articles' : 'Recent Posts'; ?>
                </h2>


                <div class="recent-post-container" id='recent-post-container'>
                    <!-- Populate here -->
                </div>

            </div>
            <div class="dashboard-draft-articles">
                <!-- All the unposted/unfinished articles of the user -->
                <h2 style='color:#f4f4f4;'>
                    <?php echo ($user_type == 'Reviewer') ? 'Pending Draft Articles' : 'Recent Drafts'; ?>
                </h2>


                <div class="recent-drafts-container" id='recent-drafts-container'>
                    <!-- Populate her -->
                </div>
            </div>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>

    <!-- Date Formatter -->
    <script src="scripts/date-formatter.js"></script>

    <!-- Assign user id to js var -->
    <script>
        const userId = '<?php echo $user_id ?>';
    </script>

    <!-- Shortcut Create butons -->
    <script src="scripts/shorcut-create-buttons.js"></script>

    <!-- Populate recent posts -->
    <script src='scripts/dashboard-get-recent-posted-articles.js'></script>

    <!-- Populate recent drafts -->
    <script src='scripts/dashboard-get-recent-draft-articles.js'></script>

    <!-- Remove Create Article is Reviewer -->
    <script>
        const dashboardUserType = '<?php echo $user_type; ?>';

        if (dashboardUserType == 'Reviewer') {
            addArticleBtn.remove();
        } else {
            reviewArticle.remove();
        }
    </script>



</body>

</html>
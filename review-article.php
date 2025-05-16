<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
if (strtolower($_SESSION['user_type']) != 'reviewer') {
    header('Location: editor-dashboard.php');
    exit;
}

include 'php-backend/connect.php';

$article_id = $_GET['article_id'];
$user_id = $_SESSION['user_id'];
$profile_pic = $_SESSION['profile_picture'];

$query = "SELECT * FROM articles WHERE article_id = $article_id";
$result = mysqli_query($conn, $query);
$articles = [];
if ($row = mysqli_fetch_assoc($result)) {
    $articles = $row;
}

$query = "SELECT * FROM widgets WHERE article_owner = $article_id";
$result = mysqli_query($conn, $query);
$widgets = [];
if ($row = mysqli_fetch_assoc($result)) {
    $widgets = $row;
}

$articleContent = $articles['article_content'];
$title = $articles['article_title'];
$shortDesc = $widgets['widget_paragraph'];
$thumbnailImg = $widgets['widget_img'];
$dateUpdated = $articles['date_updated'];
$userOwner = $articles['user_owner'];

$userInfo = [];
$query = "SELECT * FROM users WHERE user_id = $userOwner";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $userInfo = $row;
}

$ownerUserId = $userInfo['user_id'];
$ownerFName = $userInfo['user_first_name'];
$ownerLName = $userInfo['user_last_name'];
$ownerEmail = $userInfo['user_email'];
$ownerPicture = $userInfo['profile_picture'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Edit Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link href="quill.css" rel="stylesheet" />
    <!-- Online Quill Library -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script> -->
    <script src="scripts/quill.js"></script>
</head>

<body class="body">
    <div class="sure-delete-container" style="display: none;" id='sure-delete-container'>
        <div class="sure-delete">
            <h3>Approve and Post this article?</h3>
            <!-- Selected Date will be here -->
            <!-- TODO: Make this dynamic -->
            <p>Confirming this will post the article on, <strong>May 13, 2025</strong></p>
            <div class="delete-button-container">
                <button id='del-yes-btn'>Confirm</button>
                <button id='del-no-btn'>Cancel</button>
            </div>
        </div>
    </div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="review-article-right-editor-container">
        <div class="review-article-right-nav-container">
            <div class="create-nav-one-title">
                <h2 id='top-article-title'><?php echo $title; ?></h2>
                <p id='last-updated-for-review'></p>
            </div>
            <div class="right-side-review-nav">
                <input type="date" id='schedule-choose-date'>
                <button id='approve-btn'>Approve this Post</button>
                <button id='add-comment'>Add a Comment</button>
                <!-- Keep this at the bottom here -->
                <div class="pfp-container">
                    <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" alt="" id='pfp-circle'>
                </div>
            </div>
        </div>
        <div class=" review-article-content-and-comments-container">
            <div class="review-article-content-container">
                <div class='detail-box'>
                    <!-- Left Details Box -->
                    <div class="left-detail-box">
                        <div class="widget-article-title">
                            <h3 class='widget-article-h3'>Title</h3>
                            <p class='review-article-p-title'><?php echo $title; ?></p>
                        </div>

                        <div class="widget-article-pargraph">
                            <h3 class='widget-article-h3'>Short Description</h3>
                            <p class="review-article-p-short-desc"><?php echo $shortDesc; ?></p>
                        </div>
                    </div>

                    <!-- Right Details Box -->
                    <div class="right-detail-box">
                        <!-- Thumbnail -->
                        <div class="widget-article-image">
                            <h3 class='widget-article-h3'>Thumbnail Image</h3>

                            <div class="thumbnail-image-container" style='background: url(<?php echo 'data:image/png;base64,' . $thumbnailImg ?>);'>
                                <img src="<?php echo 'data:image/png;base64,' . $thumbnailImg ?>" alt="" id='show-thumbnail-image'>
                            </div>
                        </div>
                        <div class="tags-del-container">
                            <!-- Tags -->
                            <div class="widget-article-tags">
                                <h3 class='widget-article-h3'>Tags</h3>
                                <div class="tags-container">
                                    <div class='added-tag'>
                                        <span class='tag-name'>anime</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>news</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>sample tags</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>pogi ni cj</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>ntr</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>gorilla</span>

                                    </div>
                                    <div class='added-tag'>
                                        <span class='tag-name'>futanari</span>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="article-content" class="ql-editor">
                    <?php echo html_entity_decode($articleContent); ?>
                </div>
            </div>
            <div class="review-article-comment-container">
                <!-- Populate this -->
                <div class="comments-container" id='comments-container'>
                    <!-- Populated here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- Populate the Selection Input of all the pages -->
    <script src="scripts/nav_panel_switcher.js"></script>
    <!-- Disable Some key events -->
    <script src="scripts/disable-key-events.js"></script>
    <!-- Date formatterr -->
    <script src='scripts/date-formatter.js'></script>
    <!-- Populate all required elements -->
    <script>
        const lastUpdated = document.getElementById('last-updated-for-review');
        const dateUpdated = `<?php echo $dateUpdated; ?>`;
        const author = `<?php echo $ownerFName . ' ' . $ownerLName ?>`

        lastUpdated.innerHTML = `Last updated on ${formatDateTime(dateUpdated)} - ${author}`;
    </script>

    <script>
        const approveBtn = document.getElementById('approve-btn');
        const approveBox = document.getElementById('sure-delete-container');
        const approveConfirm = document.getElementById('del-yes-btn');
        const approveCancel = document.getElementById('del-no-btn');

        approveBtn.addEventListener('click', () => {
            approveBox.style.display = 'flex';
        });

        approveConfirm.addEventListener('click', () => {
            $.ajax({
                url: '',
                type: 'POST',
                dataType: 'json',
                data: {
                    article_id: article_id
                },
                sucess: (res) => {
                    // Go back to article page
                    console.log(res.status);
                },
                error: (error) => {
                    console.log(error);
                }
            });
            approveBox.style.display = 'none';
        });

        approveCancel.addEventListener('click', () => {
            approveBox.style.display = 'none';
        });
    </script>
    <script>
        const pfpCircle = document.getElementById('pfp-circle');
        pfpCircle.addEventListener('click', () => {
            window.location.href = 'account-settings.php';
        });
    </script>
    <script>
        const article_id = `<?php echo $article_id ?>`;
    </script>
    <!-- Populate the comments -->
    <script src="scripts/get-comments.js"></script>
    <!-- Input Date Box -->
    <script>
        const inputDate = document.getElementById('schedule-choose-date');

        // if date == null
        // Defaultly sets the date to now
        inputDate.valueAsDate = new Date();
        // else
        // Get the set date

        inputDate.addEventListener()
    </script>
</body>

</html>
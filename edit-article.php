<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
if (strtolower($_SESSION['user_type']) != 'writer') {
    header('Location: editor-dashboard.php');
    exit;
}

include 'php-backend/connect.php';

$article_id = $_GET['article_id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM articles WHERE user_owner = $user_id AND article_id = $article_id";
$result = mysqli_query($conn, $query);
$articles = [];
if ($row = mysqli_fetch_assoc($result)) {
    $articles = $row;
}

$query = "SELECT * FROM widgets WHERE user_owner = $user_id AND article_owner = $article_id";
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
$archiveStatus = $articles['archive_status'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Edit Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Online Quill Css -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <!-- Offline Quill css -->
    <!-- <link href="quill.css" rel="stylesheet" /> -->
    <!-- Online Quill JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <!-- Offline Quill JS -->
    <!-- <script src="scripts/quill.js"></script> -->
</head>

<body class="body">


    <div class="sure-delete-container" style="display: none;" id="sure-delete-container">
        <div class="sure-delete">
            <h3 id="confirm-message">Archive this article?</h3>
            <div class="delete-button-container">
                <button id="del-yes-btn">Confirm</button>
                <button id="del-no-btn">Cancel</button>
            </div>
        </div>
    </div>

    <input type="file" id="local-video-upload" accept="video/*" style="display: none;">


    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="create-article-right-editor-container">
        <div class="create-article-main" id='create-article-main' style='    grid-template-columns: 75% 25%;'>
            <div class="create-navs">
                <div class="create-nav-one">
                    <div class="create-nav-one-title">
                        <h2 id='top-article-title'>Article Document Title</h2>
                        <p id='last-updated'></p>
                        <div id="article-status">
                            <p class='widget-article-h3'>Article Status: <span id="status-text"></span></p>
                        </div>
                    </div>
                    <div class="nav-one-buttons">
                        <button id="post-article" title="Upload for approval">Post Article</button>
                        <span id="open-widget">》 Hide Comment Box</span>
                    </div>
                </div>
                <div class="" id='create-nav-two'>

                    <!-- Font Tools Container -->

                    <div class="size-manip">
                        <!-- Header -->
                        <select class="ql-header" title="Styles">
                            <option value="1" title="Heading 1">H1</option>
                            <option value="2" title="Heading 2">H2</option>
                            <option value="3" title="Heading 3">H3</option>
                            <option value="4" title="Heading 4">H4</option>
                            <option value="5" title="Heading 5">H5</option>
                            <option value="6" title="Heading 6">H6</option>
                            <option value="false" title="Normal text">Normal</option>
                        </select>

                        <!-- font size -->
                        <select class="ql-size" title="Font Size">
                            <option value="small">Small</option>
                            <option selected></option> <!-- Default size -->
                            <option value="large">Large</option>
                            <option value="huge">Huge</option>
                        </select>
                    </div>

                    <div class="separator"></div>

                    <!-- Font Style -->
                    <div class="font-style">
                        <button class="ql-bold" title="Bold (Ctrl + B)">B</button>
                        <button class="ql-italic" title="Italic (Ctrl + I)">I</button>
                        <button class="ql-underline" title="Underline (Ctrl + U)">U</button>
                        <button class="ql-strike" title="Strikethrough">B</button>

                        <!-- Text Color BG COlor -->
                        <select class="ql-color" title="Text color">
                            <option value="black" title="Black">Black</option>
                            <option value="red" title="Red">Red</option>
                            <option value="blue" title="Blue">Blue</option>
                            <option value="green" title="Green">Green</option>
                            <!-- Add more color options -->
                        </select>

                        <!-- Background of text -->
                        <select class="ql-background" title="Highlight color">
                            <option value="default" title="No color">No Color</option>
                            <option value="yellow" title="Yellow">Yellow</option>
                            <option value="pink" title="Pink">Pink</option>
                            <option value="gray" title="Gray">Gray</option>
                            <!-- Add more background options -->
                        </select>

                        <!-- Font Script -->
                        <button class="ql-script" value="sub" title="Subscript"></button>
                        <button class="ql-script" value="super" title="Superscript"></button>
                    </div>


                    <div class="separator"></div>

                    <!-- Lists -->
                    <div class="lists-container">
                        <button class="ql-list" value="ordered" title="Numbered list">OL</button>
                        <button class="ql-list" value="bullet" title="Bulleted list">UL</button>
                        <button class="ql-list" value="check" title="Checklist">Checklist</button>
                    </div>

                    <div class="separator"></div>

                    <!-- Indent -->
                    <div class="indents-container">
                        <button class="ql-indent" value="-1" title="Decrease indent">Outdent</button>
                        <button class="ql-indent" value="+1" title="Increase indent">Indent</button>
                    </div>

                    <div class="separator"></div>

                    <div class="align-container">
                        <!-- Text Alignment -->
                        <select class="ql-align" title="Align"></select>
                    </div>

                    <div class="separator"></div>

                    <div class="media-container">
                        <!-- Links -->
                        <button class="ql-link" title="Insert link (Ctrl + K)">Link</button>

                        <!-- Images -->
                        <button class="ql-image" title="Insert pictures">Image</button>

                        <!-- Link Video -->
                        <button class="ql-video" title="Insert online videos">Video</button>

                        <!-- Local Video -->
                        <button id="custom-video-button" title="Upload videos from local files">
                            <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#444" d="m768 576 192-64v320l-192-64v96a32 32 0 0 1-32 32H96a32 32 0 0 1-32-32V480a32 32 0 0 1 32-32h640a32 32 0 0 1 32 32v96zM192 768v64h384v-64H192zm192-480a160 160 0 0 1 320 0 160 160 0 0 1-320 0zm64 0a96 96 0 1 0 192.064-.064A96 96 0 0 0 448 288zm-320 32a128 128 0 1 1 256.064.064A128 128 0 0 1 128 320zm64 0a64 64 0 1 0 128 0 64 64 0 0 0-128 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="separator"></div>

                    <!-- Blockquote and code block -->
                    <button class="ql-blockquote" title="Mark as quotation">Quote</button>
                    <button class="ql-code-block" title="Mark as code">Code</button>

                    <div class="separator"></div>

                    <!-- formula -->
                    <button class="ql-formula" title="Formula">Formula</button>

                    <div class="separator"></div>

                    <!-- Clearn Format -->
                    <button class="ql-clean" title="Clear all formatting">Clear</button>

                    <div class="separator"></div>
                </div>

            </div>

            <div class="create-canvas" id='create-canvas'>
                <div class='detail-box'>
                    <!-- Left Details Box -->
                    <div class="left-detail-box">
                        <div class="widget-article-title">
                            <h3 class='widget-article-h3'>Title <span class='required'>*</span></h3>
                            <input type="text" placeholder="Short title here" id='title-box'>
                        </div>

                        <div class="widget-article-pargraph">
                            <h3 class='widget-article-h3'>Short Description <span class='required'>*</span></h3>
                            <textarea name="" id="short-desc-box" rows="10" placeholder="Short description here"></textarea>
                        </div>

                        <div class="post-on-container">
                            <label class='widget-article-h3' for="schedule-choose-date" style="color: #161616; font-weight: bolder;">Post on: <span class='required'>*</span></label>
                            <input type="datetime-local" id="schedule-choose-date" value="<?php echo $articles['date_posted'] ?? ''; ?>">

                            <label class='widget-article-h3' for="expire-choose-date" style="color: #161616; font-weight: bolder;">Archive on: <span class='required'>*</span></label>
                            <input type="datetime-local" id="expire-choose-date" value="<?php echo $articles['date_expired'] ?? ''; ?>">
                        </div>

                        <div class="article-type-container">
                            <label class="widget-article-h3" style="font-weight: bolder;" for="article-type">Article Type</label>
                            <select id="article-type">
                                <option value="regular">Regular</option>
                                <option value="announcement">Announcement</option>
                            </select>
                        </div>

                        <div class="archive-article-container">
                            <h3 class="widget-article-h3">Archive Article : <i id='archi-stat'><?php echo ucwords($archiveStatus); ?></i></h3>
                            <button class='archive-article-btn' id='archive-article-btn'>Archive Article</button>
                        </div>


                        <div class="invite-reviewer-container">
                            <h3 class='widget-article-h3'>Invite a Reviewer</h3>
                            <button id="invite-reviewer-btn">Invite Reviewer</button>
                        </div>


                    </div>

                    <!-- Right Details Box -->
                    <div class="right-detail-box">
                        <!-- Thumbnail -->
                        <div class="widget-article-image">
                            <h3 class='widget-article-h3'>Thumbnail Image</h3>

                            <span class='warning' style='display: none;' id='img-size-warning'>Image size is too large</span>

                            <div id='thumbnail-image-container' class="thumbnail-image-container" style='background: url(<?php echo 'data:image/png;base64,' . $thumbnailImg ?>);'>
                                <img src="<?php echo 'data:image/png;base64,' . $thumbnailImg ?>" alt="" id='show-thumbnail-image'>
                            </div>

                            <input type="file" id='thumbnail-image' accept="image/*">
                        </div>

                        <!-- GALLERY -->
                        <div class="gallery-container">
                            <h3 class="widget-article-h3">Gallery</h3>

                            <div id="image-gallery" class="gallery-picture-container">
                                <!-- All images will be dynamically inserted here -->
                            </div>

                            <input type="file" name="image" id="image" accept="image/*" multiple required>
                            <input type="hidden" name="article_id" value="1"> <!-- dynamically set article_id -->
                        </div>

                        <!-- TAGS -->
                        <div class="tags-del-container">
                            <!-- Tags -->
                            <div class="widget-article-tags">
                                <h3 class='widget-article-h3'>Tags</h3>
                                <div class="tags-container">
                                    <!-- Population of tags will be here -->
                                </div>
                                <div class="tags-input-container">
                                    <input type="text" placeholder="Enter tags here" id='widget-tags-input' title="Press 'Enter' after putting tag">
                                    <button id="save-tags-button">Save Tags</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="editor">

                </div>
            </div>

            <!-- Details Toolbox -->
            <div class="widget-toolbar" id='edit-article-comments-container'>

            </div>
        </div>
    </div>

    <!-- Invite Popup (hidden by default) -->
    <div class="invite-popup" id="invite-popup" style="display: none;">
        <div class="invite-popup-content">
            <span class="close-popup">&times;</span>
            <h3>Select a Reviewer</h3>
            <div class="reviewers-list" id="reviewers-list">
                <!-- Reviewers will be populated here -->
            </div>
            <button id="submit-invite">Send Invitation</button>
        </div>
    </div>

    <!-- Date formatterr -->
    <script src='scripts/date-formatter.js'></script>

    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>

    <!-- Create custom video for quill -->
    <script src='scripts/edit-create-custom-video-quill.js'></script>

    <!-- All About QUILL Library Initialization, Custom Video and Etc -->
    <script src='scripts/edit-quill-ini.js'></script>

    <!-- Update Date Updated -->
    <script>
        // Initialize all required
        const article_id = `<?php echo $article_id ?>`;
        const topTitle = document.getElementById('top-article-title');
        const lastUpdated = document.getElementById('last-updated');
        const titleBox = document.getElementById('title-box');
        const shortDescBox = document.getElementById('short-desc-box');
        const contentBox = document.querySelector('.ql-editor');
        // Thumnail image
        // Tags

        topTitle.innerHTML = `<?php echo $title ?>`;

        const dateUpdated = `<?php echo $dateUpdated ?>`;
        const author = `<?php echo $_SESSION['user_first'] . ' ' . $_SESSION['user_last'] ?>`

        lastUpdated.innerHTML = `Last updated on ${formatDateTime(dateUpdated)} - ${author}`;
        titleBox.value = `<?php echo html_entity_decode($title) ?>`;
        shortDescBox.value = `<?php echo html_entity_decode($shortDesc) ?>`;

        const initialContentBox = `<?php echo html_entity_decode($articleContent) ?>`;

        contentBox.innerHTML = initialContentBox;

        const archiStats = '<?php echo $archiveStatus; ?>';

        const inputDate = document.getElementById('schedule-choose-date');

        const user_owner = '<?php echo $user_id ?>';

        function updateDateUpdated(article_id, action) {
            $.ajax({
                url: 'php-backend/edit-article-date-updated.php',
                type: 'post',
                dataType: 'json',
                data: {
                    article_id: article_id,
                    action: action
                },
                success: (res) => {
                    const date_updated = res.date_updated;
                    lastUpdated.innerHTML = `Last updated on ${formatDateTime(date_updated)} - ${author}`;
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>

    <!-- Disable Some key events -->
    <script src="scripts/disable-key-events.js"></script>

    <!-- script for open and close widget -->
    <script src='scripts/edit-open-close-widget.js'></script>

    <!-- Live update content database -->
    <script src='scripts/edit-article-content-live-update.js'></script>

    <!-- Update Title -->
    <script src='scripts/edit-update-title.js'></script>

    <!-- Update Short Desc -->
    <script src='scripts/edit-update-short-desc.js'></script>
    <!-- Update Thumbnail image -->
    <script src='scripts/edit-update-thumbnail-image.js'></script>

    <!-- Get Archive Status -->
    <script src='scripts/edit-get-archive-status.js'></script>

    <!-- Archive Article -->
    <script src='scripts/edit-archive-article.js'></script>

    <!-- Populate Comments -->
    <script src="scripts/edit-get-comments-in-article.js"></script>

    <!-- Create Tags -->
    <script src='scripts/edit-create-tags.js'></script>

    <!-- Populate assigned tags -->
    <script src='scripts/edit-populate-assigned-tags.js'></script>

    <!-- Insert/Update Picture Gallery in DB -->
    <script src="scripts/edit-update-gallery-in-db.js"></script>

    <script src="scripts/edit-update-gallery-list.js"></script>
    <!-- Call one time on load -->
    <script>
        updateGalleryList(article_id);
    </script>

    <script src='scripts/edit-delete-image-gallery.js'></script>

    <!-- Submit dates set -->

    <script src='scripts/edit-submit-dates-set.js'></script>

    <!-- Get Article Type -->
    <script src='scripts/edit-get-article-type.js'></script>

    <!-- Switch Article Type -->
    <script src='scripts/edit-switch-article-type.js'></script>
</body>

</html>
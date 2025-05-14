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
            <h3>Delete this article?</h3>
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
    <div class="create-article-right-editor-container">
        <div class="create-article-main" id='create-article-main' style='    grid-template-columns: 80% 20%;'>
            <div class="create-navs">
                <div class="create-nav-one">
                    <!-- TODO MAKE DYNAMIC LATER -->
                    <div class="create-nav-one-title">
                        <h2 id='top-article-title'>Article Document Title</h2>
                        <p id='last-updated'></p>
                    </div>
                    <div class="nav-one-buttons">
                        <span id='open-widget'>》 Hide Details Box</span>
                    </div>
                </div>
                <div class="" id='create-nav-two'>

                    <!-- Font Tools Container -->

                    <div class="size-manip">
                        <!-- Header -->
                        <select class="ql-header">
                            <option value="1">H1</option>
                            <option value="2">H2</option>
                            <option value="3">H3</option>
                            <option value="4">H4</option>
                            <option value="5">H5</option>
                            <option value="6">H6</option>
                            <option value="false">Normal</option>
                        </select>

                        <!-- font size -->
                        <select class="ql-size">
                            <option value="small">Small</option>
                            <option selected></option> <!-- Default size -->
                            <option value="large">Large</option>
                            <option value="huge">Huge</option>
                        </select>
                    </div>

                    <div class="separator"></div>

                    <!-- Font Style -->
                    <div class="font-style">
                        <button class="ql-bold">B</button>
                        <button class="ql-italic">I</button>
                        <button class="ql-underline">U</button>
                        <button class="ql-strike">B</button>

                        <!-- Text Color BG COlor -->
                        <select class="ql-color">
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <!-- Add more color options -->
                        </select>

                        <!-- Background of text -->
                        <select class="ql-background">
                            <option value="yellow">Yellow</option>
                            <option value="pink">Pink</option>
                            <option value="gray">Gray</option>
                            <!-- Add more background options -->
                        </select>

                        <!-- Font Script -->
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                    </div>


                    <div class="separator"></div>

                    <!-- Lists -->
                    <div class="lists-container">
                        <button class="ql-list" value="ordered">OL</button>
                        <button class="ql-list" value="bullet">UL</button>
                        <button class="ql-list" value="check">Checklist</button>
                    </div>

                    <div class="separator"></div>

                    <!-- Indent -->
                    <div class="indents-container">
                        <button class="ql-indent" value="-1">Outdent</button>
                        <button class="ql-indent" value="+1">Indent</button>
                    </div>

                    <div class="separator"></div>

                    <div class="align-container">
                        <!-- Text Alignment -->
                        <select class="ql-align"></select>
                    </div>

                    <div class="separator"></div>

                    <div class="media-container">
                        <!-- Links -->
                        <button class="ql-link">Link</button>

                        <!-- Images -->
                        <button class="ql-image">Image</button>

                        <!-- Video -->
                        <button class="ql-video">Video</button>
                    </div>

                    <div class="separator"></div>

                    <!-- Blockquote and code block -->
                    <button class="ql-blockquote">Quote</button>
                    <button class="ql-code-block">Code</button>

                    <div class="separator"></div>

                    <!-- formula -->
                    <button class="ql-formula">Formula</button>

                    <div class="separator"></div>

                    <!-- Clearn Format -->
                    <button class="ql-clean">Clear</button>

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
                    </div>

                    <!-- Right Details Box -->
                    <div class="right-detail-box">
                        <div class="thumbnail-del-container">
                            <!-- Thumbnail -->
                            <div class="widget-article-image">
                                <h3 class='widget-article-h3'>Thumbnail Image</h3>
                                <span class='warning' style='display: none;' id='img-size-warning'>Image size is too large</span>
                                <img src="<?php echo 'data:image/png;base64,' . $thumbnailImg ?>" alt="" id='show-thumbnail-image'>
                                <input type="file" id='thumbnail-image'>
                            </div>

                            <!-- Delete -->
                            <div class="delete-article-container">
                                <h3 class="widget-article-h3">Delete Article</h3>
                                <button class='delete-article-btn' id='del-article-btn'>Delete Article</button>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="widget-article-tags">
                            <h3 class='widget-article-h3'>Tags</h3>
                            <span class='added-tag'><span class='tag-name'>anime</span><span class='remove-tag'>x</span></span>
                            <div class="tags-input-container">
                                <input type="text" placeholder="Enter tags here" id='widget-tags-input'>
                            </div>
                        </div>


                    </div>
                </div>
                <div id="editor">

                </div>
            </div>

            <!-- Details Toolbox -->
            <div class="widget-toolbar" id='widget-toolbar'>

            </div>
        </div>
    </div>
    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <!-- Populate the Selection Input of all the pages -->
    <script src="scripts/nav_panel_switcher.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: '#create-nav-two'
            },
            history: {
                delay: 2000,
                maxStack: 500,
                userOnly: true
            }
        });
    </script>
    <!-- Disable Some key events -->
    <script src="scripts/disable-key-events.js"></script>
    <!-- script for open and close widget -->
    <script>
        const widgetOpenBtn = document.getElementById('open-widget');
        const createArticleMain = document.getElementById('create-article-main');

        widgetOpenBtn.addEventListener('click', () => {
            if (createArticleMain.style.gridTemplateColumns == '99% 1%') {
                widgetOpenBtn.textContent = '》 Hide Comment Box'
                createArticleMain.style.gridTemplateColumns = '80% 20%';
            } else {
                widgetOpenBtn.textContent = '《 Show Comment Box'
                createArticleMain.style.gridTemplateColumns = '99% 1%';
            }

        });
    </script>
    <!-- Date formatterr -->
    <script src='scripts/date-formatter.js'></script>
    <!-- Populate all required elemnts when editing -->
    <script>
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
        shortDescBox.value = `<?php echo $shortDesc ?>`;

        contentBox.innerHTML = `<?php echo html_entity_decode($articleContent) ?>`;
    </script>
    <!-- Live update content database -->
    <script>
        const article_id = `<?php echo $article_id ?>`;

        // eto para text lang
        contentBox.addEventListener('input', function() {
            const updatedContent = contentBox.innerHTML;
            // Debounce avoid flooding the server
            if (window.updateTimeout) clearTimeout(window.updateTimeout);

            window.updateTimeout = setTimeout(() => {
                updateContentBox(updatedContent, article_id);
                // console.log(updatedContent);
            }, 500);
        });

        // Gamit observer para sa imgs
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                const updatedContent = contentBox.innerHTML;
                // Debounce avoid flooding the server
                if (window.updateTimeout) clearTimeout(window.updateTimeout);

                window.updateTimeout = setTimeout(() => {
                    updateContentBox(updatedContent, article_id);
                    // console.log(updatedContent);
                }, 500);
                // console.log('DOM mutation detected', mutation);
            });
        });

        observer.observe(contentBox, {
            childList: true, // Observe direct children
            subtree: true, // Observe descendants 
            attributes: true, // Observe attribute schanges 
        });

        // Kapag nag paste
        // contentBox.addEventListener('paste', function() {
        //     const updatedContent = contentBox.innerHTML;
        //     // Debounce avoid flooding the server
        //     if (window.updateTimeout) clearTimeout(window.updateTimeout);

        //     window.updateTimeout = setTimeout(() => {
        //         updateContentBox(updatedContent, article_id);
        //         // console.log(updatedContent);
        //     }, 500);
        // });

        function updateContentBox(content, article_id) {
            $.ajax({
                url: 'php-backend/edit-article-live-update.php',
                type: 'post',
                dataType: 'json',
                data: {
                    content: content,
                    article_id: article_id
                },
                success: (res) => {
                    console.log(res.status);
                    updateDateUpdated(article_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
    <!-- Update Title -->
    <script>
        titleBox.addEventListener('input', () => {
            // Debounce avoid flooding the server
            if (window.updateTimeout) clearTimeout(window.updateTimeout);

            window.updateTimeout = setTimeout(() => {
                updateTitle(article_id);
                // console.log(updatedContent);
            }, 500);
        });

        function updateTitle(article_id) {
            const newTitle = titleBox.value;
            $.ajax({
                url: 'php-backend/edit-article-title-update.php',
                type: 'post',
                dataType: 'json',
                data: {
                    newTitle: newTitle,
                    article_id: article_id
                },
                success: (res) => {
                    console.log(res.status);
                    topTitle.innerHTML = newTitle;
                    updateDateUpdated(article_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
    <!-- Update Short Desc -->
    <script>
        shortDescBox.addEventListener('input', () => {
            // Debounce avoid flooding the server
            if (window.updateTimeout) clearTimeout(window.updateTimeout);

            window.updateTimeout = setTimeout(() => {
                updateShortDesc(article_id);
                // console.log(updatedContent);
            }, 500);
        });

        function updateShortDesc(article_id) {
            const newShortDesc = shortDescBox.value;
            $.ajax({
                url: 'php-backend/edit-article-shortDesc-update.php',
                type: 'post',
                dataType: 'json',
                data: {
                    newShortDesc: newShortDesc,
                    article_id: article_id
                },
                success: (res) => {
                    console.log(res.status);
                    updateDateUpdated(article_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
    <!-- Update Thumbnail image -->
    <script>
        const thumbnailImg = document.getElementById('thumbnail-image');
        thumbnailImg.addEventListener('change', (event) => {
            // Debounce avoid flooding the server
            if (window.updateTimeout) clearTimeout(window.updateTimeout);

            window.updateTimeout = setTimeout(() => {
                updateThumbnailImg(article_id, event);
                // console.log(updatedContent);
            }, 500);
        });

        function updateThumbnailImg(article_id, event) {
            const warningLbl = document.getElementById('img-size-warning');
            const file = event.target.files[0]; // Get the selected file
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64String = e.target.result.split(',')[1]; // Extract Base64 string
                    if (base64String.length > 16777215) {
                        // NO MORE THAN 16777215 chars
                        console.log("Image size is too large : " + base64String.length);
                        warningLbl.style.display = 'block';
                    } else {
                        // PWEDE basta less than 16777215 chars
                        console.log("This is allowed : " + base64String.length)
                        $.ajax({
                            url: 'php-backend/edit-article-thumbnail-update.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                base64String: base64String,
                                article_id: article_id
                            },
                            success: (res) => {
                                console.log(res.status);
                                document.getElementById('show-thumbnail-image').src = 'data:image/png;base64,' + base64String;
                                updateDateUpdated(article_id);
                                warningLbl.style.display = 'none';
                            },
                            error: (error) => {
                                console.log(error);
                            }
                        });
                    }
                };
                reader.readAsDataURL(file); // Read file as Data URL
            } else {
                console.log('No file selected.');
            }
        }
    </script>
    <!-- Delete Article -->
    <script>
        const delButton = document.getElementById('del-article-btn');
        const delBox = document.getElementById('sure-delete-container');
        const delBoxYes = document.getElementById('del-yes-btn');
        const delBoxNo = document.getElementById('del-no-btn');

        delButton.addEventListener('click', () => {
            delBox.style.display = 'flex';
        });

        delBoxYes.addEventListener('click', () => {
            $.ajax({
                url: 'php-backend/edit-article-delete-article.php',
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
            window.location.href = 'add-article-page.php';
        });

        delBoxNo.addEventListener('click', () => {
            delBox.style.display = 'none';
        });
    </script>

    <!-- Update Date Updated -->
    <!-- Keep this at the bottom kasi mahal ko parin :(-->
    <script>
        function updateDateUpdated(article_id) {
            $.ajax({
                url: 'php-backend/edit-article-date-updated.php',
                type: 'post',
                dataType: 'json',
                data: {
                    article_id: article_id
                },
                success: (res) => {
                    // Kunin ung date updated, then palitan yung date updated sa baba ng title
                    const date_updated = res.date_updated;
                    lastUpdated.innerHTML = `Last updated on ${formatDateTime(date_updated)} - ${author}`;
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
</body>

</html>
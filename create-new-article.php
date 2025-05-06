<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Create Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link href="quill.css" rel="stylesheet" />
    <!-- Online Quill Library -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script> -->
    <script src="scripts/quill.js"></script>
</head>

<body class="body">
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
                        <p>Last updated on May 1, 2025 - <?php echo $_SESSION['user_first'] . ' ' . $_SESSION['user_last'] ?></p>
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
            <div class="create-canvas" id="editor">
                <!-- TODO : MAKE DYNAMIC LATER -->
            </div>

            <div class="widget-toolbar" id='widget-toolbar'>
                <div class="widget-article-title">
                    <h3 class='widget-article-h3'>Title <span class='required'>*</span></h3>
                    <input type="text" placeholder="Short title here" id='title-box'>
                </div>

                <div class="widget-article-pargraph">
                    <h3 class='widget-article-h3'>Short Description <span class='required'>*</span></h3>
                    <textarea name="" id="short-desc-box" rows="10" placeholder="Short description here"></textarea>
                </div>

                <div class="widget-article-image">
                    <h3 class="widget-article-h3">Thumbnail Image</h3>
                    <input type="file" id="thumbnailInput">
                    <div id="uploadedFile" style="margin-top: 10px;"></div>


                    <div class="widget-article-tags">
                        <h3 class='widget-article-h3'>Tags</h3>
                        <span class='added-tag'><span class='tag-name'>anime</span><span class='remove-tag'>x</span></span>
                        <div class="tags-input-container">
                            <input type="text" placeholder="Enter tags here" id='widget-tags-input'>
                        </div>
                    </div>
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
                    widgetOpenBtn.textContent = '》 Hide Detail Box'
                    createArticleMain.style.gridTemplateColumns = '80% 20%';
                } else {
                    widgetOpenBtn.textContent = '《 Show Detail Box'
                    createArticleMain.style.gridTemplateColumns = '99% 1%';
                }

            });
        </script>
        <!-- Create ARticle js -->
        <script src="scripts/create-article.js"></script>
        <!-- upload image -->
        <script src="scripts/widget_upload.js"></script>
</body>

</html>
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
        <div class="create-article-main" id='create-article-main' style='    grid-template-columns: 75% 25%;'>
            <div class="create-navs">
                <div class="create-nav-one">
                    <!-- TODO MAKE DYNAMIC LATER -->
                    <div class="create-nav-one-title">
                        <h2 id='top-article-title'>Article Document Title</h2>
                        <p id='last-updated'></p>
                    </div>
                    <div class="nav-one-buttons">
                        <input type="date" id='schedule-choose-date'>
                        <button id='post-article'>Post Article</button>
                        <span id='open-widget'>》 Hide Comment Box</span>
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

                        <div class="delete-article-container">
                            <h3 class="widget-article-h3">Delete Article</h3>
                            <button class='delete-article-btn' id='del-article-btn'>Delete Article</button>
                        </div>

                        <div class="gallery-container">
                            <h3 class="widget-article-h3">Gallery</h3>

                            <div id="image-gallery" class="gallery-picture-container">
                                <!-- All images will be dynamically inserted here -->
                            </div>

                            <input type="file" name="image" id="image" accept="image/*" multiple required>
                            <input type="hidden" name="article_id" value="1"> <!-- dynamically set article_id -->
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
                        <div class="tags-del-container">
                            <!-- Tags -->
                            <div class="widget-article-tags">
                                <h3 class='widget-article-h3'>Tags</h3>
                                <div class="tags-container">
                                    <!-- Population of tags will be here -->
                                </div>
                                <div class="tags-input-container">
                                    <input type="text" placeholder="Enter tags here" id='widget-tags-input'>
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
                createArticleMain.style.gridTemplateColumns = '75% 25%';
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
        shortDescBox.value = `<?php echo html_entity_decode($shortDesc) ?>`;

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

                                document.getElementById('thumbnail-image-container').style.background = `url(${'data:image/png;base64,' + base64String})`;

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
    <!-- Populate Comments -->
    <script src="scripts/get-comments-in-article.js"></script>
    <!-- Input Date Box -->
    <script>
        const inputDate = document.getElementById('schedule-choose-date');

        // if date == null
        // Defaultly sets the date to now
        inputDate.valueAsDate = new Date();
        // else
        // Get the set date

        // inputDate.addEventListener()
    </script>

    <!-- Create Tags -->
    <script>
        const tagsInput = document.getElementById('widget-tags-input');
        const tagsContainer = document.querySelector('.tags-container');
        let currentTags = [];

        // Add tag on Enter key
        tagsInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const tagName = tagsInput.value.trim();
                if (tagName && !currentTags.includes(tagName)) {
                    addTagElement(tagName);
                    currentTags.push(tagName);
                    tagsInput.value = '';
                }
            }
        });

        // Add tag element to the DOM
        function addTagElement(tagName) {
            const tagDiv = document.createElement('div');
            tagDiv.className = 'added-tag';
            tagDiv.innerHTML = `
                <span class='tag-name'>${tagName}</span>
                <span class='remove-tag'>x</span>
            `;
            tagsContainer.appendChild(tagDiv);

            // REMOVE TAG
            tagDiv.querySelector('.remove-tag').addEventListener('click', () => {
                tagsContainer.removeChild(tagDiv);
                currentTags = currentTags.filter(tag => tag !== tagName);
            });
        }

        // Send tags to server (call this on Save/Submit)
        function saveTags(articleId) {
            console.log(articleId);
            console.log(currentTags);

            $.ajax({
                url: 'php-backend/save-tags.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    article_id: articleId,
                    tags: currentTags
                },
                success: (res) => {
                    if (res.success) {
                        alert('Tags saved successfully!');
                    }
                },
                error: (err) => {
                    console.error(err);
                }
            });
        }

        // Save button
        document.getElementById('save-tags-button').addEventListener('click', function() {
            const articleId = <?php echo $article_id; ?>; // PHP variable to get the article ID
            saveTags(articleId);
        });
    </script>

    <!-- Populate assigned tags -->
    <script>
        // Function to load all assigned tags for an article
        function loadAssignedTags(articleId) {
            $.ajax({
                url: 'php-backend/get-assigned-tags.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    article_id: articleId
                },
                success: (res) => {
                    if (res.success && res.tags.length > 0) {
                        res.tags.forEach(tag => {
                            addTagElement(tag.tag_name);
                            currentTags.push(tag.tag_name); // Update the currentTags array
                        });
                    } else {
                        console.log('No tags assigned to this article.');
                    }
                },
                error: (err) => {
                    console.error(err);
                }
            });
        }

        loadAssignedTags(<?php echo $article_id ?>);
    </script>

    <script>
        const galleryInput = document.getElementById('image');
        const articleId = '<?php echo $article_id ?>';
        const galleryContainer = document.getElementById('image-gallery');

        galleryInput.addEventListener('change', (event) => {
            // Debounce to avoid flooding the server with requests
            if (window.updateTimeout) clearTimeout(window.updateTimeout);

            window.updateTimeout = setTimeout(() => {
                updateGallery(event, articleId);
            }, 500);
        });

        function updateGallery(event, articleId) {
            const files = event.target.files; // Get selected files
            const galleryContainer = document.getElementById('image-gallery'); // Ensure this container is defined
            const warningLbl = document.getElementById('img-size-warning');
            const user_owner = '<?php echo $user_id ?>';

            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    const formData = new FormData(); // Create a new FormData object for each file

                    const filePath = `gallery/${file.name}`; // Define the path to save the file

                    // Append the image file to FormData for upload
                    formData.append('image_files[]', file);
                    formData.append('article_id', articleId);
                    formData.append('file_path', filePath);
                    formData.append('user_owner', user_owner);

                    // Show the selected image preview in the gallery
                    const imgElement = document.createElement('img');
                    imgElement.src = URL.createObjectURL(file); // Display the file as a temporary preview
                    galleryContainer.appendChild(imgElement);

                    // Insert the file path into the database after successfully uploading
                    $.ajax({
                        url: 'php-backend/edit-article-gallery-update.php',
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: (res) => {
                            if (res.status === 'success') {
                                console.log('Image successfully uploaded and added to the gallery');
                                // Update the gallery list after insertion (optional)
                                updateGalleryList(articleId);
                            } else {
                                console.log('Error uploading image');
                            }
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    });
                });
            }
        }


        function updateGalleryList(articleId) {
            // Fetch the list of images for the specific article from the database
            $.ajax({
                url: 'php-backend/get-article-gallery.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    article_id: articleId
                },
                success: (res) => {
                    if (res.status === 'success') {
                        // Clear current gallery to prevent duplicate images
                        galleryContainer.innerHTML = '';

                        // Add new images to the gallery
                        res.data.forEach(image => {
                            // Create a container for each image (for positioning the delete button)
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('image-container');
                            imgContainer.style.position = 'relative';
                            imgContainer.style.display = 'inline-block';
                            imgContainer.style.margin = '5px';

                            // Create the image element
                            const imgElement = document.createElement('img');
                            imgElement.src = 'gallery/' + image.pic_path;
                            imgElement.alt = 'Gallery Image';
                            imgElement.setAttribute('data-pic-id', image.pic_id); // Store the pic_id in the data attribute

                            // Create the delete button
                            const deleteButton = document.createElement('button');
                            deleteButton.textContent = 'X';
                            deleteButton.classList.add('delete-btn');

                            // Append the delete button to the image container
                            imgContainer.appendChild(imgElement);
                            imgContainer.appendChild(deleteButton);

                            // Add the image container to the gallery
                            galleryContainer.appendChild(imgContainer);

                            // Bind delete function to the delete button
                            deleteButton.addEventListener('click', () => {
                                const picId = imgElement.getAttribute('data-pic-id'); // Get the pic_id from the image's data attribute
                                deleteImage(picId); // Call the deleteImage function
                            });
                        });
                    } else {
                        console.log('Error fetching gallery images');
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }



        updateGalleryList(articleId);

        // Delete imAgee
        function deleteImage(pic_id) {
            $.ajax({
                url: 'php-backend/delete-article-gallery.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    pic_id: pic_id
                },
                success: (res) => {
                    if (res.status == 'success') {
                        console.log('Image deleted successfully');
                        // Refresh the gallery after deletion
                        updateGalleryList(articleId);
                    } else {
                        console.log('Error deleting image:', res.message || res.status);
                    }
                },
                error: (error) => {
                    console.log('Error during the request:', error);
                }
            });
        }
    </script>
</body>

</html>
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

$userFName = $_SESSION['user_first'];
$userLName = $_SESSION['user_last'];

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
$approval = $articles['approve_status'];

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

$fallbackImage = 'pics/plp-outside.jpg';

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
    <div class="sure-delete-container" style="display: none;" id="sure-delete-container">
        <div class="sure-delete">
            <h3 id="modal-title">Approve this article?</h3>
            <p id="modal-message">
                Confirming this will enable the author to schedule this article a date to be posted. <strong>Are you sure?</strong>
            </p>
            <div class="delete-button-container">
                <button id="modal-confirm-btn">Confirm</button>
                <button id="modal-cancel-btn">Cancel</button>
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
                <button id='unsub-btn'>Unsubscribe</button>
                <button id='approve-btn'>Loading...</button>
                <button id='add-comment' disabled>Add a Comment</button>
                <!-- Keep this at the bottom here -->
                <div class="pfp-container" title="Account Settings">
                    <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : $profile_pic; ?>" alt="" id='pfp-circle'>
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

                        <div class="gallery-container">
                            <h3 class="widget-article-h3">Gallery</h3>

                            <div id="image-gallery" class="gallery-picture-container">
                                <!-- All images will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>

                    <!-- Right Details Box -->
                    <div class="right-detail-box">
                        <!-- Thumbnail -->
                        <div class="widget-article-image">
                            <h3 class='widget-article-h3'>Thumbnail Image</h3>

                            <div class="thumbnail-image-container" style='background: url(<?php echo $thumbnailImg ? $thumbnailImg : $fallbackImage ?>);'>
                                <img src="<?php echo $thumbnailImg ? $thumbnailImg : $fallbackImage ?>" alt="" id='show-thumbnail-image'>
                            </div>
                        </div>
                        <div class="tags-del-container">
                            <!-- Tags -->
                            <div class="widget-article-tags">
                                <h3 class='widget-article-h3'>Tags</h3>
                                <div class="tags-container">
                                    <!-- Population of tags will be here -->
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
    <!-- Disable Some key events -->
    <script src="scripts/disable-key-events.js"></script>
    <!-- Date formatterr -->
    <script src='scripts/date-formatter.js'></script>
    <!-- Populate all required elements -->
    <script>
        const lastUpdated = document.getElementById('last-updated-for-review');
        const dateUpdated = `<?php echo $dateUpdated; ?>`;
        const author = `<?php echo $ownerFName . ' ' . $ownerLName ?>`
        const user_id = `<?php echo $user_id ?>`;
        const articleId = '<?php echo $article_id ?>';

        lastUpdated.innerHTML = `Last updated on ${formatDateTime(dateUpdated)} - ${author}`;
    </script>

    <!-- Unsub Button -->
    <script>
    
    const unsubBtn = document.getElementById('unsub-btn');

    unsubBtn.addEventListener('click', ()=>{
        showModal({
            title: 'Confirm Unsubscription',
            message: 'Are you sure on <strong>unsubscribing</strong> as a reviewer of this article?',
            onConfirm: () =>{
                $.ajax({
                    url: 'php-backend/unsubscribe-article.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        article_id: article_id,
                        user_id: user_id
                    },
                    success: (res) => {
                        if (res.status === 'success') {
                            // Redirect or show success message
                            window.location.href = '../for-review-article-page.php';
                        } else {
                            // Show error message
                            alert(res.message);
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                }); 
            }
        });
    });

    </script>

    <!-- Approve Btn -->
    <script>
        const approveBtn = document.getElementById('approve-btn');
        const approveBox = document.getElementById('sure-delete-container');
        const approveConfirm = document.getElementById('approve-confirm-btn');
        const approveCancel = document.getElementById('approve-cancel-btn');

        approveBtn.addEventListener('click', () => {
            showModal({
                title: 'Approve this article?',
                message: 'Confirming this will enable the author to schedule this article a date to be posted. <strong>Are you sure?</strong>',
                onConfirm: () => {
                    $.ajax({
                        url: 'php-backend/approve-confirmation.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            article_id: article_id,
                            user_id: user_id
                        },
                        success: (res) => {
                            if (res.status != "Invalid User Type") {
                                checkReviewStatus();
                            }
                        },
                        error: (error) => {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>

    <!-- Go to account settings -->

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

    <!-- Handle Approval Status -->
   <script>
        const reviewerId = <?php echo $_SESSION['user_id']; ?>;

        // Function to check review status and update button
        function checkReviewStatus() {
            fetch(`php-backend/check-review-status.php?article_id=${articleId}&reviewer_id=${reviewerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateButton(data.decision);
                    } else {
                        console.error('Error checking review status:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        }

        // Function to update button based on decision
        function updateButton(decision) {
            if (decision === 'approved') {
                approveBtn.innerHTML = 'Remove Approval';
                approveBtn.classList.remove('btn-primary');
                approveBtn.classList.add('btn-danger');
            } else {
                approveBtn.innerHTML = 'Approve This Post';
                approveBtn.classList.remove('btn-danger');
                approveBtn.classList.add('btn-primary');
            }
            
            // Store current state for click handler
            approveBtn.dataset.currentState = decision;
        }

        // Initial check when page loads
        checkReviewStatus();

        // Add click handler for the button
        approveBtn.addEventListener('click', () => {
            const newState = approveBtn.dataset.currentState === 'approved' ? 'unapproved' : 'approved';
            
            // Call your existing approval API here
            // On success, call checkReviewStatus() again to refresh the button state
        });
    </script>

    <!-- Add Comment -->
    <script>
        const addCommPfp = '<?php echo $profile_pic; ?>';
        const firstName = '<?php echo $userFName; ?>';
        const lastName = '<?php echo $userLName; ?>';

        // Function to handle adding a comment
        document.getElementById("add-comment").addEventListener("click", () => {
            const commentsContainer = document.getElementById("comments-container");

            // Create a new comment box (editable)
            const newCommentBox = document.createElement("div");
            newCommentBox.classList.add("comment-box");
            newCommentBox.setAttribute("data-status", "new"); // Mark this comment as new

            newCommentBox.innerHTML = `
        <div class="comment-upper-part">
            <div class="pfp-container">
                <img src="${addCommPfp}" alt="">
            </div>
            <div class="author-and-date">
                <h2 class="comment-author">${firstName + ' ' + lastName}</h2>
                <p class="comment-date"></p>
            </div>
            <div class="comment-options">
                <button class="options-button" disabled style="opacity: 0.5; cursor: not-allowed;">⋮</button>
                <div class="options-dropdown hidden">
                    <button class="edit-comment">Edit</button>
                    <button class="remove-comment">Remove</button>
                </div>
            </div>
        </div>
        <div class="comment-bottom-part">
            <textarea class="comment-textarea" placeholder="Write your comment here..."></textarea>
        </div>
        <div class="comment-actions">
            <button class="cancel-comment">Cancel</button>
            <button class="save-comment">Save</button>
        </div>
    `;

            // Append new comment box to the comments container
            commentsContainer.appendChild(newCommentBox);

            // Focus the textarea after appending it to the DOM
            const textarea = newCommentBox.querySelector('.comment-textarea');
            textarea.focus();

            // Add event listeners for Save and Cancel buttons
            const saveButton = newCommentBox.querySelector(".save-comment");
            const cancelButton = newCommentBox.querySelector(".cancel-comment");

            saveButton.addEventListener("click", function() {
                const commentTextarea = newCommentBox.querySelector(".comment-textarea");
                if (!commentTextarea) return;
                const commentText = commentTextarea.value;

                if (commentText.trim() !== "") {
                    // Get the current date in the desired format
                    const currentDate = getFormattedDate();

                    // Update the comment text and date
                    newCommentBox.querySelector(".comment-bottom-part").innerHTML = `<p>${commentText}</p>`;

                    newCommentBox.querySelector(".comment-date").innerHTML = currentDate;

                    // Enable the options dropdown after saving
                    const optionsButton = newCommentBox.querySelector('.options-button');
                    if (optionsButton) {
                        optionsButton.disabled = false;
                        optionsButton.style.cursor = 'pointer';
                        optionsButton.style.opacity = 1;
                    }

                    // Mark the comment as "existing"
                    newCommentBox.setAttribute("data-status", "existing"); // Change status to existing
                    newCommentBox.setAttribute("data-originaltext", commentText); // Store original comment text for cancellation

                    saveNewComment(commentText, newCommentBox);
                }
            });

            cancelButton.addEventListener("click", function() {
                if (newCommentBox.getAttribute("data-status") === "new") {
                    // If the comment is new, remove the whole comment box
                    newCommentBox.remove();
                } else {
                    // If the comment already exists, revert to original comment text
                    revertToOriginalComment(newCommentBox);
                }
            });

            document.querySelectorAll('.comment-textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    // Reset height to auto to shrink if content is deleted
                    this.style.height = 'auto';

                    // Set the height to the scrollHeight (total height including overflow)
                    this.style.height = (this.scrollHeight) + 'px';
                });
            });
        });

        // Function to format date like "May 14, 2025 - 9:42:01 AM"
        function getFormattedDate() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            return now.toLocaleString('en-US', options);
        }

        // Function to revert to the original comment if it's not a new one
        function revertToOriginalComment(commentBox) {
            const originalCommentText = commentBox.getAttribute("data-originaltext");
            commentBox.querySelector(".comment-bottom-part").innerHTML = `<p>${originalCommentText}</p>`;
        }

        // Function to insert new comment to database
        function saveNewComment(commentText, commentBox) {
            $.ajax({
                url: 'php-backend/save-comment.php',
                type: 'get',
                dataType: 'json',
                data: {
                    commentText: commentText,
                    user_id: user_id,
                    article_id: article_id
                },
                success: (res) => {
                    if (res && res.comment_id) {
                        // Set the new comment ID as a data attribute
                        commentBox.setAttribute("data-commentid", res.comment_id);
                        const actions = commentBox.querySelector('.comment-actions');
                        if (actions) actions.remove();
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }

        // Function to revert to the original comment if it's not a new one
        function revertToOriginalComment(commentBox) {
            const originalCommentText = commentBox.getAttribute("data-originaltext");
            commentBox.querySelector(".comment-bottom-part").innerHTML = `<p>${originalCommentText}</p>`;
        }
    </script>

    <!-- Dropdown More Options -->
    <script>
        // Toggle dropdown visibility
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.options-dropdown').forEach(dropdown => {
                if (!dropdown.contains(e.target) && !dropdown.previousElementSibling.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            if (e.target.classList.contains('options-button')) {
                const dropdown = e.target.nextElementSibling;
                dropdown.classList.toggle('hidden');
            }

            // Edit Button Clicked
            if (e.target.classList.contains('edit-comment')) {
                const commentBox = e.target.closest('.comment-box');
                const commentText = commentBox.querySelector('.comment-bottom-part p').innerText;

                // Hide the dropdown
                const dropdown = e.target.closest('.options-dropdown');
                dropdown.classList.add('hidden');

                commentBox.setAttribute("data-status", "editing");
                commentBox.setAttribute("data-originaltext", commentText);

                commentBox.querySelector(".comment-bottom-part").innerHTML = `
        <textarea class="comment-textarea">${commentText}</textarea>
    `;

                const actions = document.createElement('div');
                actions.classList.add('comment-actions');
                actions.innerHTML = `
        <button class="cancel-comment">Cancel</button>
        <button class="save-comment">Save</button>
    `;
                commentBox.appendChild(actions);

                // Reapply textarea autosize logic
                const textarea = commentBox.querySelector('.comment-textarea');
                textarea.style.height = 'auto'; // reset first
                textarea.style.height = `${textarea.scrollHeight}px`; // resize to fit content
                textarea.focus();

                // Attach autosize logic for user input
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = `${this.scrollHeight}px`;
                });
            }


            // Remove Button Clicked
            if (e.target.classList.contains('remove-comment')) {
                const commentBox = e.target.closest('.comment-box');
                const commentId = commentBox.getAttribute('data-commentid');

                // Hide the dropdown
                const dropdown = e.target.closest('.options-dropdown');
                dropdown.classList.add('hidden');

                showModal({
                    title: 'Delete this comment?',
                    message: 'Are you sure you want to permanently delete this comment?',
                    onConfirm: () => {
                        $.ajax({
                            url: 'php-backend/delete-comment.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                comment_id: commentId
                            },
                            success: (res) => {
                                if (res.success) {
                                    commentBox.remove();
                                }
                            },
                            error: (error) => {
                                console.log(error);
                            }
                        });
                    }
                });
            }

            // Cancel Editing
            if (e.target.classList.contains('cancel-comment')) {
                const commentBox = e.target.closest('.comment-box');
                revertToOriginalComment(commentBox);
                commentBox.setAttribute("data-status", "existing");
                const actions = commentBox.querySelector('.comment-actions');
                if (actions) actions.remove();
            }

            // Save Edited Comment
            if (e.target.classList.contains('save-comment')) {
                const commentBox = e.target.closest('.comment-box');
                const textarea = commentBox.querySelector('.comment-textarea');
                if (!textarea) return;
                const newCommentText = textarea.value;

                const commentId = commentBox.getAttribute('data-commentid');

                $.ajax({
                    url: 'php-backend/update-comment.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        comment_id: commentId,
                        comment_text: newCommentText
                    },
                    success: (res) => {
                        if (res.success) {
                            commentBox.querySelector('.comment-bottom-part').innerHTML = `<p>${newCommentText}</p>`;
                            commentBox.setAttribute("data-originaltext", newCommentText);
                            commentBox.setAttribute("data-status", "existing");
                            const actions = commentBox.querySelector('.comment-actions');
                            if (actions) actions.remove();
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    }
                });
            }
        });
    </script>

    <!-- Dynamic modal -->
    <script>
        function showModal({
            title,
            message,
            onConfirm
        }) {
            const modal = document.getElementById('sure-delete-container');
            const modalTitle = document.getElementById('modal-title');
            const modalMessage = document.getElementById('modal-message');
            const confirmBtn = document.getElementById('modal-confirm-btn');
            const cancelBtn = document.getElementById('modal-cancel-btn');

            // Update content
            modalTitle.textContent = title;
            modalMessage.innerHTML = message;

            // Remove previous event listeners from Confirm
            const newConfirmBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

            // Add new confirm listener
            newConfirmBtn.addEventListener('click', () => {
                onConfirm();
                modal.style.display = 'none';
            });

            // Cancel button always hides the modal
            cancelBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            // Show the modal
            modal.style.display = 'flex';
        }
    </script>

    <!-- Populate Gallery -->
    <script>
        const galleryContainer = document.getElementById('image-gallery'); // Ensure this container is defined

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

                        // Create the image element
                        const imgElement = document.createElement('img');
                        imgElement.src = 'gallery/' + image.pic_path;
                        imgElement.alt = 'Gallery Image';
                        imgElement.setAttribute('data-pic-id', image.pic_id); // Store the pic_id in the data attribute

                        // Append the delete button to the image container
                        imgContainer.appendChild(imgElement);

                        // Add the image container to the gallery
                        galleryContainer.appendChild(imgContainer);
                    });
                } else {
                    console.log('Error fetching gallery images');
                }
            },
            error: (error) => {
                console.log(error);
            }
        });
    </script>

    <!-- Load Tags -->
    <script>
        const tagsContainer = document.querySelector('.tags-container');
        let currentTags = [];

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

        function addTagElement(tagName) {
            const tagDiv = document.createElement('div');
            tagDiv.className = 'added-tag';
            tagDiv.innerHTML = `
                <span class='tag-name'>${tagName}</span>
            `;
            tagsContainer.appendChild(tagDiv);
        }
    </script>
</body>

</html>
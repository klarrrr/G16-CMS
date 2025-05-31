const commentContainer = document.getElementById('comments-container');

$.ajax({
    url: 'php-backend/get-comments.php',
    type: 'post',
    dataType: 'json',
    data: {
        article_id: article_id
    },
    success: (res) => {
        const comments = res;
        const currentUserId = user_id; // Already declared in global scope
        const commentFragment = document.createDocumentFragment();

        for (let i = 0; i < comments.length; i++) {
            const commentUserId = comments[i].user_id;
            const isOwner = commentUserId == currentUserId;
            const commentId = comments[i].comment_id;
            const commentContent = comments[i].comment_content;
            const commentDate = comments[i].date_created;
            const profilePic = comments[i].profile_picture;
            const userFName = comments[i].user_first_name;
            const userLName = comments[i].user_last_name;

            const buildCommentBox = document.createElement('div');
            buildCommentBox.className = 'comment-box';

            buildCommentBox.setAttribute('data-commentid', commentId);
            buildCommentBox.setAttribute('data-status', 'existing');
            buildCommentBox.setAttribute('data-originaltext', commentContent);

            buildCommentBox.innerHTML = `
                <div class="comment-upper-part">
                    <div class="pfp-container">
                        <img src="${(!profilePic) ? 'pics/no-pic.jpg' : profilePic}" alt="">
                    </div>
                    <div class="author-and-date">
                        <h2 class='comment-author'>${userFName} ${userLName}</h2>
                        <p class='comment-date'>${formatDateTime(commentDate)}</p>
                    </div>
                    ${isOwner ? `
                        <div class="comment-options">
                            <button class="options-button">⋮</button>
                            <div class="options-dropdown hidden">
                                <button class="edit-comment">Edit</button>
                                <button class="remove-comment">Remove</button>
                            </div>
                        </div>
                    ` : ''}
                </div>
                <div class="comment-bottom-part">
                    <p>${commentContent}</p>
                </div>
            `;

            commentFragment.appendChild(buildCommentBox);
        }

        commentContainer.appendChild(commentFragment);

        // Enable add comment button after loading is done
        document.getElementById('add-comment').disabled = false;
    },
    error: (error) => {
        console.log(error);
    }
});

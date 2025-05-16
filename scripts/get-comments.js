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

        const commentFragment = document.createDocumentFragment();

        for (let i = 0; i < comments.length; i++) {
            const commentContent = comments[i].comment_content;
            const commentDate = comments[i].date_created;
            const profilePic = comments[i].profile_picture;
            const userFName = comments[i].user_first_name;
            const userLName = comments[i].user_last_name;

            const buildCommentBox = document.createElement('div');
            buildCommentBox.className = 'comment-box'

            buildCommentBox.innerHTML = `
                    <div class="comment-upper-part">
                        <div class="pfp-container">
                            <img src="data:image/png;base64, ${profilePic}" alt="">
                        </div>
                        <div class="author-and-date">
                            <h2 class='comment-author'>${userFName + ' ' + userLName}</h2>
                            <p class='comment-date'>${formatDateTime(commentDate)}</p>
                        </div>
                    </div>
                    <div class="comment-bottom-part">
                        <p>
                            ${commentContent}
                        </p>
                    </div>
                `;
            commentFragment.appendChild(buildCommentBox);
        }

        commentContainer.appendChild(commentFragment);

    },
    error: (error) => {
        console.log(error);
    }
});
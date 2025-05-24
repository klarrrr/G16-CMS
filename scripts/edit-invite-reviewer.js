document.addEventListener('DOMContentLoaded', function () {
    const inviteBtn = document.getElementById('invite-reviewer-btn');
    const popup = document.getElementById('invite-popup');
    const closeBtn = document.querySelector('.close-popup');
    const reviewersList = document.getElementById('reviewers-list');
    const submitBtn = document.getElementById('submit-invite');
    const articleId = `<? php echo $article_id; ?>`;
    const userId = `<? php echo $_SESSION['user_id']; ?>`;

    // Open popup
    inviteBtn.addEventListener('click', function () {
        fetchReviewers();
        popup.style.display = 'flex';
    });

    // Close popup
    closeBtn.addEventListener('click', function () {
        popup.style.display = 'none';
    });

    // Fetch all reviewers
    function fetchReviewers() {
        $.ajax({
            url: 'php-backend/fetch-reviewers.php',
            type: 'GET',
            success: function (response) {
                reviewersList.innerHTML = '';
                response.forEach(reviewer => {
                    const reviewerItem = document.createElement('div');
                    reviewerItem.className = 'reviewer-item';
                    reviewerItem.innerHTML = `
                        <input type="radio" name="selected_reviewer" 
                               value="${reviewer.user_id}" id="reviewer-${reviewer.user_id}">
                        <label for="reviewer-${reviewer.user_id}">
                            ${reviewer.user_first_name} ${reviewer.user_last_name}
                        </label>
                    `;
                    reviewersList.appendChild(reviewerItem);
                });
            }
        });
    }

    // Submit invitation
    submitBtn.addEventListener('click', function () {
        const selectedReviewer = document.querySelector('input[name="selected_reviewer"]:checked');

        if (!selectedReviewer) {
            alert('Please select a reviewer');
            return;
        }

        const reviewerId = selectedReviewer.value;

        $.ajax({
            url: 'php-backend/send-invitation.php',
            type: 'POST',
            data: {
                article_id: articleId,
                reviewer_id: reviewerId,
                inviter_id: userId
            },
            success: function (response) {
                alert('Invitation sent successfully!');
                popup.style.display = 'none';
            },
            error: function () {
                alert('Error sending invitation');
            }
        });
    });
});
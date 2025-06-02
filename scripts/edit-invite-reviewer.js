document.addEventListener('DOMContentLoaded', function () {
    const inviteBtn = document.getElementById('invite-reviewer-btn');
    const popup = document.getElementById('invite-popup');
    const closeBtn = document.querySelector('.close-popup');
    const reviewersList = document.getElementById('reviewers-list');
    const submitBtn = document.getElementById('submit-invite');
    const invitedReviewersContainer = document.getElementById('invited-reviewers');
    const userId = `<?php echo $_SESSION['user_id']; ?>`;

    // Open popup
    inviteBtn.addEventListener('click', function () {
        fetchReviewers();
        popup.style.display = 'flex';
    });

    // Close popup
    closeBtn.addEventListener('click', function () {
        popup.style.display = 'none';
    });

    // Close when clicking outside
    popup.addEventListener('click', function (e) {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    });

    // Load already invited reviewers
    loadInvitedReviewers();

    // Fetch available reviewers
    function fetchReviewers() {
        $.ajax({
            url: 'php-backend/fetch-reviewers.php',
            type: 'GET',
            data: { article_id: article_id },
            dataType: 'json',
            success: function (response) {
                reviewersList.innerHTML = '';

                if (response.length === 0) {
                    reviewersList.innerHTML = '<p class="no-reviewers">No available reviewers</p>';
                    return;
                }

                response.forEach(reviewer => {
                    const reviewerItem = document.createElement('div');
                    reviewerItem.className = 'reviewer-item';
                    reviewerItem.innerHTML = `
                        <input type="checkbox" name="selected_reviewers" 
                               value="${reviewer.user_id}" id="reviewer-${reviewer.user_id}">
                        <label for="reviewer-${reviewer.user_id}">
                            ${reviewer.user_first_name} ${reviewer.user_last_name}
                        </label>
                    `;
                    reviewersList.appendChild(reviewerItem);
                });
            },
            error: function (xhr) {
                let errorMsg = 'Error loading reviewers';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                reviewersList.innerHTML = `<p class="error">${errorMsg}</p>`;
            }
        });
    }

    // Load already invited reviewers
    function loadInvitedReviewers() {
        $.ajax({
            url: 'php-backend/get-invited-reviewers.php',
            type: 'GET',
            data: { article_id: article_id },
            dataType: 'json',
            success: function (response) {
                invitedReviewersContainer.innerHTML = '';

                if (response.length === 0) {
                    invitedReviewersContainer.innerHTML = '<p>No reviewers invited yet</p>';
                    return;
                }

                response.forEach(invite => {
                    const reviewerItem = document.createElement('div');
                    reviewerItem.className = 'invited-reviewer-item';
                    reviewerItem.innerHTML = `
                        <div class="reviewer-info">
                            <span>${invite.user_first_name} ${invite.user_last_name}</span>
                            <span class="status-badge ${invite.status}">${invite.status}</span>
                        </div>
                        <div class="reviewer-actions">
                            ${invite.status === 'pending' ?
                            `<button class="cancel-invite" data-invite-id="${invite.invite_id}">Cancel</button>` : ''}
                        </div>
                    `;
                    invitedReviewersContainer.appendChild(reviewerItem);
                });

                // Add event listeners to cancel buttons
                document.querySelectorAll('.cancel-invite').forEach(btn => {
                    btn.addEventListener('click', function () {
                        cancelInvitation(this.dataset.inviteId);
                    });
                });
            }
        });
    }

    // Submit invitation
    submitBtn.addEventListener('click', function () {
        const selectedReviewers = Array.from(document.querySelectorAll('input[name="selected_reviewers"]:checked'));

        if (selectedReviewers.length === 0) {
            showAlert('Please select at least one reviewer', 'error');
            return;
        }

        const reviewerIds = selectedReviewers.map(el => el.value);

        // Disable button during processing
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        // Send invitations one by one
        let successCount = 0;
        let errorCount = 0;

        reviewerIds.forEach((reviewerId, index) => {
            $.ajax({
                url: 'php-backend/send-invitation.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    article_id: article_id,
                    reviewer_id: reviewerId,
                    inviter_id: userId
                }),
                success: function () {
                    successCount++;
                },
                error: function (error) {
                    console.log(error);
                    errorCount++;
                },
                complete: function () {
                    // Last request completed
                    if (index === reviewerIds.length - 1) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Invitation';

                        if (errorCount > 0) {
                            showAlert(`${successCount} invitation(s) sent, ${errorCount} failed`,
                                errorCount === reviewerIds.length ? 'error' : 'warning');
                        } else {
                            showAlert('Invitations sent successfully!', 'success');
                        }

                        // Refresh lists
                        fetchReviewers();
                        loadInvitedReviewers();
                        popup.style.display = 'none';

                        loadStatus();
                        
                    }
                }
            });
        });
    });

    // Cancel invitation
    function cancelInvitation(inviteId) {
        if (!confirm('Are you sure you want to cancel this invitation?')) return;

        $.ajax({
            url: 'php-backend/cancel-invitation.php',
            type: 'POST',
            data: { 
                invite_id: inviteId,
                article_id: article_id
            },
            success: function () {
                loadStatus();
                showAlert('Invitation cancelled', 'success');
                loadInvitedReviewers();
            },
            error: function () {
                showAlert('Failed to cancel invitation', 'error');
            }
        });
    }

    // Helper function to show alerts
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert ${type}`;
        alert.textContent = message;
        document.body.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 3000);
    }

       // Load current status
        function loadStatus() {
            $.ajax({
                url: 'php-backend/get-article-status.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    article_id: article_id
                },
                success: function (res) {
                    console.log(res.status);
                    if (res.status === 'success') {
                        const capitalizedStatus = res.approve_status.charAt(0).toUpperCase() + res.approve_status.slice(1);
                        document.getElementById('status-text').textContent = capitalizedStatus;
                    } else {
                        postBtn.disabled = true;
                        postBtn.innerText = 'Status Error';
                        console.error(res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    postBtn.disabled = true;
                    postBtn.innerText = 'Error loading status';
                }
            });
        }

});
document.addEventListener('DOMContentLoaded', function () {
    const postBtn = document.getElementById('post-article');
    const datePostedInput = document.getElementById('schedule-choose-date');
    const dateExpiredInput = document.getElementById('expire-choose-date');

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
                if (res.status === 'success') {
                    updateButtonLabel(res.completion_status);
                    const capitalizedStatus = res.archive_status.charAt(0).toUpperCase() + res.archive_status.slice(1);
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


    // Toggle publish/unpublish
    postBtn.addEventListener('click', function () {
        const datePosted = datePostedInput.value.trim();
        const dateExpired = dateExpiredInput.value.trim();

        // Reset styling
        datePostedInput.style.border = '';
        dateExpiredInput.style.border = '';

        // Validation
        if (!datePosted || !dateExpired) {
            if (!datePosted) datePostedInput.style.border = '1px solid red';
            if (!dateExpired) dateExpiredInput.style.border = '1px solid red';
            return;
        }

        $.ajax({
            url: 'php-backend/toggle-article-status.php',
            type: 'POST',
            dataType: 'json',
            data: {
                article_id: article_id,
                date_posted: datePosted,
                date_expired: dateExpired
            },
            success: function (res) {
                if (res.status === 'success') {
                    updateButtonLabel(res.new_status);
                    updateDateUpdated(article_id, "Article gets published");
                    alert(`Article is now ${res.new_status}.`);
                    location.reload();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function (err) {
                console.error(err);
                alert('Request failed.');
            }
        });
    });

    function updateButtonLabel(status) {
        if (status === 'published') {
            postBtn.innerText = 'Unpublish Article';
        } else {
            postBtn.innerText = 'Publish Article';
        }
    }

    // Initialize
    loadStatus();
});
$.ajax({
    url: 'php-backend/get-archive-status.php',
    type: 'POST',
    dataType: 'json',
    data: {
        article_id: article_id
    },
    success: (res) => {
        if (res.status === 'success') {
            const isArchived = res.archive_status === 'archived';

            // Update visible status
            document.getElementById('archi-stat').innerText = res.archive_status;

            // Update archive button text
            const archiveBtn = document.getElementById('archive-article-btn');
            archiveBtn.innerText = isArchived ? 'Unarchive' : 'Archive';

            // Show/hide delete box if needed
            const delBox = document.getElementById('delBox');
            if (delBox) delBox.style.display = isArchived ? 'none' : 'block';

            // Update confirmation modal content
            const confirmMessage = document.getElementById('confirm-message');
            const delYesBtn = document.getElementById('del-yes-btn');

            if (confirmMessage && delYesBtn) {
                confirmMessage.innerText = isArchived ?
                    'Unarchive this article?' :
                    'Archive this article?';

                delYesBtn.innerText = isArchived ?
                    'Unarchive' :
                    'Archive';
            }
        } else {
            console.warn('Could not get archive status:', res.message);
        }
    },
    error: (err) => {
        console.error('AJAX error:', err);
    }
});
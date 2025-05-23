const archiveBtn = document.getElementById('archive-article-btn');
const archiStat = document.getElementById('archi-stat');

archiStat.innerHTML = archiStats;

const delBox = document.getElementById('sure-delete-container');
const delBoxYes = document.getElementById('del-yes-btn');
const delBoxNo = document.getElementById('del-no-btn');

archiveBtn.addEventListener('click', () => {
    delBox.style.display = 'flex';
});

// edit-article-delete-article.php

delBoxYes.addEventListener('click', () => {
    $.ajax({
        url: 'php-backend/archive-article.php',
        type: 'POST',
        dataType: 'json',
        data: {
            article_id: article_id
        },
        success: (res) => {
            if (res.status === 'success') {
                const isArchived = res.archive_status === 'archived';

                archiStat.innerText = res.archive_status;
                archiveBtn.innerText = isArchived ? 'Unarchive' : 'Archive';
                alert(res.message);

                // Hide delete box only if archived
                delBox.style.display = 'none';
                updateDateUpdated(article_id, "Article got archived");
            } else {
                alert('Failed: ' + res.message);
            }
        },
        error: (error) => {
            console.error('AJAX error:', error);
        }
    });
});

delBoxNo.addEventListener('click', () => {
    delBox.style.display = 'none';
});
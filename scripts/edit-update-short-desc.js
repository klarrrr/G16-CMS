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
            updateDateUpdated(article_id, "Article Short Description gets updated");
        },
        error: (error) => {
            console.log(error);
        }
    });
}
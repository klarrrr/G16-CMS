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
            updateDateUpdated(article_id, "Article Title gets updated");
        },
        error: (error) => {
            console.log(error);
        }
    });
}
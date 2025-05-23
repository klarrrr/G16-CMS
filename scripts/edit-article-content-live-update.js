// eto para text lang
contentBox.addEventListener('input', function () {
    const updatedContent = contentBox.innerHTML;
    // Debounce avoid flooding the server
    if (window.updateTimeout) clearTimeout(window.updateTimeout);

    window.updateTimeout = setTimeout(() => {
        updateContentBox(updatedContent, article_id);
        // console.log(updatedContent);
    }, 500);
});

// Gamit observer para sa imgs
const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
        const updatedContent = contentBox.innerHTML;
        // Debounce avoid flooding the server
        if (window.updateTimeout) clearTimeout(window.updateTimeout);

        window.updateTimeout = setTimeout(() => {
            updateContentBox(updatedContent, article_id);
            // console.log(updatedContent);
        }, 500);
        // console.log('DOM mutation detected', mutation);
    });
});

observer.observe(contentBox, {
    childList: true, // Observe direct children
    subtree: true, // Observe descendants 
    attributes: true, // Observe attribute schanges 
});

function updateContentBox(content, article_id) {
    $.ajax({
        url: 'php-backend/edit-article-live-update.php',
        type: 'post',
        dataType: 'json',
        data: {
            content: content,
            article_id: article_id
        },
        success: (res) => {
            // console.log(res.status);
            updateDateUpdated(article_id, "Article Content is Updated");
        },
        error: (error) => {
            console.log(error);
        }
    });
}

contentBox.addEventListener('paste', function (event) {
    const updatedContent = contentBox.innerHTML;

    // If want to access raw pasted text/data
    // const clipboardData = (event.clipboardData || window.clipboardData).getData('text');

    if (window.updateTimeout) clearTimeout(window.updateTimeout);

    window.updateTimeout = setTimeout(() => {
        updateContentBox(updatedContent, article_id);
        // console.log('Paste triggered update');
        updateDateUpdated(article_id, "Pasted something in content");
    }, 500);
});

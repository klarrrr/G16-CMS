const recentDraftsContainer = document.getElementById('recent-drafts-container');

// get 5 articles that are posted and sorted by recent date

$.ajax({
    url: 'php-backend/get-recent-draft-articles.php',
    type: 'get',
    dataType: 'json',
    data: {
        user_id: userId
    },
    success: (res) => {
        const articles = res.articles;
        const widgets = res.widgets;

        const fragment = document.createDocumentFragment();

        for (let i = 0; i < articles.length; i++) {
            const articleId = articles[i].article_id;
            const title = articles[i].article_title;
            const pic = widgets[i] ? widgets[i].widget_img : 'pics/plp-outside.jpg';  // Handle case when widget might be undefined

            // Create the div element for each recent article
            const recentArticleLayout = document.createElement('div');
            recentArticleLayout.classList.add('recent-box');

            // Create the image element and set attributes
            const img = document.createElement('img');
            img.src = pic ? 'data:image/png;base64,' + pic : 'pics/plp-outside.jpg';  // Check for pic existence
            img.alt = title;

            // Create the paragraph element for the title
            const p = document.createElement('p');
            p.textContent = htmlEntityDecode(title);

            // Append the image and paragraph to the recentArticleLayout
            recentArticleLayout.appendChild(img);
            recentArticleLayout.appendChild(p);
            recentArticleLayout.setAttribute('articleid', articleId);
            recentArticleLayout.addEventListener('click', (event) => {
                editArticle(event.currentTarget);
            });

            // Append the recentArticleLayout to the fragment
            fragment.appendChild(recentArticleLayout);
        }

        // Append the fragment to the container
        recentDraftsContainer.appendChild(fragment);

    },
    error: (error) => {
        console.log(error);
    }

});

function editArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    // Pass GET method the article id
    // Verify by using the user id in the session too
    // So Article id = article_id AND user_id = $_SESSION['user_id'];
    window.location.href = `../edit-article.php?article_id=${article_id}`;
}

function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}
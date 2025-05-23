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

        // Clear container first if needed
        recentDraftsContainer.innerHTML = '';

        // Fallback message
        if (articles.length === 0) {
            const emptyMsg = document.createElement('p');
            emptyMsg.textContent = "No recent draft articles found.";
            emptyMsg.style.color = '#999';
            emptyMsg.style.textAlign = 'center';
            emptyMsg.style.padding = '1rem';
            emptyMsg.style.fontStyle = 'italic';
            recentDraftsContainer.appendChild(emptyMsg);
            return; // Stop further execution
        }

        const fragment = document.createDocumentFragment();

        for (let i = 0; i < articles.length; i++) {
            const articleId = articles[i].article_id;
            const title = articles[i].article_title;
            const pic = widgets[i] ? widgets[i].widget_img : 'pics/plp-outside.jpg';

            const recentArticleLayout = document.createElement('div');
            recentArticleLayout.classList.add('recent-box');

            const img = document.createElement('img');
            img.src = pic ? 'data:image/png;base64,' + pic : 'pics/plp-outside.jpg';
            img.alt = title;

            const p = document.createElement('p');
            p.textContent = htmlEntityDecode(title);
            p.style.color = '#f4f4f4';
            p.title = title;

            const date = document.createElement('span');
            date.textContent = formatDateOnly(articles[i].date_updated);
            date.style.fontSize = '0.7rem';
            date.style.opacity = '0.7';

            recentArticleLayout.appendChild(img);
            recentArticleLayout.appendChild(p);
            recentArticleLayout.appendChild(date);
            recentArticleLayout.setAttribute('articleid', articleId);

            if (userType === 'writer') {
                recentArticleLayout.addEventListener('click', (event) => {
                    editArticle(event.currentTarget);
                });
            } else if (userType === 'reviewer') {
                recentArticleLayout.addEventListener('click', (event) => {
                    reviewArticleDashboard(event.currentTarget);
                });
            }

            fragment.appendChild(recentArticleLayout);
        }

        recentDraftsContainer.appendChild(fragment);
    },
    error: (error) => {
        console.log(error);
    }

});

function editArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/G16-CMS/edit-article.php?article_id=${article_id}`;
}


function reviewArticleDashboard(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/G16-CMS/review-article.php?article_id=${article_id}`;
}


function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}
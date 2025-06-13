function loadRecentArticles({ containerId, userId, url, emptyMsgText }) {
    const container = document.getElementById(containerId);

    $.ajax({
        url,
        type: 'GET',
        dataType: 'json',
        data: { 
            user_id: userId
        },
        success: (res) => {
            const { articles, widgets, user_type } = res;
            container.innerHTML = ''; // Clear first

            if (!articles || articles.length === 0) {
                const emptyMsg = document.createElement('p');
                Object.assign(emptyMsg.style, {

                    color: '#999',
                    textAlign: 'center',
                    padding: '1rem',
                    fontStyle: 'italic'
                });

                emptyMsg.textContent = emptyMsgText;
                container.appendChild(emptyMsg);
                return;
            }
            const fragment = document.createDocumentFragment();
            articles.forEach((article, i) => {
                const { article_id, article_title, date_updated } = article;
                const pic = widgets[i]?.widget_img || 'pics/plp-outside.jpg';
                const card = document.createElement('div');
                card.className = 'recent-box';
                card.setAttribute('articleid', article_id);
                const img = document.createElement('img');
                img.src = pic;
                img.alt = article_title;
                const title = document.createElement('p');
                title.textContent = htmlEntityDecode(article_title);
                title.title = article_title;
                title.style.color = '#161616';
                const date = document.createElement('span');
                date.textContent = formatDateOnly(date_updated);
                date.style.fontSize = '0.7rem';
                card.append(img, title, date);
                card.addEventListener('click', () => {
                    if (user_type === 'writer') {
                        window.location.href = `/G16-CMS/edit-article.php?article_id=${article_id}`;
                    } else {
                        window.location.href = `/G16-CMS/review-article.php?article_id=${article_id}`;
                    }
                });
                fragment.appendChild(card);
            });

            container.appendChild(fragment);
        },
        error: (error) => console.error(error)
    });
}



function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;

}

loadRecentArticles({
    containerId: 'recent-drafts-container',
    userId: userId,
    url: 'php-backend/get-recent-articles.php',
    emptyMsgText: 'No recent draft articles found.'
});

loadRecentArticles({
    containerId: 'recent-post-container',
    userId: userId,
    url: 'php-backend/get-recent-articles.php',
    emptyMsgText: 'No recent submitted articles found.'
});
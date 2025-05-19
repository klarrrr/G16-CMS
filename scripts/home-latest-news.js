
// Latest News

const highlightArticle = document.getElementById('highlight-articles');
const latestNewsTitle = document.getElementById('latest-news-title');
const latestNewsDate = document.getElementById('latest-news-day-posted');
const latestNewsParagraph = document.getElementById('latest-news-paragraph');
const latestNewsReadMore = document.getElementById('latest-read-more');

const cardNewsContainer = document.getElementById('card-news-container');
const latestNewsContainer = document.getElementById('latest-news-container');

$.ajax({
    url: 'php-backend/get-top-latest-news.php',
    type: 'POST',
    dataType: 'json',
    data: {},
    success: (res) => {
        const widgets = res.widget;

        if (!widgets || widgets.length === 0) {
            // If no widgets were returned
            cardNewsContainer.innerHTML = `
                <div class="no-news-message">
                    <p>It looks empty in here... 😕</p>
                    <h3>Looks like there are still no updates.</h3>
                </div>
            `;
            return;
        }

        const topNews = widgets[0];

        latestNewsTitle.innerHTML = topNews.widget_title;
        latestNewsTitle.setAttribute('articleid', topNews.article_owner);
        latestNewsTitle.addEventListener('click', () => {
            goToArticle(latestNewsTitle);
        });
        latestNewsDate.innerHTML = formatDateTime(topNews.date_posted);

        let picUrl = topNews.widget_img !== '' ?
            'data:image/png;base64,' + topNews.widget_img :
            'pics/plp-outside.jpg';

        highlightArticle.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;
        highlightArticle.style.backgroundRepeat = 'no-repeat';
        highlightArticle.style.backgroundSize = 'contain';
        latestNewsContainer.style.backgroundImage = `linear-gradient(rgba(10, 92, 54, 0), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;

        for (let i = 1; i < widgets.length && i <= 6; i++) {
            const widget = widgets[i];

            picUrl = widget.widget_img !== '' ?
                'data:image/png;base64,' + widget.widget_img :
                'pics/plp-outside.jpg';

            let latestCardLayout = document.createElement('div');
            latestCardLayout.innerHTML = `
                <div class="news-card" articleid="${widget.article_owner}" onclick="goToArticle(this)">
                    <img src="${picUrl}">
                    <div class="latest-info-container">
                        <div class='news-card-date-container'>
                            <p class="news-card-date">${formatDateOnly(widget.date_posted)}</p>
                            <p class="news-card-date">${formatTimeOnly(widget.date_posted)}</p>
                        </div>
                        <div class="card-text-container">
                            <h2>${widget.widget_title}</h2>
                            <p>${widget.widget_paragraph}</p>
                        </div>
                    </div>
                </div>
            `;

            let newsCard = latestCardLayout.querySelector('.news-card');
            let infoContainer = newsCard.querySelector('.latest-info-container');

            newsCard.addEventListener('mouseover', () => {
                infoContainer.classList.add('fade-in');
                infoContainer.classList.remove('fade-out');
            });

            newsCard.addEventListener('mouseout', () => {
                infoContainer.classList.remove('fade-in');
                infoContainer.classList.add('fade-out');
            });

            cardNewsContainer.appendChild(newsCard);
        }
    },
    error: (error) => {
        console.log(error);
    }
});

function goToArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/G16-CMS/lundayan-site-article.php?article_id=${article_id}`;
}

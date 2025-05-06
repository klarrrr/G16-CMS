// WHEN CREATING ARTICLE PAGES, THESE ARE THE THINGS THAT GET INSERTED INTO THE THE DATABASE

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
        const topNews = res.widget[0];

        latestNewsTitle.innerHTML = topNews.widget_title;
        latestNewsTitle.addEventListener('click', () => {
            window.location.href = 'lundayan-site-article.php';
        });
        latestNewsDate.innerHTML = formatDateTime(topNews.date_created);
        // latestNewsParagraph.innerHTML = topNews.widget_paragraph;

        let picUrl = null;
        console.log(topNews.widget_img);

        if (topNews.widget_img != '') {
            picUrl = 'pics/' + topNews.widget_img;
        } else {
            picUrl = 'pics/plp-outside.jpg';
        }

        highlightArticle.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;

        highlightArticle.style.backgroundRepeat = 'no-repeat';
        highlightArticle.style.backgroundSize = 'contain';

        latestNewsContainer.style.backgroundImage = `linear-gradient(rgba(10, 92, 54, 0), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;

        for (let i = 1; i <= 6; i++) {
            if (widgets[i].widget_img != '') {
                picUrl = 'pics/' + widgets[i].widget_img;
            } else {
                picUrl = 'pics/plp-outside.jpg';
            }


            let latestCardLayout = `
                <div class="news-card">
                    <div class='news-card-date-container'>
                        <p class="news-card-date">${formatDateOnly(widgets[i].date_created)}</p>
                        <p class="news-card-date">${formatTimeOnly(widgets[i].date_created)}</p>
                    </div>
                    <img src="${picUrl}">
                    <div class="card-text-container">   
                        <h2>
                            ${widgets[i].widget_title}
                        </h2>

                        <p>
                            ${widgets[i].widget_paragraph}
                        </p>
                    </div>
                </div>
            `;

            cardNewsContainer.innerHTML += latestCardLayout;
        }

    },
    error: (error) => {
        console.log(error);
    }
});
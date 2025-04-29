// WHEN CREATING ARTICLE PAGES, THESE ARE THE THINGS THAT GET INSERTED INTO THE THE DATABASE

// Latest News

const latestNewsTitle = document.getElementById('latest-news-title');
const latestNewsDate = document.getElementById('latest-news-day-posted');
const latestNewsParagraph = document.getElementById('latest-news-paragraph');
const latestNewsReadMore = document.getElementById('latest-read-more');
const latestNewsPic = document.getElementById('latest-news-pic');

const cardNewsContainer = document.getElementById('card-news-container');

$.ajax({
    url: '../php-backend/get-top-latest-news.php',
    type: 'POST',
    dataType: 'json',
    data: {},
    success: (res) => {
        const widgets = res.widget;
        const topNews = res.widget[0];

        latestNewsTitle.innerHTML = topNews.widget_title;
        latestNewsDate.innerHTML = formatDateTime(topNews.date_created);
        latestNewsParagraph.innerHTML = topNews.widget_paragraph;
        latestNewsPic.src = 'pics/' + topNews.widget_img;

        for (let i = 1; i <= 6; i++) {
            const newsCard = document.createElement('div');
            newsCard.className = 'news-card'

            const newsCardImg = document.createElement('img');
            newsCardImg.src = 'pics/' + widgets[i].widget_img;

            const cardTextContainer = document.createElement('div');
            cardTextContainer.className = 'card-text-container';

            const newsCardTitle = document.createElement('h2');
            newsCardTitle.innerHTML = widgets[i].widget_title;

            const newsCardDate = document.createElement('p');
            newsCardDate.innerHTML = 'Posted' + '<small> ● </small>' + formatDateTime(widgets[i].date_created);

            const hr = document.createElement('hr');

            const newsCardParagraph = document.createElement('p');

            newsCardParagraph.textContent = widgets[i].widget_paragraph;

            const newsCardReadMore = document.createElement('a');

            newsCardReadMore.href = '#';
            newsCardReadMore.textContent = 'Read More';

            cardTextContainer.appendChild(newsCardTitle);
            cardTextContainer.appendChild(newsCardDate);
            cardTextContainer.appendChild(hr);
            cardTextContainer.appendChild(newsCardParagraph);
            cardTextContainer.appendChild(newsCardReadMore);

            newsCard.appendChild(newsCardImg);
            newsCard.appendChild(cardTextContainer);

            cardNewsContainer.appendChild(newsCard);
        }

    },
    error: (error) => {
        console.log(error);
    }
});
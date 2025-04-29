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

        for (const i = 1; i < 6; i++) {
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

function formatDateTime(datetimeString) {
    // Convert the space to a 'T' to create an ISO-compatible datetime string
    const isoString = datetimeString.replace(" ", "T");
    const date = new Date(isoString);

    // Array of month names
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    // Get hours, minutes, seconds for the time portion
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    const ampm = hours >= 12 ? "PM" : "AM";

    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours === 0 ? 12 : hours;

    // Format minutes and seconds to always have two digits
    const paddedMinutes = minutes < 10 ? "0" + minutes : minutes;
    const paddedSeconds = seconds < 10 ? "0" + seconds : seconds;

    const formattedDate = `${month} ${day}, ${year}`;
    const formattedTime = `${hours}:${paddedMinutes}:${paddedSeconds} ${ampm}`;

    return `${formattedDate} - ${formattedTime}`;
}
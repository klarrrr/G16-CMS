const bulletinCardNewsContainer = document.getElementById('bulletin-card-news-container');

$.ajax({
    url: '../php-backend/get-top-latest-news.php',
    type: 'POST',
    dataType: 'json',
    data: {},
    success: (res) => {
        const widgets = res.widget;

        widgets.forEach(widget => {
            const newsCard = document.createElement('div');
            newsCard.className = 'bulletin-news-card'

            const newsCardImg = document.createElement('img');
            newsCardImg.src = 'pics/' + widget.widget_img;
            newsCardImg.loading = 'lazy';

            const cardTextContainer = document.createElement('div');
            cardTextContainer.className = 'card-text-container';

            const newsCardTitle = document.createElement('h2');
            newsCardTitle.innerHTML = widget.widget_title;

            const newsCardDate = document.createElement('p');
            newsCardDate.innerHTML = 'Posted' + '<small> ● </small>' + formatDateTime(widget.date_created);
            newsCardDate.className = 'time-posted';
            newsCardDate.style.paddingBottom = '1em';

            const hr = document.createElement('hr');

            const newsCardParagraph = document.createElement('p');

            newsCardParagraph.textContent = widget.widget_paragraph;

            const newsCardReadMore = document.createElement('a');

            newsCardReadMore.href = '#';
            newsCardReadMore.textContent = 'Read More';
            const titleAndDateContainer = document.createElement('div');
            titleAndDateContainer.appendChild(newsCardTitle);
            titleAndDateContainer.appendChild(newsCardDate);
            titleAndDateContainer.appendChild(hr);
            cardTextContainer.appendChild(titleAndDateContainer);

            cardTextContainer.appendChild(newsCardParagraph);
            cardTextContainer.appendChild(newsCardReadMore);

            newsCard.appendChild(newsCardImg);
            newsCard.appendChild(cardTextContainer);

            bulletinCardNewsContainer.appendChild(newsCard);
        });

    },
    error: (error) => {
        console.log(error);
    }
});

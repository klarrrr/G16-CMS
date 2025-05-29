$.ajax({
    url: 'php-backend/get-announcements.php',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
        const container = document.getElementById('upcoming-events-container');
        container.innerHTML = ''; // Clear previous items

        if (data.length === 0) {
            container.innerHTML = `<div class="no-events-message" id='calendar-no-event'>No upcoming events at the moment 😔</div>`;
            return;
        }

        data.forEach(article => {
            const div = document.createElement('div');
            div.classList.add('event');
            div.setAttribute('articleid', article.article_id);

            div.innerHTML = `
                <img src="${article.widget_img}" alt="">
                <div class="event-text-container">
                    <h3>${article.article_title}</h3>
                    <p>Posted on ${article.date_posted}</p>
                </div>
            `;

            div.addEventListener('click', function () {
                goToArticle(this);
            });

            container.appendChild(div);
        });
    },
    error: function (xhr, status, error) {
        console.error("Failed to fetch announcements:", error);
        const container = document.getElementById('upcoming-events-container');
        container.innerHTML = `<div class="no-events-message">Unable to load upcoming events.</div>`;
    }
});

const highlightArticle = document.getElementById('highlight-articles');
const latestNewsTitle = document.getElementById('latest-news-title');
const latestNewsDate = document.getElementById('latest-news-day-posted');
const cardNewsContainer = document.getElementById('card-news-container');
const latestNewsContainer = document.getElementById('latest-news-container');
const paginationContainer = document.getElementById('pagination');

let currentPage = 1;
const itemsPerPage = 6; // Matches your current layout (6 cards + 1 highlight)

// Utility to render article cards
function renderWidgets(widgets) {
    let html = '';

    widgets.forEach((widget, index) => {
        const picUrl = widget.widget_img
            ? `data:image/png;base64,${widget.widget_img}`
            : 'pics/plp-outside.jpg';

        // First widget is the highlight article
        if (index === 0) {
            latestNewsTitle.innerHTML = widget.widget_title;
            latestNewsTitle.setAttribute('articleid', widget.article_owner);
            latestNewsDate.innerHTML = formatDateTime(widget.date_posted);

            highlightArticle.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;
            highlightArticle.style.backgroundRepeat = 'no-repeat';
            highlightArticle.style.backgroundSize = 'contain';
            latestNewsContainer.style.backgroundImage = `linear-gradient(rgba(10, 92, 54, 0), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;
        }
        // Remaining widgets are cards
        else {
            html += `
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
        }
    });

    cardNewsContainer.innerHTML = html;

    // Add hover effects to cards
    document.querySelectorAll('.news-card').forEach(card => {
        const infoContainer = card.querySelector('.latest-info-container');

        card.addEventListener('mouseover', () => {
            infoContainer.classList.add('fade-in');
            infoContainer.classList.remove('fade-out');
        });

        card.addEventListener('mouseout', () => {
            infoContainer.classList.remove('fade-in');
            infoContainer.classList.add('fade-out');
        });
    });
}

// Utility to render pagination
function renderPagination(totalPages, currentPage) {
    let pagination = '';

    // Previous button
    if (currentPage > 1) {
        pagination += `<a href="#" class="page-link" data-page="${currentPage - 1}">&laquo; Previous</a>`;
    }

    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        pagination += `<a href="#" class="page-link ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</a>`;
    }

    // Next button
    if (currentPage < totalPages) {
        pagination += `<a href="#" class="page-link" data-page="${currentPage + 1}">Next &raquo;</a>`;
    }

    paginationContainer.innerHTML = pagination;
}

// Load news with pagination
function loadLatestNews(page = 1) {
    $.ajax({
        url: 'php-backend/get-top-latest-news.php',
        type: 'GET',
        dataType: 'json',
        data: { page, limit: itemsPerPage + 1 }, // +1 for the highlight article
        success: (res) => {
            if (!res.widget || res.widget.length === 0) {
                // Fallback for empty results
                cardNewsContainer.innerHTML = `
                    <div class="no-news-message">
                        <p>It looks empty in here... 😕</p>
                        <h3>Looks like there are still no updates.</h3>
                    </div>
                `;

                highlightArticle.style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url('pics/plp-outside.jpg')";
                latestNewsTitle.innerHTML = "Stay tuned!";
                latestNewsDate.innerHTML = "No updates yet.";

                paginationContainer.innerHTML = '';
                return;
            }

            renderWidgets(res.widget);
            renderPagination(res.totalPages, page);
        },
        error: (error) => {
            console.log(error);
            // Show error message
            cardNewsContainer.innerHTML = `
                <div class="no-news-message">
                    <p>Something went wrong... 😕</p>
                    <h3>Unable to load news at this time.</h3>
                </div>
            `;
            paginationContainer.innerHTML = '';
        }
    });
}

// Handle pagination clicks
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;
    loadLatestNews(page);
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Initial load
loadLatestNews(currentPage);

function goToArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/G16-CMS/lundayan-site-article.php?article_id=${article_id}`;
}
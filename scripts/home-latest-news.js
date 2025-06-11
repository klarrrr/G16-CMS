const highlightArticle = document.getElementById('highlight-articles');
const latestNewsTitle = document.getElementById('latest-news-title');
const latestNewsDate = document.getElementById('latest-news-day-posted');
const cardNewsContainer = document.getElementById('card-news-container');
const latestNewsContainer = document.getElementById('latest-news-container');
const paginationContainer = document.getElementById('pagination');

let currentHighlightIndex = 0;
let currentHighlightWidgets = [];
let currentPage = 1;
const itemsPerPage = 6;
let highlightInterval = null;

// First, load the absolute latest article for the highlight
function loadLatestHighlight() {
    $.ajax({
        url: 'php-backend/get-latest-highlight.php',
        type: 'GET',
        dataType: 'json',
        success: (res) => {
            // Clear any existing interval
            if (highlightInterval) {
                clearInterval(highlightInterval);
                highlightInterval = null;
            }

            if (res.widgets && res.widgets.length > 0) {
                currentHighlightWidgets = res.widgets;
                currentHighlightIndex = 0;
                updateHighlightDisplay();

                // Add navigation buttons if there are multiple highlights
                if (res.hasHighlights && currentHighlightWidgets.length > 1) {
                    addHighlightNavigation();
                    // Start auto-rotation only if there are multiple highlights
                    startHighlightRotation();
                }
            } else {
                showFallbackContent();
            }
        },
        error: (error) => {
            console.log(error);
            showFallbackContent();
        }
    });
}

// Auto rotation
function startHighlightRotation() {
    // Set interval to rotate every 5 seconds
    highlightInterval = setInterval(() => {
        navigateHighlight(1); // Go to next highlight
    }, 5000); // 5000 milliseconds = 5 seconds

    // Pause rotation when user hovers over the highlight
    highlightArticle.addEventListener('mouseenter', pauseRotation);
    highlightArticle.addEventListener('mouseleave', resumeRotation);
}

function pauseRotation() {
    if (highlightInterval) {
        clearInterval(highlightInterval);
        highlightInterval = null;
    }
}

function resumeRotation() {
    if (!highlightInterval && currentHighlightWidgets.length > 1) {
        startHighlightRotation();
    }
}

function updateHighlightDisplay() {
    const widget = currentHighlightWidgets[currentHighlightIndex];
    const picUrl = widget.widget_img
        ? `${widget.widget_img}`
        : 'pics/plp-outside.jpg';

    latestNewsTitle.innerHTML = widget.widget_title;
    latestNewsTitle.setAttribute('articleid', widget.article_owner);
    latestNewsDate.innerHTML = formatDateTime(widget.date_posted);

    highlightArticle.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;
    highlightArticle.style.backgroundRepeat = 'no-repeat';
    highlightArticle.style.backgroundSize = 'contain';
    highlightArticle.style.backgroundPosition = 'center';
    latestNewsContainer.style.backgroundImage = `linear-gradient(rgba(10, 92, 54, 0), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url(${picUrl})`;
    latestNewsTitle.onclick = () => goToArticle(latestNewsTitle);
}

function addHighlightNavigation() {
    const navContainer = document.createElement('div');
    navContainer.className = 'highlight-nav';
    navContainer.style.position = 'absolute';
    navContainer.style.bottom = '20px';
    navContainer.style.right = '20px';
    navContainer.style.display = 'flex';
    navContainer.style.gap = '10px';
    navContainer.style.zIndex = '10';

    const prevBtn = document.createElement('button');
    prevBtn.innerHTML = '&lt;';
    prevBtn.className = 'highlight-nav-btn';
    prevBtn.onclick = (e) => {
        e.stopPropagation();
        navigateHighlight(-1);
    };

    const nextBtn = document.createElement('button');
    nextBtn.innerHTML = '&gt;';
    nextBtn.className = 'highlight-nav-btn';
    nextBtn.onclick = (e) => {
        e.stopPropagation();
        navigateHighlight(1);
    };

    navContainer.appendChild(prevBtn);
    navContainer.appendChild(nextBtn);
    highlightArticle.appendChild(navContainer);

    // Add some basic styling
    const style = document.createElement('style');
    style.textContent = `
        .highlight-nav-btn {
            background: rgba(0,0,0,0.5);
            color: white;
            border: 1px solid #fcb404;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .highlight-nav-btn:hover {
            background: #fcb404;
            color: black;
        }
    `;
    document.head.appendChild(style);
}

function navigateHighlight(direction) {
    // Pause and restart rotation to reset the 5-second timer
    pauseRotation();

    currentHighlightIndex += direction;

    // Wrap around if needed
    if (currentHighlightIndex < 0) {
        currentHighlightIndex = currentHighlightWidgets.length - 1;
    } else if (currentHighlightIndex >= currentHighlightWidgets.length) {
        currentHighlightIndex = 0;
    }

    updateHighlightDisplay();

    // Only resume if there are multiple highlights
    if (currentHighlightWidgets.length > 1) {
        resumeRotation();
    }
}

function showFallbackContent() {
    highlightArticle.style.backgroundImage = "linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.65), rgb(0, 0, 0)), url('pics/plp-outside.jpg')";
    latestNewsTitle.innerHTML = "Stay tuned!";
    latestNewsDate.innerHTML = "No updates yet.";
}

// Load only card news with pagination
function loadCardNews(page = 1) {
    $.ajax({
        url: 'php-backend/get-paginated-news.php',
        type: 'GET',
        dataType: 'json',
        data: { page, limit: itemsPerPage },
        success: (res) => {
            if (!res.widget || res.widget.length === 0) {
                cardNewsContainer.innerHTML = `
                    <div class="no-news-message">
                        <p>It looks empty in here... 😕</p>
                        <h3>Looks like there are still no updates.</h3>
                    </div>
                `;
                paginationContainer.innerHTML = '';
                return;
            }

            renderCardWidgets(res.widget);
            renderPagination(res.totalPages, page);
        },
        error: (error) => {
            console.log(error);
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

// Render only cards (no highlight)
function renderCardWidgets(widgets) {
    let html = '';

    widgets.forEach((widget) => {
        const picUrl = widget.widget_img
            ? `${widget.widget_img}`
            : 'pics/plp-outside.jpg';

        html += `
            <div class="news-card" articleid="${widget.article_owner}" onclick="goToArticle(this)">
                <img src="${picUrl}" loading="lazy">
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

// Handle pagination clicks
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;
    loadCardNews(page);
    window.scrollTo({ top: cardNewsContainer.offsetTop, behavior: 'smooth' });
});

// Initial load
loadLatestHighlight(); // Load highlight once
loadCardNews(currentPage); // Load first page of cards

function goToArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/lundayan-site-article.php?article_id=${article_id}`;
}
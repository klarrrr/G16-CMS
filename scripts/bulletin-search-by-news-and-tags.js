const searchBar = document.getElementById('search-bar');

// Utility to render article cards
function renderWidgets(widgets) {
    const rows = widgets.map(widget => {
        const picUrl = widget.widget_img
            ? `${widget.widget_img}`
            : 'pics/plp-outside.jpg';

        return `
            <div class="bulletin-news-card minimalist" articleid='${widget.article_owner}'>
                <img src="${picUrl}" loading="lazy" alt="${widget.widget_title}">
                <div class="card-overlay"></div>
                <div class="card-content">
                    <span class="card-date">${formatDateTime(widget.date_posted)}</span>
                    <h3 class="card-title">${widget.widget_title}</h3>
                    <p class="card-excerpt">${widget.widget_paragraph.substring(0, 150)}${widget.widget_paragraph.length > 150 ? '...' : ''}</p>
                </div>
            </div>
        `;
    }).join('');

    $(bulletinCardNewsContainer).html(rows);

    // Attach "Read More"
    $('.bulletin-news-card').on('click', function (e) {
        e.preventDefault();
        goToArticle(this);
    });
}


// Utility to render pagination
function renderPagination(totalPages, currentPage) {
    let pagination = '';
    for (let i = 1; i <= totalPages; i++) {
        pagination += `<a href="#" class="page-link ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</a>`;
    }
    return pagination;
}

// Handle article redirection
function goToArticle(articleElem) {
    const article_id = articleElem.getAttribute('articleid');
    window.location.href = `/lundayan-site-article.php?article_id=${article_id}`;
}

// Attach "Read More" event listeners
function bindReadMoreLinks() {
    document.querySelectorAll('.read-more').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            goToArticle(button);
        });
    });
}

// General loader function
function loadArticles(url, data = {}, page = 1) {
    $.ajax({
        url,
        type: 'GET',
        dataType: 'json',
        data,
        success: (res) => {
            const widgets = res.widget || res; // In case the structure differs
            const currentPage = data.page || 1;
            $(bulletinCardNewsContainer).html(renderWidgets(widgets));
            bindReadMoreLinks();
            $(paginationContainer).html(renderPagination(res.totalPages || 1, currentPage));
        },
        error: (err) => console.error(err)
    });
}

// Search News
function loadSearchData(page = 1, searchFor = '') {
    loadArticles('php-backend/bulletin-search-news.php', { page, search: searchFor }, page);
}

// Search by Tags
function getSelectedTags() {
    return Array.from(document.querySelectorAll('.tag.selected'))
        .map(tag => tag.getAttribute('tag-id'))
        .filter(Boolean);
}

function loadNewsByTags(page = 1) {
    const tagIds = getSelectedTags();
    if (tagIds.length === 0) {
        console.log('No tags selected');
        return;
    }

    $.ajax({
        url: 'php-backend/bulletin-search-by-tags.php',
        type: 'POST',
        dataType: 'json',
        data: {
            page,
            tag_ids: tagIds
        },
        success: (res) => {
            const widgets = res.widget || res;
            $(bulletinCardNewsContainer).html(renderWidgets(widgets));
            bindReadMoreLinks();
            $(paginationContainer).html(renderPagination(res.totalPages || 1, page));
        },
        error: (err) => console.error(err)
    });
}

// Enter key triggers search
searchBar.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        loadSearchData(1, searchBar.value);
    }
});

// Pagination click
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;

    if (getSelectedTags().length > 0) {
        loadNewsByTags(page);
    } else {
        loadSearchData(page, searchBar.value);
    }
});

// Initial load
loadSearchData(currentPage || 1, searchBar.value || '');

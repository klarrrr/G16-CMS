let currentPage = 1;
let debounceTimer;

const sortDropdown = document.getElementById('sort-articles-dropdown');

function fetchArticles(query = '', sortOrder = 'desc', page = 1) {
    $.ajax({
        url: 'php-backend/fetch-review-active-articles.php',
        type: 'post',
        dataType: 'json',
        data: {
            search: query,
            sort: sortOrder,
            page: page
        },
        success: (res) => {
            const activeArticles = res.articles;
            const container = $('#articles-boxes-container');

            if (activeArticles.length === 0) {
                container.html('<p>No active articles found.</p>');
                $('#pagination').html('');
                return;
            }

            container.empty();

            activeArticles.forEach(article => {
                const {
                    article_id,
                    article_title,
                    completion_status,
                    approve_status,
                    date_posted,
                    date_updated,
                    article_type,
                    widget_img,
                    widget_paragraph,
                    user_first_name,
                    user_last_name
                } = article;

                // Title & snippet cleanup
                const cleanTitle = article_title.replace(/(<([^>]+)>)/gi, "");
                const shortTitle = cleanTitle.length > 50 ? cleanTitle.substring(0, 50) + '...' : cleanTitle;

                const cleanSnippet = widget_paragraph.replace(/(<([^>]+)>)/gi, "");
                const snippet = cleanSnippet.length > 150 ? cleanSnippet.substring(0, 150) + '...' : cleanSnippet;

                const approveStat = (approve_status == 'yes') ? 'Approved' : 'Not Approved';

                // Format date or set 'No Date'
                let formattedDate = 'No Date';
                if (date_updated && new Date(date_updated).getTime() > 0) {
                    formattedDate = new Date(date_updated).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }

                const imageHTML = widget_img
                    ? `<img src="data:image/png;base64,${widget_img}" class="archive-img" alt="Article Image">`
                    : `<div class="archive-img placeholder-img">No image</div>`;

                const authorFullName = `${htmlEntityDecode(user_first_name)} ${htmlEntityDecode(user_last_name)}`;

                const articleBox = `
                    <div class="archive-box">
                        ${imageHTML}
                        <div class="archive-header">
                            <div class="statuses">
                                  <span class="article-type">${article_type.charAt(0).toUpperCase() + article_type.slice(1)}</span>
                                   <span class="article-type">${completion_status.charAt(0).toUpperCase() + completion_status.slice(1)}</span>
                                    <span class="article-type">${approveStat.charAt(0).toUpperCase() + approveStat.slice(1)}</span>
                            </div>
                            <span class="archive-date">${formattedDate}</span>
                        </div>
                        <h3 class="archive-title">${htmlEntityDecode(shortTitle)}</h3>
                        <p class="archive-snippet">${htmlEntityDecode(snippet)}</p>
                        <p class="archive-author">By ${authorFullName}</p>
                        <a href="review-article.php?article_id=${article_id}" class="archive-readmore">Review Article</a>
                    </div>
                `;

                container.append(articleBox);
            });

            // Handle pagination UI
            const totalPages = Math.ceil(res.total / res.per_page);
            renderPagination(totalPages, res.current_page);
        },
        error: (error) => {
            console.log(error);
        }
    });
}

function renderPagination(totalPages, current) {
    let html = '';
    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="pagination-btn ${i === current ? 'active' : ''}" data-page="${i}">${i}</button>`;
    }
    $('#pagination').html(html);
}

$(document).on('click', '.pagination-btn', function () {
    currentPage = parseInt($(this).attr('data-page'));
    const query = $('#search-your-active-articles').val().trim();
    const sort = $('#sort-articles-dropdown').val();
    fetchArticles(query, sort, currentPage);
});

$('#search-your-active-articles').on('input', function () {
    const query = this.value.trim();
    const sort = sortDropdown.value;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        currentPage = 1;
        fetchArticles(query, sort, currentPage);
    }, 500);
});

sortDropdown.addEventListener('change', () => {
    const query = $('#search-your-active-articles').val().trim();
    currentPage = 1;
    fetchArticles(query, sortDropdown.value, currentPage);
});

// Initial fetch
fetchArticles();

function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}



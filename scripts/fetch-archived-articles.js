const sortArchivedDropdown = document.getElementById('sort-archived-dropdown');
const paginationContainer = document.createElement('div');
paginationContainer.classList.add('pagination-container');
document.getElementById('main-page').appendChild(paginationContainer);
let debounceTimer;

let currentPage = 1;
const limit = 6;

function fetchArchivedArticles(query = '', sortOrder = 'desc', page = 1) {
    $.ajax({
        url: 'php-backend/fetch-archived-articles.php',
        type: 'post',
        dataType: 'json',
        data: {
            user_id: user_id,
            search: query,
            sort: sortOrder,
            page: page,
            limit: limit
        },
        success: (res) => {
            const { articles: archivedArticles, totalPages } = res;
            const container = $('#archives-boxes-container');
            currentPage = page;

            container.empty();
            paginationContainer.innerHTML = '';

            if (archivedArticles.length === 0) {
                container.html('<p>No archived articles found.</p>');
                return;
            }

            archivedArticles.forEach(article => {
                const {
                    article_id,
                    article_title,
                    date_posted,
                    article_type,
                    widget_img,
                    widget_paragraph,
                    user_first_name,
                    user_last_name
                } = article;

                const snippet = widget_paragraph.replace(/(<([^>]+)>)/gi, "").substring(0, 150) + '...';

                let formattedDate = 'No Date';
                if (date_posted && new Date(date_posted).getTime() > 0) {
                    formattedDate = new Date(date_posted).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }

                const imageHTML = widget_img ?
                    `<img src="${widget_img}" class="archive-img" alt="Article Image">` :
                    `<div class="archive-img placeholder-img">No image</div>`;

                const authorFullName = `${user_first_name} ${user_last_name}`;

                const articleBox = `
                    <div class="archive-box">
                        ${imageHTML}
                        <div class="archive-header">
                            <span class="article-type">${article_type.charAt(0).toUpperCase() + article_type.slice(1)}</span>
                            <span class="archive-date">${formattedDate}</span>
                        </div>
                        <h3 class="archive-title">${article_title}</h3>
                        <p class="archive-snippet">${htmlEntityDecode(snippet)}</p>
                        <p class="archive-author">By ${authorFullName}</p>
                        <a href="edit-article.php?article_id=${article_id}" class="archive-readmore">Edit</a>
                    </div>
                `;

                container.append(articleBox);
            });

            // Build pagination buttons
            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement('button');
                btn.className = 'pagination-btn';
                btn.textContent = i;
                if (i === page) btn.classList.add('active');
                btn.addEventListener('click', () => {
                    const query = document.getElementById('search-your-archived-articles').value.trim();
                    const sort = sortArchivedDropdown.value;
                    fetchArchivedArticles(query, sort, i);
                });
                paginationContainer.appendChild(btn);
            }
        },
        error: (error) => {
            console.log(error);
        }
    });
}

function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}

fetchArchivedArticles();

document.getElementById('search-your-archived-articles').addEventListener('input', function () {
    const query = this.value.trim();
    const sort = sortArchivedDropdown.value;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        fetchArchivedArticles(query, sort, 1); 
    }, 500);
});

sortArchivedDropdown.addEventListener('change', () => {
    const query = document.getElementById('search-your-archived-articles').value.trim();
    fetchArchivedArticles(query, sortArchivedDropdown.value, 1);
});

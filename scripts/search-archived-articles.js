const searchInput = document.getElementById('search-your-archived-articles');
let debounceTimer = null;

searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
        const query = searchInput.value.trim();

        $.ajax({
            url: 'php-backend/fetch-archived-articles.php',
            type: 'post',
            dataType: 'json',
            data: {
                user_id: user_id,
                search: query
            },
            success: (res) => {
                const archivedArticles = res;
                const container = $('#archives-boxes-container');

                if (archivedArticles.length === 0) {
                    container.html('<p style="font-family: sub">No archived articles found.</p>');
                    return;
                }

                container.empty();

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
                    const formattedDate = new Date(date_posted).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    const imageHTML = widget_img ?
                        `<img src="${widget_img}" class="archive-img" alt="Article Image">` :
                        `<div class="archive-img placeholder-img">No image</div>`;

                    const authorFullName = `${htmlEntityDecode(user_first_name)} ${htmlEntityDecode(user_last_name)}`;

                    const articleBox = `
                        <div class="archive-box">
                            ${imageHTML}
                            <div class="archive-header">
                                <span class="article-type">${article_type.charAt(0).toUpperCase() + article_type.slice(1)}</span>
                                <span class="archive-date">${formattedDate}</span>
                            </div>
                            <h3 class="archive-title">${htmlEntityDecode(article_title)}</h3>
                            <p class="archive-snippet">${htmlEntityDecode(snippet)}</p>
                            <p class="archive-author">By ${authorFullName}</p>
                            <a href="edit-article.php?article_id=${article_id}" class="archive-readmore">Edit Article</a>
                        </div>
                    `;

                    container.append(articleBox);
                });
            },
            error: (error) => {
                console.log("Search Error: ", error);
            }
        });
    }, 500); // debounce 500ms
});

function htmlEntityDecode(str) {
    const txt = document.createElement('textarea');
    txt.innerHTML = str;
    return txt.value;
}

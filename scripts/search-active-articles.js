const searchInput = document.getElementById('search-your-active-articles');

searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim();

    $.ajax({
        url: 'php-backend/fetch-active-articles.php',
        type: 'post',
        dataType: 'json',
        data: {
            user_id: user_id,
            search: query
        },
        success: (res) => {
            const activeArticles = res;
            const container = $('#articles-boxes-container');

            if (activeArticles.length === 0) {
                container.html('<p style="font-family: sub">No active articles found.</p>');
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
                if (date_posted && new Date(date_posted).getTime() > 0) {
                    formattedDate = new Date(date_posted).toLocaleDateString('en-US', {
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
});

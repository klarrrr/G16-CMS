const recentDraftsContainer = document.getElementById('recent-drafts-container');

// get 5 articles that are posted and sorted by recent date

$.ajax({
    url: 'php-backend/get-recent-draft-articles.php',
    type: 'get',
    dataType: 'json',
    data: {},
    success: (res) => {
        const articles = res.articles;
        const widgets = res.widgets;

        const fragment = document.createDocumentFragment();

        for (let i = 0; i < articles.length; i++) {
            const title = articles[i].article_title;
            const pic = widgets[i] ? widgets[i].widget_img : 'pics/plp-outside.jpg';  // Handle case when widget might be undefined

            // Create the div element for each recent article
            const recentArticleLayout = document.createElement('div');
            recentArticleLayout.classList.add('recent-box');

            // Create the image element and set attributes
            const img = document.createElement('img');
            img.src = pic ? 'data:image/png;base64,' + pic : 'pics/plp-outside.jpg';  // Check for pic existence
            img.alt = title;

            // Create the paragraph element for the title
            const p = document.createElement('p');
            p.textContent = title;

            // Append the image and paragraph to the recentArticleLayout
            recentArticleLayout.appendChild(img);
            recentArticleLayout.appendChild(p);

            // Append the recentArticleLayout to the fragment
            fragment.appendChild(recentArticleLayout);
        }

        // Append the fragment to the container
        recentDraftsContainer.appendChild(fragment);

    },
    error: (error) => {
        console.log(error);
    }

});
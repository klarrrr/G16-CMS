const articleContainer = document.getElementById('articles-boxes-container');

$.ajax({
    url: 'php-backend/add_article.php',
    type: "POST",
    dataType: 'json',
    data: {},
    success: (res) => {
        const allData = res.data;

        // Lagay muna sa fragment
        const fragment = document.createDocumentFragment();

        for (let i = 0; i < allData.length; i++) {
            const widget = allData[i];
            const img = widget.widget_img ? widget.widget_img : 'pics/plp-outside.jpg';

            const title = widget.widget_title;
            let status = widget.approve_status;
            status = (status == 'yes') ? 'Approved' : 'Not Approved'; // caps 1st
            // const statusColor = (widget.approve_status == 'yes') ? 'green' : 'red';
            const first_name = widget.user_first_name;
            const last_name = widget.user_last_name;
            const articleId = widget.article_id;

            const div = document.createElement('div');

            div.innerHTML = `
                <div class="article-box">
                    <div class="article-img-container" style='background-image: url(${img});'>
                        <img loading="lazy" src="${img}" alt="${title}" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>${title}</h2>
                        <h3>by ${first_name} ${last_name}</h3>
                        <h4 style='font-weight: bolder;'>${status}</h4>
                    </div>
                    <button class='edit-article-button' articleid='${articleId}' onclick='editArticle(this)'>Edit Page</button>
                </div>
            `;

            fragment.appendChild(div);

            // articleContainer.innerHTML += layout;
        }

        // Tsaka I append sa article container
        articleContainer.appendChild(fragment);

    },
    error: (error) => {
        console.log(error);
    }
});

function editArticle(thisButton) {
    const article_id = thisButton.getAttribute('articleid');
    window.location.href = `edit-article.php?article_id=${article_id}`;
}
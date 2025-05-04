// Temporary Only, Change this to be dynamic later on
const user_id = 3;
const articleContainer = document.getElementById('articles-boxes-container');

$.ajax({
    url: '../php-backend/add_article.php',
    type: "POST",
    dataType: 'json',
    data: {
        user_id: user_id
    },
    success: (res) => {
        const widgets = res.widgets;
        const article_status = res.article_status;

        for (let i = 0; i < widgets.length; i++) {
            const img = '../upload-images/' + widgets[i].widget_img;
            const title = widgets[i].widget_title;
            const status = article_status[i];

            let layout = `
                <div class="article-box">
                    <div class="article-img-container" style='background-image: url(${img});'>
                        <img src="${img}" alt="${title}" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>${title}</h2>
                        <h3>${status}</h3>
                    </div>
                    <button class='edit-article-button'>Edit Page</button>
                </div>
            `;

            articleContainer.innerHTML += layout;
        }

    },
    error: (error) => {
        console.log(error);
    }
});
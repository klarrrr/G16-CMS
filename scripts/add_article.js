// Temporary Only, Change this to be dynamic later on
const articleContainer = document.getElementById('articles-boxes-container');

$.ajax({
    url: '../php-backend/add_article.php',
    type: "POST",
    dataType: 'json',
    data: {},
    success: (res) => {
        const widgets = res.widgets;
        const articles = res.articles;
        const authors = res.authors;


        for (let i = 0; i < widgets.length; i++) {
            let img = null;
            if (widgets[i].widget_img != null) {
                img = 'upload-images/' + widgets[i].widget_img;
            } else {
                img = 'pics/plp-outside.jpg';
            }

            const title = widgets[i].widget_title;
            let status = articles[i].edit_status;
            status = status.charAt(0).toUpperCase() + status.slice(1); // caps 1st
            const first_name = authors[i].user_first_name;
            const last_name = authors[i].user_last_name;
            const articleId = articles[i].article_id;

            let layout = `
                <div class="article-box">
                    <div class="article-img-container" style='background-image: url(${img});'>
                        <img src="${img}" alt="${title}" class='article-image-preview'>
                    </div>
                    <div class="article-title-status-container">
                        <h2>${title}</h2>
                        <h3>by ${first_name} ${last_name}</h3>
                        <h4 style='color: green;'>${status}</h4>
                    </div>
                    <button class='edit-article-button' articleid='${articleId}' onclick='editArticle(this)'>Edit Page</button>
                </div>
            `;

            articleContainer.innerHTML += layout;
        }

    },
    error: (error) => {
        console.log(error);
    }
});

function editArticle(thisButton) {
    const article_id = thisButton.getAttribute('articleid');
    // Pass GET method the article id
    // Verify by using the user id in the session too
    // So Article id = article_id AND user_id = $_SESSION['user_id'];
    window.location.href = `../edit-article.php?article_id=${article_id}`;
}
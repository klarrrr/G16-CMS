const addArticBtn = document.getElementById('add-article-page-btn');
const page_id = document.getElementById('select-pages');

addArticBtn.addEventListener('click', () => {
    $.ajax({
        url: '../php-backend/add_article.php',
        type: "POST",
        dataType: 'json',
        data: {
            page_id: page_id.value
        },
        success: function (res) {
            // res - PHP Returnee object
            const recentElements = res.elements;
            buildEditDetails(recentElements);
            buildPreviewSite(recentElements);
        },
        error: function (error) {
            console.log(error);
        }
    });
});
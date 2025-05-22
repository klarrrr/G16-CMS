const addArticleBtn = document.getElementById('shortcut-create-article');

const reviewArticle = document.getElementById('shortcut-review-article');

const auditBtn = document.getElementById('shortcut-audit-log');

const accountSettingsBtn = document.getElementById('shortcut-account-settings');

addArticleBtn.addEventListener('click', () => {
    $.ajax({
        url: 'php-backend/create-article.php',
        type: 'post',
        dataType: 'json',
        data: {
            title: 'Article Default Title',
            content: '<p>Your article content journey starts here...</p>',
            shortDesc: 'Your short description is here...'
        },
        success: (res) => {
            if (res.status == 'success') {
                // Get the latest article's id
                $.ajax({
                    url: 'php-backend/add-article-get-latest-article.php',
                    type: 'post',
                    dataType: 'json',
                    data: {},
                    success: (res) => {
                        if (res.status == 'success') {
                            // go to edit page with the get id
                            window.location.href = 'edit-article.php?article_id=' + res.latestArticle;
                        }
                    },
                    error: (error) => {

                    }
                });
            }
        },
        error: (error) => {
            console.log("Create Article Error :" + error);
        }
    });
});

reviewArticle.addEventListener('click', () => {
    window.location.href = 'for-review-article-page.php';
});

auditBtn.addEventListener('click', () => {
    window.location.href = 'audit-log-page.php';
});

accountSettingsBtn.addEventListener('click', () => {
    window.location.href = 'account-settings.php';
})
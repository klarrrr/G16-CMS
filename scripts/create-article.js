const defaultTitle = 'Article Default Title';
const defaultContent = 'You\'re article content journey starts here...';
const defaultShortDesc = 'You\'re short description is here...';


saveArticle.addEventListener('click', () => {
    $.ajax({
        url: 'php-backend/create-article.php',
        type: 'post',
        dataType: 'json',
        data: {
            title: defaultTitle,
            content: defaultContent,
            shortDesc: defaultShortDesc
        },
        success: (res) => {

        },
        error: (error) => {

        }
    });
});
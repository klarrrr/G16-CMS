const defaultTitle = 'Article Default Title';
const defaultContent = '<p>Your article content journey starts here...</p>';
const defaultShortDesc = 'Your short description is here...';

const canvas = document.getElementById('editor');
const contentBox = canvas.firstChild;

function createArticle() {
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
            console.log("Create Article Error :" + error);
        }
    });
}

createArticle();

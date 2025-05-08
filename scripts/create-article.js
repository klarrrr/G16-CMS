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
            // const article = res.article;
            // const widget = res.widget;

            // console.log(article);
            // console.log(widget);

            // All About titles
            // const topTitle = document.getElementById('top-article-title');
            // const titleBox = document.getElementById('title-box');

            // const shortDescBox = document.getElementById('short-desc-box');

            // Do the image later
            // Do the Tags later

            // Content box is already declared

            // Assigning of response data to elements

            // topTitle.textContent = article.article_title;
            // titleBox.value = article.article_title;
            // shortDescBox.value = widget.widget_paragraph;

            // contentBox.innerHTML = article.article_content;
        },
        error: (error) => {
            console.log("Create Article Error :" + error);
        }
    });
}

createArticle();

// // MUtation

// // Options for the observer (which mutations to observe)
// const config = { childList: true, subtree: true };

// // Callback function to execute when mutations are observed
// const callback = function (mutationsList, observer) {
//     for (let mutation of mutationsList) {
//         if (mutation.type === 'childList') {
//             console.log(contentBox.innerHTML);
//         }
//     }
// };

// // Create an instance of MutationObserver with the callback
// const observer = new MutationObserver(callback);

// // Start observing the target node for configured mutations
// observer.observe(contentBox, config);


// TODO: LATER live update

// contentBox.addEventListener('keydown', () => {
//     console.log(contentBox.innerHTML);
// });



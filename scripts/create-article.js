const defaultTitle = 'Article Default Title';
const defaultContent = 'You\'re article content journey starts here...';
const defaultShortDesc = 'You\'re short description is here...';

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

        }
    });
}

// Live Saving of Article

// Options for the observer (which mutations to observe)
const config = { childList: true, subtree: true };

// Callback function to execute when mutations are observed
const callback = function (mutationsList, observer) {
    for (let mutation of mutationsList) {
        if (mutation.type === 'childList') {
            console.log(contentBox.innerHTML);
        }
    }
};

// Create an instance of MutationObserver with the callback
const observer = new MutationObserver(callback);

// Start observing the target node for configured mutations
observer.observe(contentBox, config);



const addArticleBtn = document.getElementById('add-article-page-btn');
const floatCardsContainer = document.querySelector('.float-cards');

// Add Page 
addArticleBtn.addEventListener('click', () => {
    if (floatCardsContainer.style.display == 'none') {
        floatCardsContainer.style.display = 'flex';
        floatCardsContainer.style.justifyContent = 'center';
        floatCardsContainer.style.alignItems = 'center';
        floatCardsContainer.style.width = '100vw';
        floatCardsContainer.style.height = '100vh';
        floatCardsContainer.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        floatCardsContainer.style.position = 'absolute';

        const actualContainer = document.createElement('div');

        actualContainer.id = 'add-article-page-container';
        actualContainer.style.display = 'flex';
        actualContainer.style.flexDirection = 'column';
        actualContainer.style.backgroundColor = 'white';
        actualContainer.style.borderRadius = '3px';
        actualContainer.style.width = '50%';
        actualContainer.style.height = '50%';
        actualContainer.style.padding = '30px';

        const closeButton = document.createElement('span');
        closeButton.textContent = '+';
        closeButton.style.fontSize = '1.5em';
        closeButton.style.fontWeight = '600';
        closeButton.style.display = 'inline-block';
        closeButton.style.transform = 'rotate(45deg)';
        closeButton.style.alignSelf = 'flex-end';
        closeButton.style.justifySelf = 'flex-end';
        closeButton.style.cursor = 'pointer';

        closeButton.addEventListener('click', () => {
            closeAddArticleContainer();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key == 'Escape' && floatCardsContainer.style.display != 'none') {
                closeAddArticleContainer();
            }
        });

        // Append Elements to Actual Container before preprending to floatcardscontainer

        floatCardsContainer.prepend(actualContainer);
    }

    function closeAddArticleContainer() {
        floatCardsContainer.style.display = 'none';
        floatCardsContainer.innerHTML = '';
    }


});
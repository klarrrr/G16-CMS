const widgetOpenBtn = document.getElementById('open-widget');
const createArticleMain = document.getElementById('create-article-main');

widgetOpenBtn.addEventListener('click', () => {
    if (createArticleMain.style.gridTemplateColumns == '99% 1%') {
        widgetOpenBtn.textContent = '》 Hide Comment Box'
        createArticleMain.style.gridTemplateColumns = '75% 25%';
    } else {
        widgetOpenBtn.textContent = '《 Show Comment Box'
        createArticleMain.style.gridTemplateColumns = '99% 1%';
    }

});
const menuBurgir = document.getElementById('menuButton');
const menu = document.getElementById('off-screen-menu');

const mainNavItems = document.getElementById('main-nav-items');
const menuAccoutItems = document.getElementById('menu-account-items');

const menuButtonContainer = document.getElementById('menu-button-container');

const home = document.getElementById('menu-home-button');
const archive = document.getElementById('menu-archive-button');
const addArticle = document.getElementById('add-article-nav-button')
const reviewArticleBtnP = document.getElementById('review-articles-button-p');
const lundayanHome = document.getElementById('lundayan-home-button');
const auditLog = document.getElementById('menu-audit-logs-button');

const accountSettings = document.getElementById('menu-account-settings-button');
const signOut = document.getElementById('menu-sign-out-button');

const pArray = [home, archive, auditLog, reviewArticleBtnP, addArticle, lundayanHome,
    accountSettings, signOut, document.getElementById('menu-inbox-button')
];

const mainPage = document.getElementById('main-page');

const previewSiteBox = document.getElementById('preview-site-box');
const secondNav = document.getElementById('second-nav');

const body = document.querySelector('body');

menuBurgir.addEventListener('click', () => {
    if (body.style.gridTemplateColumns == '15% 85%') {
        // Collapsed state
        body.style.gridTemplateColumns = '4% 96%';
        menu.style.alignItems = 'center';
        menuButtonContainer.style.justifyContent = 'center';
        mainNavItems.style.alignContent = 'center';
        menuAccoutItems.style.alignContent = 'center';

        pArray.forEach(element => {
            if (element != null) {
                element.style.display = 'none';
                element.style.width = '100%';
            }
        });

        // Hide notification badge in collapsed state
        const badge = document.getElementById('inbox-notification');
        if (badge) badge.style.display = 'none';
    } else {
        // Expanded state
        body.style.gridTemplateColumns = '15% 85%';
        menu.style.alignItems = 'start';
        menuButtonContainer.style.justifyContent = 'flex-start';
        mainNavItems.style.alignContent = 'flex-start';
        menuAccoutItems.style.alignContent = 'flex-start';

        pArray.forEach(element => {
            if (element != null) {
                element.style.display = 'block';
                element.style.width = 'auto';
            }
        });

        // Show notification badge if there are notifications
        const badge = document.getElementById('inbox-notification');
        if (badge && badge.textContent !== '0') {
            badge.style.display = 'flex';
        }
    }
});
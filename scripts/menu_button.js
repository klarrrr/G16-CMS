const menuBurgir = document.getElementById('menuButton');
const menu = document.getElementById('off-screen-menu');

const mainNavItems = document.getElementById('main-nav-items');
const menuAccoutItems = document.getElementById('menu-account-items');

const menuButtonContainer = document.getElementById('menu-button-container');

const home = document.getElementById('menu-home-button');
const archive = document.getElementById('menu-archive-button');

const accountSettings = document.getElementById('menu-account-settings-button');
const signOut = document.getElementById('menu-sign-out-button');

const pArray = [home, archive, accountSettings, signOut];

const mainPage = document.getElementById('main-page');

const previewSiteBox = document.getElementById('preview-site-box');
const secondNav = document.getElementById('second-nav');

menuBurgir.addEventListener('click', () => {
    if (menu.style.width == '4vw') {
        menu.style.width = 'auto';
        menu.style.alignItems = 'start';

        menuButtonContainer.style.justifyContent = 'flex-start';

        mainNavItems.style.alignContent = 'flex-start';
        menuAccoutItems.style.alignContent = 'flex-start';

        pArray.forEach(element => {
            element.style.display = 'block';
            element.style.width = 'auto';
        });

        secondNav.style.width = '90%';
        previewBox.style.width = '84%';

    } else {
        menu.style.width = '4vw';
        menu.style.alignItems = 'center';

        menuButtonContainer.style.justifyContent = 'center';

        mainNavItems.style.alignContent = 'center';
        menuAccoutItems.style.alignContent = 'center';

        pArray.forEach(element => {
            element.style.display = 'none';
            element.style.width = '100%';
        });

        secondNav.style.width = '96%';
        previewBox.style.width = '96%';
    }
});
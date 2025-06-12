<?php

$user_type = $_SESSION['user_type'];
$profile_pic = $_SESSION['profile_picture'];

?>

<div class="sure-delete-container" style="display: none;" id="sure-sign-out">
    <div class="sure-delete">
        <h3 id="confirm-message">Sign out?</h3>
        <div class="delete-button-container">
            <button id="so_yes">Confirm</button>
            <button id="so_no">Cancel</button>
        </div>
    </div>
</div>

<div class="top-screen-menu">
    <div class="burger" id="burger">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="nav-page-title">
        <h1 id='h1-title'>Articles</h1>
        <p id='p-title'>Recent Articles</p>
    </div>
    <div class="pfp-container">
        <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : $profile_pic; ?>" alt="" id='pfp-circle'>
    </div>
</div>

<div class="off-screen-menu" id='off-screen-menu' style='align-items: center;'>
    <div id='menu-button-container' style='justify-content: center;'>
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" id="menuButton">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id='menu-button-path' />
        </svg>
    </div>
    <ul id='main-nav-items'>
        <!-- DASHBOARD -->
        <li>
            <a href="editor-dashboard.php">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0L0 6V8H1V15H4V10H7V15H15V8H16V6L14 4.5V1H11V2.25L8 0ZM9 10H12V13H9V10Z" fill="#000000" />
                </svg>
                <p id='menu-home-button' style='display: none'>Home</p>
            </a>
        </li>
        <!-- ARTICLES -->
        <li id='add-article-icon'>
            <a href="add-article-page.php">
                <svg fill="#000000" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2,9H9V2H2Zm9-7V9h7V2ZM2,18H9V11H2Zm9,0h7V11H11Z" />
                </svg>
                <p id='add-article-nav-button' style='display: none'>Articles</p>
            </a>
        </li>
        <!-- REVIEW ARTICLES -->
        <li id='review-article-icon'>
            <a href="for-review-article-page.php">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 1H4V11H8L10 13L12 11H16V1Z" fill="#000000" />
                    <path d="M2 5V13H7.17157L8.70711 14.5355L7.29289 15.9497L6.34315 15H0V5H2Z" fill="#000000" />
                </svg>
                <p id='review-articles-button-p' style='display: none'>Review Articles</p>
            </a>
        </li>
        <!-- INBOX FOR REVIEWERS -->
        <li id='inbox-icon'>
            <a href="inbox-page.php">
                <svg fill="#161616" viewBox="0 0 512 512" id="_32_Inbox" data-name="32 Inbox" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path id="Path_42" data-name="Path 42" d="M480,0H32A31.981,31.981,0,0,0,0,32V480a31.981,31.981,0,0,0,32,32H480a31.981,31.981,0,0,0,32-32V32A31.981,31.981,0,0,0,480,0ZM448,352H352v96H160V352H64V64H448Z" fill-rule="evenodd"></path>
                        <rect id="Rectangle_33" data-name="Rectangle 33" width="256" height="64" transform="translate(128 224)"></rect>
                        <rect id="Rectangle_34" data-name="Rectangle 34" width="256" height="64" transform="translate(128 128)"></rect>
                    </g>
                </svg>
                <p id='menu-inbox-button' style='display: none'>Inbox</p>
                <span class="notification-badge" id="inbox-notification" style="display: none">0</span>
            </a>
        </li>
        <!-- ARTICLE ARCHIVES PAGE -->
        <li id='article-archives-hide'>
            <a href="article-archives-page.php">
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2H0V5H16V2Z" fill="#000000" />
                    <path d="M1 7H5V9H11V7H15V15H1V7Z" fill="#000000" />
                </svg>
                <p id='menu-archive-button' style='display: none'>Article Archives</p>
            </a>
        </li>
        <!-- HOME LUNDAYAN SITE -->
        <li>
            <a href="index.php">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--emojione-monotone" preserveAspectRatio="xMidYMid meet">
                    <path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30s30-13.432 30-30S48.568 2 32 2zm11.275 44.508h-20.55V17.492h6.063v23.799h14.488v5.217z" fill="#000000"></path>
                </svg>
                <p id='lundayan-home-button' style='display: none'>Lundayan Home</p>
            </a>
        </li>
    </ul>
    <ul id='menu-account-items'>
        <!-- ACCOUNT SETTINGS -->
        <li>
            <a href="account-settings.php">
                <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <title>Account Settings</title>
                    <path d="M9.6,3.32a3.86,3.86,0,1,0,3.86,3.85A3.85,3.85,0,0,0,9.6,3.32M16.35,11a.26.26,0,0,0-.25.21l-.18,1.27a4.63,4.63,0,0,0-.82.45l-1.2-.48a.3.3,0,0,0-.3.13l-1,1.66a.24.24,0,0,0,.06.31l1,.79a3.94,3.94,0,0,0,0,1l-1,.79a.23.23,0,0,0-.06.3l1,1.67c.06.13.19.13.3.13l1.2-.49a3.85,3.85,0,0,0,.82.46l.18,1.27a.24.24,0,0,0,.25.2h1.93a.24.24,0,0,0,.23-.2l.18-1.27a5,5,0,0,0,.81-.46l1.19.49c.12,0,.25,0,.32-.13l1-1.67a.23.23,0,0,0-.06-.3l-1-.79a4,4,0,0,0,0-.49,2.67,2.67,0,0,0,0-.48l1-.79a.25.25,0,0,0,.06-.31l-1-1.66c-.06-.13-.19-.13-.31-.13L19.5,13a4.07,4.07,0,0,0-.82-.45l-.18-1.27a.23.23,0,0,0-.22-.21H16.46M9.71,13C5.45,13,2,14.7,2,16.83v1.92h9.33a6.65,6.65,0,0,1,0-5.69A13.56,13.56,0,0,0,9.71,13m7.6,1.43a1.45,1.45,0,1,1,0,2.89,1.45,1.45,0,0,1,0-2.89Z" />
                </svg>
                <p id='menu-account-settings-button' style='display: none'>Account Settings</p>
            </a>
        </li>
        <!-- SIGN OUT -->
        <li>
            <a href="#" id='sign-out-btn'>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 3C4.34315 3 3 4.34315 3 6V18C3 19.6569 4.34315 21 6 21H17C17.5523 21 18 20.5523 18 20C18 19.4477 17.5523 19 17 19H6C5.44772 19 5 18.5523 5 18V6C5 5.44772 5.44772 5 6 5H17C17.5523 5 18 4.55228 18 4C18 3.44772 17.5523 3 17 3H6ZM15.7071 7.29289C15.3166 6.90237 14.6834 6.90237 14.2929 7.29289C13.9024 7.68342 13.9024 8.31658 14.2929 8.70711L16.5858 11H8C7.44772 11 7 11.4477 7 12C7 12.5523 7.44772 13 8 13H16.5858L14.2929 15.2929C13.9024 15.6834 13.9024 16.3166 14.2929 16.7071C14.6834 17.0976 15.3166 17.0976 15.7071 16.7071L19.7071 12.7071C20.0976 12.3166 20.0976 11.6834 19.7071 11.2929L15.7071 7.29289Z" fill="#000000" />
                </svg>
                <p id='menu-sign-out-button' style='display: none'>Sign Out</p>
            </a>
        </li>
    </ul>
</div>

<script>
    const userType = "<?php echo strtolower($user_type); ?>";
    const addArticleIcon = document.getElementById('add-article-icon');
    const reviewArticleIcon = document.getElementById('review-article-icon');
    const articleArchives = document.getElementById('article-archives-hide');
    const inboxIcon = document.getElementById('inbox-icon');

    if (userType == 'writer') {
        reviewArticleIcon.remove();
        inboxIcon.remove();
    } else if (userType == 'reviewer') {
        addArticleIcon.remove();
        articleArchives.remove();
        // Show inbox for reviewers
    } else if (userType == 'admin') {
        // Show everything for admin
    }
</script>

<script>
    const signOutBtn = document.getElementById('sign-out-btn');
    const sureContainer = document.getElementById('sure-sign-out');
    const soYes = document.getElementById('so_yes');
    const soNo = document.getElementById('so_no');

    signOutBtn.addEventListener('click', () => {
        sureContainer.style.display = 'flex';
    });

    soYes.addEventListener('click', () => {
        window.location.href = 'php-backend/sign-out.php';
        sureContainer.style.display = 'none';
    });

    soNo.addEventListener('click', () => {
        sureContainer.style.display = 'none';
    });

    // Burger menu toggle
    const burger = document.getElementById('burger');
    const navContainer = document.getElementById('off-screen-menu');

    burger.addEventListener('click', () => {
        navContainer.classList.toggle('show');
    });

    const pfpCircle = document.getElementById('pfp-circle');
    pfpCircle.addEventListener('click', () => {
        window.location.href = 'account-settings.php';
    });

    const h1Title = document.getElementById('h1-title');
    const pTitle = document.getElementById('p-title');

    if (openPage == 'add-article') {
        h1Title.innerHTML = "Articles";
        pTitle.innerHTML = "Owned Articles";
    } else if (openPage == 'archives') {
        h1Title.innerHTML = "Article Archives";
        pTitle.innerHTML = "Old Articles";
    } else if (openPage == 'for-review-articles') {
        h1Title.innerHTML = "Articles";
        pTitle.innerHTML = "Review Articles";
    } else if (openPage == 'inbox') {
        h1Title.innerHTML = "Inbox";
        pTitle.innerHTML = "Invitations";
    } else if (openPage == 'review-article') {
        h1Title.innerHTML = "Review Article";
        pTitle.innerHTML = "Leave Comments";
    } else if (openPage == 'edit-article') {
        h1Title.innerHTML = "Edit Article";
        pTitle.innerHTML = "Modify your Posts";
    }
</script>
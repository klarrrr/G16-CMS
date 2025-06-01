<?php

$user_type = $_SESSION['user_type'];
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

<div class="off-screen-menu" id='off-screen-menu' style='align-items: center;'>
    <div id='menu-button-container'>
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" id="menuButton">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id='menu-button-path' />
        </svg>
    </div>
    <div class="nav-items-container">
        <ul id='admin-nav-items'>
            <!-- DASHBOARD -->
            <li>
                <a href="admin-dashboard.php">
                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0L0 6V8H1V15H4V10H7V15H15V8H16V6L14 4.5V1H11V2.25L8 0ZM9 10H12V13H9V10Z" fill="#000000" />
                    </svg>
                    <p style='display: none'>Dashboard</p>
                </a>
            </li>

            <!-- INBOX -->
            <li>
                <a href="admin-inbox.php">
                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4C2.897 4 2 4.897 2 6V18C2 19.103 2.897 20 4 20H20C21.103 20 22 19.103 22 18V6C22 4.897 21.103 4 20 4zM20 6L12 13L4 6H20zM4 18V8L12 15L20 8V18H4z"/>
                    </svg>
                    <p style='display: none'>Inbox</p>
                </a>
            </li>

            <!-- MANAGE USERS -->
            <li>
                <a href="admin-manage-users.php">
                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 11C18.761 11 21 8.761 21 6C21 3.239 18.761 1 16 1C13.239 1 11 3.239 11 6C11 8.761 13.239 11 16 11zM8 11C10.761 11 13 8.761 13 6C13 3.239 10.761 1 8 1C5.239 1 3 3.239 3 6C3 8.761 5.239 11 8 11zM8 13C5.33 13 0 14.34 0 17V21H16V17C16 14.34 10.67 13 8 13zM18 13C17.676 13 17.337 13.017 17 13.045C18.215 14.051 19 15.444 19 17V21H24V17C24 14.34 20.418 13 18 13z"/>
                    </svg>
                    <p style='display: none'>Manage Users</p>
                </a>
            </li>

            <!-- AUDIT LOG -->
            <li>
                <a href="admin-audit-logs.php">
                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3V21H21V3H3ZM19 19H5V5H19V19ZM7 7H17V9H7V7ZM7 11H17V13H7V11ZM7 15H13V17H7V15Z"/>
                    </svg>
                    <p style='display: none'>Audit Log</p>
                </a>
            </li>

            <!-- SITE SETTINGS -->
            <li>
                <a href="admin-settings.php">
                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 8C10.897 8 10 8.897 10 10C10 11.103 10.897 12 12 12C13.103 12 14 11.103 14 10C14 8.897 13.103 8 12 8zM4 10C2.897 10 2 10.897 2 12C2 13.103 2.897 14 4 14C5.103 14 6 13.103 6 12C6 10.897 5.103 10 4 10zM20 10C18.897 10 18 10.897 18 12C18 13.103 18.897 14 20 14C21.103 14 22 13.103 22 12C22 10.897 21.103 10 20 10z"/>
                    </svg>
                    <p style='display: none'>Site Settings</p>
                </a>
            </li>

            <!-- LUNDAYAN HOMEPAGE -->
            <li>
                <a href="lundayan-site-home.php">
                    <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                        <path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30s30-13.432 30-30S48.568 2 32 2zm11.275 44.508h-20.55V17.492h6.063v23.799h14.488v5.217z" fill="#000000"/>
                    </svg>
                    <p style='display: none'>Lundayan Site</p>
                </a>
            </li>
        </ul>

        <!-- LOGOUT - MOVED TO BOTTOM -->
        <ul class="bottom-nav-items">
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
</div>

<script>
        const signOutBtn = document.getElementById('sign-out-btn');
        const sureContainer = document.getElementById('sure-sign-out');
        const soYes = document.getElementById('so_yes');
        const soNo = document.getElementById('so_no');

        signOutBtn.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent the default link behavior
            sureContainer.style.display = 'flex';
        });

        soYes.addEventListener('click', () => {
            window.location.href = 'php-backend/sign-out.php';
            sureContainer.style.display = 'none';
        });

        soNo.addEventListener('click', () => {
            sureContainer.style.display = 'none';
        });
</script>
document.addEventListener('DOMContentLoaded', function () {
    const menuBurgir = document.getElementById('menuButton');
    const menu = document.getElementById('off-screen-menu');
    const adminNavItems = document.getElementById('admin-nav-items');
    const body = document.body;
    const leftSidebar = document.querySelector('.left-editor-container');

    // Get ALL <p> tags inside both nav sections
    const pArray = Array.from(document.querySelectorAll('#admin-nav-items p, .bottom-nav-items p'));

    function initializeSidebar() {
        leftSidebar.style.width = '70px';

        pArray.forEach(element => {
            element.style.display = 'none';
        });

        adminNavItems.querySelectorAll('li').forEach(li => {
            li.style.justifyContent = 'center';
        });

        body.classList.add('sidebar-closed');
    }

    function openSidebar() {
        leftSidebar.style.width = '250px';

        pArray.forEach(element => {
            element.style.display = 'block';
        });

        adminNavItems.querySelectorAll('li').forEach(li => {
            li.style.justifyContent = 'flex-start';
        });

        body.classList.remove('sidebar-closed');
    }

    function toggleSidebar() {
        if (body.classList.contains('sidebar-closed')) {
            openSidebar();
        } else {
            initializeSidebar();
        }
    }

    initializeSidebar(); // Start collapsed
    menuBurgir.addEventListener('click', toggleSidebar);
});

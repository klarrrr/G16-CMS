const selectionBox = document.getElementById('select-pages');

$.ajax({
    type: "POST",
    url: '../php-backend/populate_selection_page.php',
    dataType: 'json',
    data: {},
    success: function (obj) {
        if (!('error' in obj)) {
            const pages = obj.result;

            pages.forEach(page => {
                const opt = document.createElement('option');
                opt.value = page.page_id;
                opt.name = page.page_name;
                let pageName = page.page_name;
                let capitalizedPageName = capitalizeFirstLetter(String(pageName).toLowerCase());
                opt.innerHTML = capitalizedPageName;
                console.log(opt);
                selectionBox.appendChild(opt);
            });

            // Waited until AJAX success and options are added:
            if (selectionBox.options.length > 0) {
                selectionBox.value = selectionBox.options[0].value;
                selectionBox.dispatchEvent(new Event('change')); // ✅ trigger change
            }
        } else {
            console.log(obj.error);
        }
    },
    error: function (xhr, status, error) {
        console.log('AJAX error:', error);
    }
});

function capitalizeFirstLetter(str) {
    if (!str) return str;
    return str.charAt(0).toUpperCase() + str.slice(1);
}
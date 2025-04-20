const selectBox = document.getElementById('select-pages');
selectBox.onchange = (event) => {
    // Pass this
    const page_id = selectBox.value;
    $.ajax({
        type: "POST",
        url: '../php-backend/get_elements_and_preview_page.php',
        dataType: 'json',
        data: { functionname: 'add' },
        success: function (obj) {
            if (!('error' in obj)) {
                const elements = obj.result;

                elements.forEach(page => {
                    // Build Layout for Edit Current Page Details
                });

                elements.forEach(page => {
                    // Build Layout for Preview Site
                });
            } else {
                console.log(obj.error);
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX error:', error);
        }
    });
}
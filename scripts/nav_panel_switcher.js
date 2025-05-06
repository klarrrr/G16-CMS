$(document).ready(function () {
    // When "Fonts" is clicked
    $('#nav-fonts').on('click', function (e) {
        e.preventDefault();
        $('#edit-details-box').hide();
        $('#color-settings-box').hide();
        $('#font-settings-box').show();
    });

    // When "Colors" is clicked
    $('#nav-colors').on('click', function (e) {
        e.preventDefault();
        $('#edit-details-box').hide();
        $('#font-settings-box').hide();
        $('#color-settings-box').show();
    });

    // When "Pages" is clicked — this should show edit details again
    $('#nav-pages').on('click', function (e) {
        e.preventDefault();
        $('#font-settings-box').hide();
        $('#color-settings-box').hide();
        $('#edit-details-box').show();
    });
});

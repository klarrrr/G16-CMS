$.ajax({
    url: 'php-backend/get-article-type.php',
    method: 'POST',
    dataType: 'json',
    data: {
        article_id: article_id
    },
    success: function (res) {
        if (res.status === 'success') {
            $('#article-type').val(res.article_type);
        } else {
            console.error('Failed to load type:', res.message);
        }
    },
    error: function (err) {
        console.error('AJAX error:', err);
    }
});
document.getElementById('article-type').addEventListener('change', function () {
    const articleType = this.value;

    if (!['regular', 'announcement'].includes(articleType)) {
        alert("Invalid type selected.");
        return;
    }

    fetch('php-backend/update-article-type.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `article_id=${article_id}&article_type=${articleType}`
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Article type updated to:', articleType);
            } else {
                console.error('Update failed:', data.message);
                alert('Error: ' + data.message);
            }
        })
        .catch(err => {
            console.error('Request failed:', err);
            alert('AJAX error occurred.');
        });
});
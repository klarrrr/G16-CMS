const thumbnailImg = document.getElementById('thumbnail-image');
thumbnailImg.addEventListener('change', (event) => {
    if (window.updateTimeout) clearTimeout(window.updateTimeout);

    window.updateTimeout = setTimeout(() => {
        updateThumbnailImg(article_id, event);
    }, 500);
});

function updateThumbnailImg(article_id, event) {
    const warningLbl = document.getElementById('img-size-warning');
    const file = event.target.files[0];

    if (file) {
        // Optional: Check file size in bytes (e.g. 2MB = 2 * 1024 * 1024)
        if (file.size > 10 * 1024 * 1024) {
            console.log("Image file is too large: " + file.size);
            warningLbl.style.display = 'block';
            return;
        }

        const formData = new FormData();
        formData.append('image', file);
        formData.append('article_id', article_id);

        $.ajax({
            url: 'php-backend/edit-article-thumbnail-update.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: (res) => {
                console.log(res.status);
                if (res.status === 'success') {
                    const filePath = res.filePath;

                    document.getElementById('show-thumbnail-image').src = filePath;
                    document.getElementById('thumbnail-image-container').style.background = `url(${filePath})`;

                    updateDateUpdated(article_id, "Article thumbnail image updated");

                    warningLbl.style.display = 'none';
                } else {
                    console.log(res.message);
                }
            },
            error: (err) => {
                console.log(err);
            }
        });
    } else {
        console.log('No file selected.');
    }
}

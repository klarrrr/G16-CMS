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
        // Check file size (10MB max)
        if (file.size > 10 * 1024 * 1024) {
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
                if (res.status === 'success') {
                    const filePath = res.filePath;
                    const container = document.getElementById('thumbnail-image-container');

                    // Remove fallback emoji if present
                    container.innerHTML = '';

                    // Recreate <img> tag
                    const img = document.createElement('img');
                    img.id = 'show-thumbnail-image';
                    img.alt = 'Thumbnail Image';
                    img.src = filePath;
                    img.onerror = function () {
                        this.style.display = 'none';
                        container.innerHTML = '<div class="fallback-emoji">🖼️</div>';
                    };

                    container.appendChild(img);
                    container.style.background = `url(${filePath})`;

                    warningLbl.style.display = 'none';

                    updateDateUpdated(article_id, "Article thumbnail image updated");
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


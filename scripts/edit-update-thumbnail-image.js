const thumbnailImg = document.getElementById('thumbnail-image');
thumbnailImg.addEventListener('change', (event) => {
    // Debounce avoid flooding the server
    if (window.updateTimeout) clearTimeout(window.updateTimeout);

    window.updateTimeout = setTimeout(() => {
        updateThumbnailImg(article_id, event);
        // console.log(updatedContent);
    }, 500);
});

function updateThumbnailImg(article_id, event) {
    const warningLbl = document.getElementById('img-size-warning');
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const base64String = e.target.result.split(',')[1]; // Extract Base64 string
            if (base64String.length > 16777215) {
                // NO MORE THAN 16777215 chars
                console.log("Image size is too large : " + base64String.length);
                warningLbl.style.display = 'block';
            } else {
                // PWEDE basta less than 16777215 chars
                console.log("This is allowed : " + base64String.length)
                $.ajax({
                    url: 'php-backend/edit-article-thumbnail-update.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        base64String: base64String,
                        article_id: article_id
                    },
                    success: (res) => {
                        console.log(res.status);

                        document.getElementById('show-thumbnail-image').src = 'data:image/png;base64,' + base64String;
                        updateDateUpdated(article_id, "Article thumbnail image updated");

                        document.getElementById('thumbnail-image-container').style.background = `url(${'data:image/png;base64,' + base64String})`;

                        warningLbl.style.display = 'none';
                    },
                    error: (error) => {
                        console.log(error);
                    }
                });
            }
        };
        reader.readAsDataURL(file); // Read file as Data URL
    } else {
        console.log('No file selected.');
    }
}
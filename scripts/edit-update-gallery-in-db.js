const galleryInput = document.getElementById('image');
const galleryContainer = document.getElementById('image-gallery');

galleryInput.addEventListener('change', (event) => {
    // Debounce to avoid flooding the server with requests
    if (window.updateTimeout) clearTimeout(window.updateTimeout);

    window.updateTimeout = setTimeout(() => {
        updateGallery(event, article_id);
    }, 500);
});

function updateGallery(event, article_id) {
    const files = event.target.files; 
    const galleryContainer = document.getElementById('image-gallery');
    const warningLbl = document.getElementById('img-size-warning');


    if (files.length > 0) {
        Array.from(files).forEach(file => {
            const formData = new FormData(); 

            const filePath = `gallery/${file.name}`; 

            // Append the image file to FormData for upload
            formData.append('image_files[]', file);
            formData.append('article_id', article_id);
            formData.append('file_path', filePath);
            formData.append('user_owner', user_owner);

            // Show the selected image preview in the gallery
            const imgElement = document.createElement('img');
            imgElement.src = URL.createObjectURL(file); 
            galleryContainer.appendChild(imgElement);

            $.ajax({
                url: 'php-backend/edit-article-gallery-update.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: (res) => {
                    if (res.status === 'success') {
                        console.log('Image successfully uploaded and added to the gallery');
                        updateGalleryList(article_id);
                        updateDateUpdated(article_id, "Article gallery modified");
                    } else {
                        console.log('Error uploading image');
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        });
    }
}
function updateGalleryList(article_id) {
    $.ajax({
        url: 'php-backend/get-article-gallery.php',
        type: 'GET',
        dataType: 'json',
        data: { article_id: article_id },
        success: (res) => {
            galleryContainer.innerHTML = ''; // Always clear gallery first

            if (res.status === 'success' && Array.isArray(res.data)) {
                if (res.data.length === 0) {
                    // No images: show fallback message
                    const fallback = document.createElement('div');
                    fallback.className = 'fallback-emoji';
                    fallback.style.cssText = `
                        padding: 1rem;
                        color: rgb(85, 85, 85);
                        font-style: italic;
                        font-family: sub;
                        font-size: 0.8rem;
                    `;
                    fallback.innerHTML = "🖼️ This article does not have any gallery images yet. Maybe upload some?";
                    galleryContainer.appendChild(fallback);
                    return;
                }

                // Images exist: render them
                res.data.forEach(image => {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');
                    imgContainer.style.position = 'relative';
                    imgContainer.style.display = 'inline-block';

                    const imgElement = document.createElement('img');
                    imgElement.src = 'gallery/' + image.pic_path;
                    imgElement.alt = 'Gallery Image';
                    imgElement.setAttribute('data-pic-id', image.pic_id);

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'X';
                    deleteButton.classList.add('delete-btn');

                    imgContainer.appendChild(imgElement);
                    imgContainer.appendChild(deleteButton);
                    galleryContainer.appendChild(imgContainer);

                    deleteButton.addEventListener('click', () => {
                        const picId = imgElement.getAttribute('data-pic-id');
                        deleteImage(picId);
                    });
                });
            } else {
                console.log('Error: Gallery fetch returned bad status or data');
            }
        },
        error: (error) => {
            console.log('AJAX Error:', error);
        }
    });
}

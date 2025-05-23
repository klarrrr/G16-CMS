function updateGalleryList(article_id) {
    // Fetch the list of images for the specific article from the database
    $.ajax({
        url: 'php-backend/get-article-gallery.php',
        type: 'GET',
        dataType: 'json',
        data: {
            article_id: article_id
        },
        success: (res) => {
            if (res.status === 'success') {
                // Clear current gallery to prevent duplicate images
                galleryContainer.innerHTML = '';

                // Add new images to the gallery
                res.data.forEach(image => {
                    // Create a container for each image (for positioning the delete button)
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('image-container');
                    imgContainer.style.position = 'relative';
                    imgContainer.style.display = 'inline-block';

                    // Create the image element
                    const imgElement = document.createElement('img');
                    imgElement.src = 'gallery/' + image.pic_path;
                    imgElement.alt = 'Gallery Image';
                    imgElement.setAttribute('data-pic-id', image.pic_id); // Store the pic_id in the data attribute

                    // Create the delete button
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'X';
                    deleteButton.classList.add('delete-btn');

                    // Append the delete button to the image container
                    imgContainer.appendChild(imgElement);
                    imgContainer.appendChild(deleteButton);

                    // Add the image container to the gallery
                    galleryContainer.appendChild(imgContainer);

                    // Bind delete function to the delete button
                    deleteButton.addEventListener('click', () => {
                        const picId = imgElement.getAttribute('data-pic-id'); // Get the pic_id from the image's data attribute
                        deleteImage(picId); // Call the deleteImage function
                    });
                });
            } else {
                console.log('Error fetching gallery images');
            }
        },
        error: (error) => {
            console.log(error);
        }
    });

    updateGalleryList(article_id);
}
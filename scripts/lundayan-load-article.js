// AJAX request to fetch images for the given article_id
$.ajax({
    url: 'php-backend/get-article-site-gallery.php',
    type: 'GET',
    dataType: 'json',
    data: {
        article_id: articleId // Pass article_id to the server
    },
    success: function (res) {
        if (res.status === 'success') {
            // Clear the gallery container to prevent duplicates
            galleryContainer.innerHTML = '';

            // Loop through the fetched images and display them
            res.data.forEach(function (image, index) {
                const imgElement = document.createElement('img');
                imgElement.src = 'gallery/' + image.pic_path; // the image is stored in the 'gallery' folder
                imgElement.alt = 'Gallery Image';
                imgElement.setAttribute('data-pic-id', image.pic_id); // Set pic_id as a data attribute

                const container = document.createElement('div');

                container.appendChild(imgElement);
                container.className = "gallery-image-container";

                // Append the image element to the gallery
                galleryContainer.appendChild(container);

                // Add the 'show' class with a slight delay for staggered effect
                setTimeout(() => {
                    container.classList.add('show');
                }, index * 100); // Delay each image slightly (100ms for each image)
            });
        } else {
            console.log('Error fetching gallery images');
        }
    },
    error: function (error) {
        console.log('Error during the request:', error);
    }
});
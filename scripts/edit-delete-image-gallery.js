// Delete imAgee
function deleteImage(pic_id) {
    $.ajax({
        url: 'php-backend/delete-article-gallery.php',
        type: 'POST',
        dataType: 'json',
        data: {
            pic_id: pic_id
        },
        success: (res) => {
            if (res.status == 'success') {
                console.log('Image deleted successfully');
                // Refresh the gallery after deletion
                updateGalleryList(article_id);
                updateDateUpdated(article_id, "Article gallery image deleted");
            } else {
                console.log('Error deleting image:', res.message || res.status);
            }
        },
        error: (error) => {
            console.log('Error during the request:', error);
        }
    });
}
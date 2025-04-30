function uploadImageFile(element_id, file) {
    const formData = new FormData();
    formData.append('image', file);
    formData.append('element_id', element_id);

    $.ajax({
        url: '../php-backend/upload_image.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            let json;
            try {
                json = typeof response === "string" ? JSON.parse(response) : response;
            } catch (e) {
                console.error('Invalid JSON from server:', response);
                return;
            }

            if (json.success) {
                console.log('Image uploaded:', json.filename);

                // 1. Update hidden input
                const hiddenInput = document.querySelector(
                    `input.hidden-image-path[data-element-id="${element_id}"]`
                );
                if (hiddenInput) {
                    hiddenInput.value = json.filename;
                }

                // 2. Update preview
                updatePreviewElement(element_id, 'image', json.filename);

                // 3. Save filename to DB
                $.ajax({
                    url: '../php-backend/update_element_content.php',
                    type: 'POST',
                    data: {
                        element_id: element_id,
                        new_content: json.filename,
                    },
                    success: function (saveResp) {
                        console.log('Saved filename to DB:', saveResp);
                    },
                    error: function (err) {
                        console.error('Failed to save filename to DB:', err);
                    }
                });
            } else {
                console.error('Upload error:', json.error);
            }
        },
        error: function (err) {
            console.error('Upload failed:', err);
        }
    });
}

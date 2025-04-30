function attachLiveUpdateListeners() {
    const inputs = editDetailsBox.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const elementId = e.target.getAttribute('data-element-id');
            const elementType = e.target.getAttribute('data-element-type');

            let newValue;

            if (elementType === 'image') {
                // Get value from hidden input
                const hiddenInput = document.querySelector(
                    `input.hidden-image-path[data-element-id="${elementId}"]`
                );
                newValue = hiddenInput ? hiddenInput.value : '';
            } else {
                newValue = e.target.value;
            }

            // 1. Update the preview
            updatePreviewElement(elementId, elementType, newValue);

            // 2. Send AJAX to update DB
            updateElementContentInDB(elementId, newValue);
        });
    });
}

function updatePreviewElement(elementId, elementType, newValue) {
    const previewEl = previewBox.querySelector(`[data-element-id="${elementId}"]`);
    if (previewEl && (elementType == 'title' || elementType == 'paragraph')) {
        previewEl.textContent = newValue;
    } else if (previewEl && (elementType == 'image')) {
        previewEl.src = '../upload-images/' + newValue;
        console.log(newValue)
    }
}

function updateElementContentInDB(elementId, newValue) {
    $.ajax({
        type: "POST",
        url: '../php-backend/update_element_content.php',
        data: {
            element_id: elementId,
            new_content: newValue
        },
        success: function (res) {
            console.log(`Updated element ${elementId} in DB`, res);
        },
        error: function (xhr, status, error) {
            console.error('Failed to update content:', error);
        }
    });
}

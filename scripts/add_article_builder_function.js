function buildEditDetails(elements) {
    const sectionWrapper = document.createElement('div');
    sectionWrapper.className = 'section-edit-wrapper';

    const sectionTitle = document.createElement('h3');
    sectionTitle.textContent = 'Article';
    sectionWrapper.appendChild(sectionTitle);

    elements.forEach(element => {
        const parsedContent = JSON.parse(element.content);
        const elementWrapper = document.createElement('div');
        elementWrapper.className = 'element-edit-group';

        // Label for the field
        const label = document.createElement('label');
        label.textContent = element.element_name;
        label.setAttribute('for', `element-${element.element_id}`);
        elementWrapper.appendChild(label);

        // Input or Textarea depending on element type
        let inputField;

        if (element.element_type === 'paragraph') {
            inputField = document.createElement('textarea');
        } else if (element.element_type === 'title') {
            inputField = document.createElement('input');
            inputField.type = 'text';
        } else if (element.element_type === 'image') {
            // File input
            inputField = document.createElement('input');
            inputField.type = 'file';
            inputField.accept = 'image/png, image/gif, image/jpeg';

            // Hidden input to store current image path
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.value = parsedContent.content;
            hiddenField.setAttribute('data-element-id', element.element_id);
            hiddenField.setAttribute('data-element-type', element.element_type);
            hiddenField.classList.add('hidden-image-path');

            // Image preview
            const imgPreview = document.createElement('img');
            imgPreview.src = '../upload-images/' + parsedContent.content;
            imgPreview.alt = element.element_name;
            imgPreview.style.maxWidth = '200px';
            imgPreview.style.display = 'block';
            imgPreview.style.marginTop = '10px';

            // Handle new file selection
            inputField.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (evt) {
                        imgPreview.src = evt.target.result; // Show preview
                    }
                    reader.readAsDataURL(file);

                    // You can now send the file to the server via AJAX + FormData
                    uploadImageFile(element.element_id, file);
                }
            });

            elementWrapper.appendChild(inputField);
            elementWrapper.appendChild(hiddenField);
            elementWrapper.appendChild(imgPreview);
        }

        if (element.element_type !== 'image') {
            inputField.value = parsedContent.content;
            if (element.element_type === 'paragraph') {
                inputField.rows = 25;
                inputField.style = 'resize: none; line-height: 1.5em;'
            }
        }
        inputField.id = `element-${element.element_id}`;
        inputField.setAttribute('data-element-id', element.element_id);
        inputField.setAttribute('data-element-type', element.element_type);

        elementWrapper.appendChild(inputField);
        sectionWrapper.appendChild(elementWrapper);
    });

    editDetailsBox.appendChild(sectionWrapper);

    attachLiveUpdateListeners();
}

function buildPreviewSite(elements) {
    const sectionDiv = document.createElement('div');
    sectionDiv.className = 'preview-section';
    sectionDiv.name = elements[0].section_owner;

    elements.forEach(element => {
        const parsedContent = JSON.parse(element.content);
        const el = document.createElement('div');
        el.className = 'element';

        let previewElement;

        // Conditionally render based on type
        if (element.element_type === 'title') {
            previewElement = document.createElement('h3');
        } else if (element.element_type === 'paragraph') {
            previewElement = document.createElement('p');
        } else if (element.element_type === 'button') {
            previewElement = document.createElement('button');
        } else if (element.element_type === 'sub') {
            previewElement = document.createElement('h4');
        } else if (element.element_type === 'image') {
            previewElement = document.createElement('img');
        }

        // Set content and identifiers
        if (previewElement && (element.element_type == 'image')) {
            previewElement.src = '../upload-images/' + parsedContent.content;
            previewElement.setAttribute('data-element-id', element.element_id);
            previewElement.setAttribute('data-element-type', element.element_type);
            el.appendChild(previewElement);
        }
        if (previewElement) {
            previewElement.textContent = parsedContent.content;
            previewElement.setAttribute('data-element-id', element.element_id);
            previewElement.setAttribute('data-element-type', element.element_type);
            el.appendChild(previewElement);
        }

        sectionDiv.appendChild(el);
    });

    previewBox.appendChild(sectionDiv);
}
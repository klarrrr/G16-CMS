const selectBox = document.getElementById('select-pages');
const previewBox = document.getElementById('preview-site-box');
let lastPageId = null;

selectBox.addEventListener('change', (event) => {
    const page_id = selectBox.value;
    loadEditDetails(page_id);

    if (page_id !== lastPageId) {
        lastPageId = page_id;
        loadPreview(page_id);
    }
})

function loadPreview(page_id) {
    $.ajax({
        type: "POST",
        url: '../php-backend/get_sections_and_elements.php',
        dataType: 'json',
        data: {
            page_id: page_id
        },
        success: function (obj) {
            if (!('error' in obj)) {
                const sections = obj.sections;
                const elements = obj.elements;

                // Clear the previous preview
                previewBox.innerHTML = '';

                // Build layout
                sections.forEach(section => {
                    const sectionDiv = document.createElement('div');
                    sectionDiv.className = 'preview-section';
                    sectionDiv.setAttribute('prev-section-id', section.section_id);
                    sectionDiv.name = section.section_id;

                    // Add Elements to this Section
                    elements.forEach(element => {
                        if (section.section_id == element.section_owner) {
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
                                previewElement.style.border = '1px solid lightgray';
                                previewElement.style.borderRadius = '3px';
                                el.appendChild(previewElement);
                            }
                            if (previewElement) {
                                previewElement.textContent = parsedContent.content;
                                previewElement.setAttribute('data-element-id', element.element_id);
                                previewElement.setAttribute('data-element-type', element.element_type);
                                el.appendChild(previewElement);
                            }

                            sectionDiv.appendChild(el);
                        }
                    });
                    // Add the completed section to the preview box
                    previewBox.appendChild(sectionDiv);
                });

            } else {
                console.log(obj.error);
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX error:', error);
        }
    });
}
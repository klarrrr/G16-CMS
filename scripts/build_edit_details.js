const editDetailsBox = document.getElementById('edit-details-box');

function loadEditDetails(page_id) {
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

                // Clear existing edit form
                editDetailsBox.innerHTML = '';

                sections.forEach(section => {
                    const sectionWrapper = document.createElement('div');
                    sectionWrapper.className = 'section-edit-wrapper';
                    sectionWrapper.setAttribute('edit-det-section-id', section.section_id);

                    const titleAndOptionsContainer = document.createElement('div');
                    titleAndOptionsContainer.style.display = 'flex';
                    titleAndOptionsContainer.style.flexDirection = 'row';
                    titleAndOptionsContainer.style.justifyContent = 'space-between';

                    const sectionTitle = document.createElement('h3');
                    sectionTitle.textContent = section.section_name;
                    titleAndOptionsContainer.appendChild(sectionTitle);

                    // More Options
                    const deleteBtn = document.createElement('img');
                    deleteBtn.src = '../svg/delete.svg';
                    deleteBtn.className = 'del-article-btn';
                    deleteBtn.style.width = '1.5em';
                    deleteBtn.style.cursor = 'pointer';
                    deleteBtn.style.backgroundColor = 'red';
                    deleteBtn.style.borderRadius = '3px';
                    deleteBtn.style.padding = '5px';
                    deleteBtn.style.transition = '0.2s ease-in-out'
                    deleteBtn.setAttribute('data-section-id', section.section_id);

                    deleteBtn.addEventListener('click', () => {
                        $.ajax({
                            type: 'POST',
                            url: '../php-backend/delete_article_page.php',
                            dataType: 'json',
                            data: {
                                section_id: section.section_id
                            },
                            success: function (res) {

                                const editDetSect = Array.from(document.querySelectorAll('*')).find(el =>
                                    el.getAttribute('edit-det-section-id') == section.section_id
                                );

                                editDetSect.remove();

                                const livePrevSect = Array.from(document.querySelectorAll('*')).find(el =>
                                    el.getAttribute('prev-section-id') == section.section_id
                                );

                                livePrevSect.remove();

                            },

                            error: function (error) {
                                console.log("Error on Adding Delete Event," + error);
                            }
                        });
                    });

                    titleAndOptionsContainer.appendChild(deleteBtn);

                    sectionWrapper.appendChild(titleAndOptionsContainer);

                    // Add Elements inside section
                    elements.forEach(element => {
                        if (element.section_owner === section.section_id) {
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

                        }
                    });

                    editDetailsBox.appendChild(sectionWrapper);
                });

                // Call after all fields are in DOM
                attachLiveUpdateListeners();
            } else {
                console.log(obj.error);
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX error:', error);
        }
    });
}

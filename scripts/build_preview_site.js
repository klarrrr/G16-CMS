const selectBox = document.getElementById('select-pages');
const previewBox = document.getElementById('preview-site-box');
let lastPageId = null;

selectBox.addEventListener('change', (event) => {
    const page_id = selectBox.value;

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
                    sectionDiv.name = section.section_id;

                    // Add Elements to this Section
                    elements.forEach(element => {
                        if (section.section_id == element.section_owner) {
                            const parsedContent = JSON.parse(element.content);
                            const el = document.createElement('div');
                            el.className = 'element';

                            // You can conditionally render based on type
                            if (element.element_type === 'title') {
                                const title = document.createElement('h3');
                                title.textContent = parsedContent.content;
                                el.appendChild(title);
                            } else if (element.element_type === 'paragraph') {
                                const p = document.createElement('p');
                                p.textContent = parsedContent.content;
                                el.appendChild(p);
                            } else if (element.element_type === 'button') {
                                const btn = document.createElement('button');
                                btn.textContent = parsedContent.content;
                                el.appendChild(btn);
                            } else if (element.element_type === 'sub') {
                                const sub = document.createElement('h4');
                                sub.textContent = parsedContent.content;
                                el.appendChild(sub);
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
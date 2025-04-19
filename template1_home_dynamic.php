    <div class='main_page'>
        <div class='hero'>
            <div>
                <h1>Welcome to Title Card</h1>
                <p>This is where your creativity begins!</p>
            </div>
            <button class='call_to_action_btn'>Get Started</button>
        </div>

        <div id='content'></div>
    </div>
    <script>
        const impSections = <?php echo json_encode($sectionsArray); ?>;
        const elements = <?php echo json_encode($elementsArray); ?>;
        const container = document.getElementById('content');

        for (const sectionId in impSections) {
            if (impSections.hasOwnProperty(sectionId)) {
                const section = impSections[sectionId]['section_name'];
                const sectionEl = document.createElement('section');

                // Find matching elements for this section
                let title = '';
                let paragraph = '';

                for (const elementId in elements) {
                    if (elements.hasOwnProperty(elementId)) {
                        const element = elements[elementId];

                        if (element.section_owner == sectionId) {
                            if (element.element_name === 'Title Text') {
                                title = JSON.parse(element.element_content).content;
                            } else if (element.element_name === 'Paragraph Text') {
                                paragraph = JSON.parse(element.element_content).content;
                            }
                        }
                    }
                }

                sectionEl.innerHTML = `
                    <h1>${title}</h1>
                    <p>${paragraph}</p>
                `;

                container.appendChild(sectionEl);
            }
        }
    </script>
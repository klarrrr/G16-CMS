<div class="main_page">
    <div id="content"></div>
</div>

<script>
    async function loadPageContent() {
        const res = await fetch('api/get_project_structure.php');
        const data = await res.json();

        const container = document.getElementById('content');
        container.innerHTML = ''; // Clear existing

        // Build sections dynamically
        const sectionMap = {};

        for (const section of data.sections) {
            const sectionEl = document.createElement('section');
            sectionEl.dataset.sectionId = section.section_id;
            sectionMap[section.section_id] = sectionEl;
            container.appendChild(sectionEl);
        }

        for (const el of data.elements) {
            const parentSection = sectionMap[el.section_owner];
            const content = JSON.parse(el.content).content;

            /*
            
            ADD THE ELEMENTS HERE IF YOU WANT TO UPDATE
            
            */

            if (el.element_type === "title") {
                const h1 = document.createElement('h1');
                h1.textContent = content;
                parentSection?.appendChild(h1);
            } else if (el.element_type === "paragraph") {
                const p = document.createElement('p');
                p.textContent = content;
                parentSection?.appendChild(p);
            } else if (el.element_type === "sub") {
                const h2 = document.createElement('h2');
                h2.textContent = content;
                parentSection?.appendChild(h2);
            } else if (el.element_type === "button") {
                const b = document.createElement('button');
                b.textContent = content;
                parentSection?.appendChild(b);
            } else if (el.element_type === "image") {
                const i = document.createElement('img');
                i.textContent = content;
                parentSection?.appendChild(i);
            }
        }
    }

    loadPageContent();
</script>
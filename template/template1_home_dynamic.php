<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include 'connect.php';

    $currentProject = 1;

    $queryDesign = "SELECT * FROM design_settings WHERE template_owner = $currentProject LIMIT 1";
    $resDesign = mysqli_query($conn, $queryDesign);
    $design = mysqli_fetch_assoc($resDesign);

    $styleBlock = "<style>
        body {
            font-family: {$design['font_family']};
            background-color: {$design['background_color']};
            color: {$design['text_color']};
        }
        h1, h2, h3 {
            color: {$design['heading_color']};
        }
        {$design['custom_css']}
        </style>";

    echo $styleBlock;
    ?>
</head>

<body>
    <div class="main_page">
        <div id="content"></div>
    </div>

    <script>
        async function loadPageContent() {
            const res = await fetch('api/get_project_structure.php');
            const data = await res.json();

            const container = document.getElementById('content');
            container.innerHTML = ''; // Clear existing

            const navContainer = document.createElement('div');
            navContainer.classList.add('nav-container'); // optional for styling

            const actualNav = document.createElement('nav');
            actualNav.classList.add('navbar'); // optional class

            const uList = document.createElement('ul');

            // Build a Navigation Bar here
            for (const nav of data.navigation) {
                const item = document.createElement('li');
                const link = document.createElement('a');

                link.textContent = nav['element_name'];
                link.href = "page_handler.php?page=${nav['page_slug']}";
                link.style = "color: black;";

                // You can add href based on slug if available
                // link.href = `page_handler.php?page=${nav['element_slug']}`;

                item.appendChild(link);
                uList.appendChild(item);
            }

            // Append the full nav structure
            actualNav.appendChild(uList);
            navContainer.appendChild(actualNav);

            // Finally, append to body
            // document.body.appendChild(navContainer);
            const mainPage = document.querySelector('.main_page');
            document.body.insertBefore(navContainer, mainPage);



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

            // Build a footer here
        }

        loadPageContent();
    </script>
</body>

</html>
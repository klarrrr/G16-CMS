
    <!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Template 1 : Home</title>
        <link rel='stylesheet' href='pages/styles/styles_template1_nav.css'>
        <link rel='stylesheet' href='pages/styles/styles_template1.css'>
    </head>

    <body>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav</title>
</head>

<body>
    <nav>
        <h1>BRAND AREA</h1>
        <ul>
            <!-- TODO : Make this dynamic -->
            <!-- For every pages in page array in PHP, add it to this -->
            <li><a href='template1_home_dynamic.php'>Home</a></li>
            <li><a href='pages/template1/template1_services.php'>Services</a></li>
            <li><a href='pages/template1/template1_contact.php'>Contact</a></li>
            <li><a href='pages/template1/template1_about.php'>About</a></li>
        </ul>
        <button class='call_to_action_btn'>Get Started</button>
    </nav>
</body>

</html><!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Impact;
            background-color: Blue;
            color: Red;
        }
        h1, h2, h3 {
            color: Yellow;
        }
        body{padding: 50px;}
        </style></head>

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
</body>

</html><footer>
    <div class="details">
        <h3>Brand Name</h3>
        <p>Copyright © All rights reserved</p>
        <p>Powered By <a href="contento.php">Contento</a> - <a href="contento.php">Create your own website</a></p>
    </div>
</footer>
</body>

</html>
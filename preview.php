
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
            <li><a href='template1_home.php'>Home</a></li>
            <li><a href='template1_services.php'>Services</a></li>
            <li><a href='template1_contact.php'>Contact</a></li>
            <li><a href='template1_about.php'>About</a></li>
        </ul>
        <button class='call_to_action_btn'>Get Started</button>
    </nav>
</body>

</html>    <div class='main_page'>
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
        const impSections = {"1":{"section_name":"section 1","page_owner":1},"2":{"section_name":"section 2","page_owner":1},"3":{"section_name":"section 3","page_owner":1}};
        const elements = {"1":{"element_name":"Title Text","element_content":"{\"content\":\"First Title Text2\"}","section_owner":1},"4":{"element_name":"Paragraph Text","element_content":"{\"content\":\"Second Paragraph Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, consectetur dolorum facilis esse porro sint unde modi accusamus quidem, quaerat doloribus, accusantium amet fugit? Odio autem a quos voluptatum quae.\"}","section_owner":1},"2":{"element_name":"Title Text","element_content":"{\"content\":\"Second Title Text\"}","section_owner":2},"5":{"element_name":"Paragraph Text","element_content":"{\"content\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, consectetur dolorum facilis esse porro sint unde modi accusamus quidem, quaerat doloribus, accusantium amet fugit? Odio autem a quos voluptatum quae.\"}","section_owner":2},"3":{"element_name":"Title Text","element_content":"{\"content\":\"Third Title Text\"}","section_owner":3},"6":{"element_name":"Paragraph Text","element_content":"{\"content\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae, consectetur dolorum facilis esse porro sint unde modi accusamus quidem, quaerat doloribus, accusantium amet fugit? Odio autem a quos voluptatum quae.\"}","section_owner":3}};
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
    </script><footer>
    <div class="details">
        <h3>Brand Name</h3>
        <p>Copyright © All rights reserved</p>
        <p>Powered By <a href="contento.php">Contento</a> - <a href="contento.php">Create your own website</a></p>
    </div>
</footer>
</body>

</html>
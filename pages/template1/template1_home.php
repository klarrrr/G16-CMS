<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template 1 : Home</title>
    <link rel="stylesheet" href="../styles/styles_template1.css">
</head>

<body>
    <?php include 'template1_nav.php' ?>
    <div class="main_page">
        <div class="hero">
            <div>
                <h1>Welcome to Title Card</h1>
                <p>This is where your creativity begins!</p>
            </div>
            <button class="call_to_action_btn">Get Started</button>
        </div>

        <div id="content">

        </div>
    </div>
    <?php include 'template1_footer.php' ?>

    <script>
        const container = document.getElementById('content');

        sections.forEach(sec => {
            const sectionEl = document.createElement('section');
            sectionEl.innerHTML = `
                <h1>${sec.title}</h1>
                <p>${sec.paragraph}</p>
            `;
            container.appendChild(sectionEl);
        });
    </script>

</body>

</html>
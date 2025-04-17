<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Template 1</title>
    <link rel="stylesheet" href="styles_template1.css">
</head>

<body>
    <nav>
        <p>BRAND AREA</p>
        <ul>
            <li>Home</li>
            <li>Services</li>
            <li>Contact</li>
            <li>About</li>
        </ul>
    </nav>

    <div class="hero">
        <h1>Welcome to Title Card</h1>
        <p>This is where your creativity begins!</p>
    </div>

    <div id="content">

    </div>

    <?php
    include 'connect.php';

    $jsonSections = [];

    // Fetch data for three sections
    for ($i = 1; $i <= 3; $i++) {
        $sql = "SELECT content FROM elements WHERE section_owner = '$i'";
        $result = mysqli_query($conn, $sql);
        $content = json_decode(mysqli_fetch_assoc($result)['content'] ?? '{}', true);

        $jsonSections[] = [
            'section' => $i,
            'title' => $content['title'] ?? '',
            'paragraph' => $content['paragraph'] ?? ''
        ];
    }

    echo "<script>const sections = " . json_encode($jsonSections) . ";</script>";
    ?>

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
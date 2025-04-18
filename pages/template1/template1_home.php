<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Template 1</title>
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


    <?php
    include '../../connect.php';

    $jsonSections = [];

    for ($i = 1; $i <= 3; $i++) {
        // Fetch title and paragraph for each section
        $sqlTitle = "SELECT content FROM elements WHERE section_owner = '$i' AND element_name = 'Title text'";
        $sqlPara = "SELECT content FROM elements WHERE section_owner = '$i' AND element_name = 'Paragraph text'";

        $resultTitle = mysqli_query($conn, $sqlTitle);
        $resultPara = mysqli_query($conn, $sqlPara);

        $titleData = json_decode(mysqli_fetch_assoc($resultTitle)['content'] ?? '{}', true);
        $paraData = json_decode(mysqli_fetch_assoc($resultPara)['content'] ?? '{}', true);

        $jsonSections[] = [
            'section' => $i,
            'title' => $titleData['title'] ?? 'Untitled Section',
            'paragraph' => $paraData['paragraph'] ?? 'No content available.'
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
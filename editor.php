<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Editor Preview</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        header {
            background:rgb(255, 255, 255);
            padding: 1rem 2rem;
            color: #555;
            font-size: 1.6rem;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .main-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .form-container, .preview-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            font-size: 1.4rem;
            color: #333;
        }

        form h3 {
            margin-top: 1.5rem;
            font-size: 1.2rem;
            color: #444;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: border 0.3s ease-in-out;
        }

        input[type="text"]:focus, textarea:focus {
            border-color:rgb(95, 95, 95);
        }

        input[type="submit"] {
            background:rgb(105, 105, 105);
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color:rgb(75, 75, 75);
        }

        .preview-container {
            padding: 20px;
        }

        .preview-container h1 {
            font-size: 1.8rem;
            color: #444;
            font-weight: bold;
        }

        .preview-container p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .preview-container section {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .preview-container section:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .preview-container section h1 {
            font-size: 1.6rem;
            color: #333;
            margin-bottom: 15px;
        }

        .preview-container section p {
            font-size: 1rem;
            color: #555;
        }

        nav {
            background-color: #f1f1f1;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        nav p {
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 25px;
            margin: 0;
            justify-content: center;
        }

        nav ul li {
            color: black;
            cursor: pointer;
            transition: color 0.3s;
        }

        nav ul li:hover {
            color:rgb(170, 170, 170);
        }

        iframe {
            width: 100%;
            height: 500px;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        @media (max-width: 900px) {
            .main-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>CMS Content Editor</header>

    <div class="main-container">
        <!-- FORMS -->
        <div class="form-container">
            <h2>Edit Sections</h2>
            <form action="" method="post">
                <h3>Section 1</h3>
                <input type="text" name="first_title" placeholder="Title"><br>
                <textarea name="first_paragraph" rows="4" placeholder="Paragraph"></textarea>

                <h3>Section 2</h3>
                <input type="text" name="second_title" placeholder="Title"><br>
                <textarea name="second_paragraph" rows="4" placeholder="Paragraph"></textarea>

                <h3>Section 3</h3>
                <input type="text" name="third_title" placeholder="Title"><br>
                <textarea name="third_paragraph" rows="4" placeholder="Paragraph"></textarea>

                <input type="submit" value="Save Changes" name="update_btn">
            </form>
        </div>

        <!-- PREVIEW OF THE WEBSITE (UPDATE SO THAT IT IS DYNAMIC) -->
        <div class="preview-container">
            <h2>In-Page Preview</h2>
            <nav>
                <p>BRAND AREA</p>
                <ul>
                    <li>Home</li>
                    <li>Services</li>
                    <li>Contact</li>
                    <li>About</li>
                </ul>
            </nav>
            <div id="content_preview"></div>
        </div>
    </div>

    <?php
    include 'connect.php'; // database file 

    if (isset($_POST["update_btn"])) {
        if (!empty($_POST["first_title"]) || !empty($_POST["first_paragraph"])) {
            $section1 = json_encode([
                "title" => $_POST["first_title"],
                "paragraph" => $_POST["first_paragraph"]
            ]);
            $sql1 = "UPDATE elements SET content = ? WHERE section_owner = '1' AND element_name = 'Title text'";
            $stmt1 = mysqli_prepare($conn, $sql1);
            mysqli_stmt_bind_param($stmt1, "s", $section1);
            mysqli_stmt_execute($stmt1);
        }

        if (!empty($_POST["second_title"]) || !empty($_POST["second_paragraph"])) {
            $section2 = json_encode([
                "title" => $_POST["second_title"],
                "paragraph" => $_POST["second_paragraph"]
            ]);
            $sql2 = "UPDATE elements SET content = ? WHERE section_owner = '2' AND element_name = 'Title text'";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "s", $section2);
            mysqli_stmt_execute($stmt2);
        }

        if (!empty($_POST["third_title"]) || !empty($_POST["third_paragraph"])) {
            $section3 = json_encode([
                "title" => $_POST["third_title"],
                "paragraph" => $_POST["third_paragraph"]
            ]);
            $sql3 = "UPDATE elements SET content = ? WHERE section_owner = '3' AND element_name = 'Title text'";
            $stmt3 = mysqli_prepare($conn, $sql3);
            mysqli_stmt_bind_param($stmt3, "s", $section3);
            mysqli_stmt_execute($stmt3);
        }

    }

    // Retrieve sections data from the database
    $jsonSections = [];
    for ($i = 1; $i <= 3; $i++) {
        $sql = "SELECT content FROM elements WHERE section_owner = '$i' AND element_name = 'Title text'";
        $result = mysqli_query($conn, $sql);
        $data = json_decode(mysqli_fetch_assoc($result)['content'] ?? '{}', true);
        $jsonSections[] = [
            'section' => $i,
            'title' => $data['title'] ?? 'Untitled Section',
            'paragraph' => $data['paragraph'] ?? 'No content available.'
        ];
    }

    // Send the data to JavaScript
    echo "<script>const previewSections = " . json_encode($jsonSections) . ";</script>";
    ?>

    <script>
        // Populate the form fields 
        document.querySelector('input[name="first_title"]').value = previewSections[0].title;
        document.querySelector('textarea[name="first_paragraph"]').value = previewSections[0].paragraph;
        document.querySelector('input[name="second_title"]').value = previewSections[1].title;
        document.querySelector('textarea[name="second_paragraph"]').value = previewSections[1].paragraph;
        document.querySelector('input[name="third_title"]').value = previewSections[2].title;
        document.querySelector('textarea[name="third_paragraph"]').value = previewSections[2].paragraph;

        const previewContainer = document.getElementById('content_preview');
        function renderPreview(sections) {
            previewContainer.innerHTML = ''; 
            sections.forEach(sec => {
                const sectionEl = document.createElement('section');
                sectionEl.innerHTML = `
                    <h1>${sec.title}</h1>
                    <p>${sec.paragraph}</p>
                `;
                previewContainer.appendChild(sectionEl);
            });
        }

        renderPreview(previewSections);

        const formInputs = document.querySelectorAll('.form-container input[type="text"], .form-container textarea');
        formInputs.forEach(input => {
            input.addEventListener('input', () => {
                const updatedSections = [
                    {
                        title: document.querySelector('input[name="first_title"]').value,
                        paragraph: document.querySelector('textarea[name="first_paragraph"]').value
                    },
                    {
                        title: document.querySelector('input[name="second_title"]').value,
                        paragraph: document.querySelector('textarea[name="second_paragraph"]').value
                    },
                    {
                        title: document.querySelector('input[name="third_title"]').value,
                        paragraph: document.querySelector('textarea[name="third_paragraph"]').value
                    }
                ];
                renderPreview(updatedSections);
            });
        });
    </script>

</body>
</html>

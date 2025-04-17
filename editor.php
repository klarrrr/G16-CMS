<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Editor Preview</title>
    <link rel="stylesheet" href="styles_editor.css">
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1>CMS Content Editor</h1>
        <!-- TODO : Make this dynamic, go to whatever the user's project link is -->
        <a href="template1_home.php" target="_blank">View Full Site</a>
    </header>
    <div class="main-container">
        <!-- FORMS -->
        <!-- EDITOR CARD -->
        <div class="form-container">
            <h2>Edit Sections</h2>
            <form action="" method="post">
                <div>
                    <h3>Section 1</h3>
                    <input type="text" name="first_title" placeholder="Title"><br>
                    <textarea name="first_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div>
                    <h3>Section 2</h3>
                    <input type="text" name="second_title" placeholder="Title"><br>
                    <textarea name="second_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div>
                    <h3>Section 3</h3>
                    <input type="text" name="third_title" placeholder="Title"><br>
                    <textarea name="third_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>
                <input id="save_btn" value="Save Changes" name="save_btn" onclick="refreshFrame();" type="submit">
            </form>
        </div>

        <!-- PREVIEW OF THE WEBSITE -->
        <div class="preview-container">
            <h2>In-Page Preview</h2>
            <iframe id="website_viewer" src="template1_home.php"></iframe>
        </div>
    </div>

    <?php

    include 'connect.php'; // database file 

    if (isset($_POST["save_btn"])) {
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
        document.querySelector('textarea[name="first_paragraph" ]').value = previewSections[0].paragraph;
        document.querySelector('input[name="second_title" ]').value = previewSections[1].title;
        document.querySelector('textarea[name="second_paragraph" ]').value = previewSections[1].paragraph;
        document.querySelector('input[name="third_title" ]').value = previewSections[2].title;
        document.querySelector('textarea[name="third_paragraph" ]').value = previewSections[2].paragraph;

        // Save the details in the input

        // Function to refresh the website viewer
        // function loadContent() {
        //     $('#website_viewer').load('template1_home.php');
        // }
        function refreshFrame() {
            const iframe = document.getElementById('website_viewer');
            iframe.src = iframe.src;
        }

        refreshFrame();

        // Call everytime you entering the site
        // loadContent();
    </script>

</body>

</html>
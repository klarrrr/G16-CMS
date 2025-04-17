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
    // Section 1
    if (!empty($_POST["first_title"])) {
        $title1 = json_encode(["title" => $_POST["first_title"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '1' AND element_name = 'Title text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $title1);
        mysqli_stmt_execute($stmt);
    }

    if (!empty($_POST["first_paragraph"])) {
        $para1 = json_encode(["paragraph" => $_POST["first_paragraph"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '1' AND element_name = 'Paragraph text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $para1);
        mysqli_stmt_execute($stmt);
    }

    // Section 2
    if (!empty($_POST["second_title"])) {
        $title2 = json_encode(["title" => $_POST["second_title"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '2' AND element_name = 'Title text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $title2);
        mysqli_stmt_execute($stmt);
    }

    if (!empty($_POST["second_paragraph"])) {
        $para2 = json_encode(["paragraph" => $_POST["second_paragraph"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '2' AND element_name = 'Paragraph text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $para2);
        mysqli_stmt_execute($stmt);
    }

    // Section 3
    if (!empty($_POST["third_title"])) {
        $title3 = json_encode(["title" => $_POST["third_title"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '3' AND element_name = 'Title text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $title3);
        mysqli_stmt_execute($stmt);
    }

    if (!empty($_POST["third_paragraph"])) {
        $para3 = json_encode(["paragraph" => $_POST["third_paragraph"]]);
        $sql = "UPDATE elements SET content = ? WHERE section_owner = '3' AND element_name = 'Paragraph text'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $para3);
        mysqli_stmt_execute($stmt);
    }
}

// Retrieve sections data from the database
$jsonSections = [];
for ($i = 1; $i <= 3; $i++) {
    $sqlTitle = "SELECT content FROM elements WHERE section_owner = '$i' AND element_name = 'Title text'";
    $sqlPara = "SELECT content FROM elements WHERE section_owner = '$i' AND element_name = 'Paragraph text'";

    $resultTitle = mysqli_query($conn, $sqlTitle);
    $resultPara = mysqli_query($conn, $sqlPara);

    $dataTitle = json_decode(mysqli_fetch_assoc($resultTitle)['content'] ?? '{}', true);
    $dataPara = json_decode(mysqli_fetch_assoc($resultPara)['content'] ?? '{}', true);

    $jsonSections[] = [
        'section' => $i,
        'title' => $dataTitle['title'] ?? 'Untitled Section',
        'paragraph' => $dataPara['paragraph'] ?? 'No content available.'
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
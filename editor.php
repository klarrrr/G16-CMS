<?php
include 'connect.php';

// Directory where page files are stored
$pageDirectory = './';  // Adjust the path as needed
$files = array_diff(scandir($pageDirectory), array('..', '.', 'template1_nav.php', 'template1_footer.php'));

$pages = [];

// Filter files that match the page pattern template1_*.php
foreach ($files as $file) {
    if (preg_match('/^template1_([a-zA-Z0-9_]+)\.php$/', $file, $matches)) {
        $pages[] = [
            'id' => $matches[1],
            'name' => ucfirst($matches[1])  // Capitalize first letter
        ];
    }
}

// ADD NEW PAGE HANDLER
if (isset($_POST["new_page"])) {
    $templateOption = $_POST["template_option"] ?? 'default';
    $pageRaw = $_POST["new_page"];
    $page = preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($pageRaw));
    $newFile = "template1_$page.php";
    $navFile = "template1_nav.php";

    if (!file_exists($newFile)) {
        $pageTitle = ucfirst($page);
        switch ($templateOption) {
            case 'home':
                $bodyContent = "<h1>Welcome to the Home Page</h1><p>This is your homepage.</p>";
                break;
            case 'services':
                $bodyContent = "<h1>Our Services</h1><p>Details about what you offer.</p>";
                break;
            case 'contact':
                $bodyContent = "<h1>Contact Us</h1><p>Provide contact info or a form here.</p>";
                break;
            case 'about':
                $bodyContent = "<h1>About Us</h1><p>Tell your story here.</p>";
                break;
            default:
                $bodyContent = "<h1>$pageTitle</h1><p>You haven’t added any content yet.</p>";
        }

        $htmlTemplate = <<<HTML
<?php include('template1_nav.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$pageTitle</title>
    <link rel="stylesheet" href="styles_template1.css">
</head>
<body>
    <div class="main_page">
        <div class="hero">
            <div>
                $bodyContent
            </div>
            <button class="call_to_action_btn">Get Started</button>
        </div>

        <div id="content">
        </div>
    </div>

    <?php include('template1_footer.php'); ?>
</body>
</html>
HTML;

        file_put_contents($newFile, $htmlTemplate);
    }

    // Add new page to navigation file (template1_nav.php)
    $navEntry = "<li><a href=\"$newFile\">" . ucfirst($page) . "</a></li>";
    $navContent = file_get_contents($navFile);
    if (strpos($navContent, $navEntry) === false) {
        $updatedNav = str_replace("</ul>", "    $navEntry\n</ul>", $navContent);
        file_put_contents($navFile, $updatedNav);
    }

    echo "<script>alert('New page \"$page\" created.'); location.href=location.href;</script>";
    exit;
}

// SAVE CHANGES HANDLER
if (isset($_POST["save_btn"])) {
    $page = $_POST["selected_page"];

    for ($i = 1; $i <= 3; $i++) {
        $titleKey = ["first_title", "second_title", "third_title"][$i - 1];
        $paraKey = ["first_paragraph", "second_paragraph", "third_paragraph"][$i - 1];

        if (!empty($_POST[$titleKey])) {
            $titleData = json_encode(["title" => $_POST[$titleKey]]);
            $sql = "UPDATE elements SET content = ? WHERE section_owner = '$i' AND element_name = 'Title text'";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $titleData);
            mysqli_stmt_execute($stmt);
        }

        if (!empty($_POST[$paraKey])) {
            $paraData = json_encode(["paragraph" => $_POST[$paraKey]]);
            $sql = "UPDATE elements SET content = ? WHERE section_owner = '$i' AND element_name = 'Paragraph text'";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $paraData);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Fetch existing content
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Editor Preview</title>
    <link rel="stylesheet" href="styles_editor.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 999; }
        .modal-content { background: #fff; padding: 20px; margin: 10% auto; width: 50%; position: relative; border-radius: 8px; }
        .modal .close { position: absolute; top: 10px; right: 20px; font-size: 22px; cursor: pointer; }

        .node-list { display: flex; flex-wrap: wrap; gap: 1rem; padding-top: 1rem; }
        .page-node { border: 1px solid #ccc; padding: 1rem; border-radius: 8px; width: 200px; background: #f9f9f9; }
        .page-node h3 { margin: 0 0 10px; }
        .page-node button { padding: 0.5rem 1rem; }

        /* Template Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 999; }
        .modal-content { background: #fff; padding: 20px; margin: 10% auto; width: 50%; position: relative; border-radius: 8px; }
        .modal .close-template { position: absolute; top: 10px; right: 20px; font-size: 22px; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <h1>CMS Content Editor</h1>
        <a href="" target="_blank">Pages</a>
        <a href="" target="_blank">Design</a>
        <a href="" target="_blank">Settings</a>
        <a href="template1_home.php" target="_blank">View Full Site</a>

    </header>
    <div class="main-container">
        <div class="form-container">
            <div class="edit-header">
                <h2>Edit Pages (Nodes)</h2>
                <button id="addPageBtn">Add New Page</button>
            </div>

            <!-- Node List -->
            <div class="node-list" id="nodeList">
                <?php foreach ($pages as $page): ?>
                    <div class="page-node">
                        <h3><?php echo $page['name']; ?></h3>
                        <button class="editBtn" data-id="<?php echo $page['id']; ?>">Edit</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="preview-container">
            <h2>In-Page Preview</h2>
            <iframe id="website_viewer" src="template1_home.php"></iframe>
        </div>
    </div>

    <!-- Template Selection Modal -->
    <div id="templateModal" class="modal">
        <div class="modal-content">
            <span class="close-template">&times;</span>
            <h2>Select a Template</h2>
            <form id="templateForm" method="post">
                <label for="template_page_name">Page Name:</label><br>
                <input type="text" name="new_page" id="template_page_name" placeholder="e.g., about, services" required><br><br>

                <label for="template_select">Choose a Template:</label><br>
                <select id="template_select" name="template_option" required>
                    <option value="">-- Select --</option>
                    <option value="home">Home</option>
                    <option value="services">Services</option>
                    <option value="contact">Contact</option>
                    <option value="about">About</option>
                </select><br><br>

                <input type="submit" value="Create Page">
            </form>
        </div>
    </div>

    <!-- Modal Editor -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Page: <span id="modalPageName"></span></h2>
            <form id="editForm" method="post">
                <input type="hidden" name="selected_page" id="selectedPage">

                <div>
                    <h3>Section 1</h3>
                    <input type="text" name="first_title" id="first_title" placeholder="Title"><br>
                    <textarea name="first_paragraph" id="first_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div>
                    <h3>Section 2</h3>
                    <input type="text" name="second_title" id="second_title" placeholder="Title"><br>
                    <textarea name="second_paragraph" id="second_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div>
                    <h3>Section 3</h3>
                    <input type="text" name="third_title" id="third_title" placeholder="Title"><br>
                    <textarea name="third_paragraph" id="third_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <input id="save_btn" value="Save Changes" name="save_btn" onclick="refreshFrame();" type="submit">
            </form>
        </div>
    </div>

<script>
    const previewSections = <?php echo json_encode($jsonSections); ?>;
    const pages = <?php echo json_encode($pages); ?>;

    const nodeList = document.getElementById("nodeList");
    const modal = document.getElementById("editModal");
    const closeBtn = modal.querySelector(".close");
    const modalPageName = document.getElementById("modalPageName");

    const templateModal = document.getElementById("templateModal");
    const closeTemplate = templateModal.querySelector(".close-template");

    nodeList.addEventListener("click", e => {
        if (e.target.classList.contains("editBtn")) {
            const pageId = e.target.dataset.id;
            document.getElementById("selectedPage").value = pageId;
            modalPageName.textContent = pageId;

            const data = previewSections;
            document.getElementById("first_title").value = data[0].title;
            document.getElementById("first_paragraph").value = data[0].paragraph;
            document.getElementById("second_title").value = data[1].title;
            document.getElementById("second_paragraph").value = data[1].paragraph;
            document.getElementById("third_title").value = data[2].title;
            document.getElementById("third_paragraph").value = data[2].paragraph;

            modal.style.display = "block";
        }
    });

    closeBtn.onclick = () => modal.style.display = "none";
    window.onclick = e => { if (e.target == modal) modal.style.display = "none"; }

    document.getElementById('addPageBtn').addEventListener('click', function () {
        document.getElementById("template_page_name").value = "";
        document.getElementById("template_select").selectedIndex = 0;
        templateModal.style.display = "block";
    });

    closeTemplate.onclick = () => templateModal.style.display = "none";
    window.onclick = e => { if (e.target == templateModal) templateModal.style.display = "none"; }
</script>
</body>
</html>

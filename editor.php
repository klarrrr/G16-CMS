<?php
include 'connect.php';
include 'page_handler.php';
include 'save_changes_handler.php';
include 'fetch_site_data_from_db.php';
?>

<!-- MAIN EDITOR PAGE -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento Editor</title>
    <!-- Main CSS of Editor -->
    <link rel="stylesheet" href="styles_editor.css">
    <!-- CSS of Modal, the one that appears when clicking add page -->
    <link rel="stylesheet" href="editor_modal.css">
    <!-- For JQuery ito VVV -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'editor_nav.php' ?>
    <div class="main-container">
        <div class="form-container">
            <div class="edit-header">
                <h2>Edit Pages</h2>
                <button id="addPageBtn">Add New Page</button>
            </div>
            <!-- NODE LIST CONTAINER -->
            <div class="node_list_container">
                <!-- Node List -->
                <div class="node-list" id="nodeList">
                    <?php foreach ($pages as $page): ?>
                        <div class="page-node">
                            <h3><?php echo $page['name']; ?></h3>
                            <!-- TODO : Add small preview of page here, replace div with it -->
                            <!-- <iframe src=""></iframe> -->
                            <div class="view_of_page"></div>
                            <button class="editBtn" data-id="<?php echo $page['id']; ?>">Edit</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- PREVIEW OF WEBSITE -->
        <div class="preview-container">
            <iframe id="website_viewer" src="pages/template1/template1_home.php"></iframe>
        </div>
    </div>

    <!-- Template Selection Modal -->
    <div id="templateModal" class="modal">
        <div class="modal-content">
            <span class="close-template">&times;</span>
            <h2>Select a Template</h2>
            <form id="templateForm" method="post">
                <label for="template_page_name">Page Name</label><br>
                <input type="text" name="new_page" id="template_page_name" placeholder="e.g., about, services" required><br><br>

                <label for="template_select">Select template</label><br>
                <!-- TODO : Gawing dynamic, grab yung mga page template sa database -->
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
        <div class="modal-content" id="modal_editor_content">
            <div class="modal_editor_header">
                <span class="close">&times;</span>
                <h2>Edit Page: <span id="modalPageName"></span></h2>
            </div>
            <form id="editForm" method="post">
                <input type="hidden" name="selected_page" id="selectedPage">
                <div class="sections_editor_container">
                    <h3>Section 1</h3>
                    <input type="text" name="first_title" id="first_title" placeholder="Title"><br>
                    <textarea name="first_paragraph" id="first_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div class="sections_editor_container">
                    <h3>Section 2</h3>
                    <input type="text" name="second_title" id="second_title" placeholder="Title"><br>
                    <textarea name="second_paragraph" id="second_paragraph" rows="4" placeholder="Paragraph" style="resize: none;"></textarea>
                </div>

                <div class="sections_editor_container">
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
        window.onclick = e => {
            if (e.target == modal) modal.style.display = "none";
        }

        document.getElementById('addPageBtn').addEventListener('click', function() {
            document.getElementById("template_page_name").value = "";
            document.getElementById("template_select").selectedIndex = 0;
            templateModal.style.display = "block";
        });

        closeTemplate.onclick = () => templateModal.style.display = "none";
        window.onclick = e => {
            if (e.target == templateModal) templateModal.style.display = "none";
        }
    </script>
</body>

</html>
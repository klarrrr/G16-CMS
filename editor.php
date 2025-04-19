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
    <!-- For Nav -->
    <link rel="stylesheet" href="styles_editor_nav.css">
    <!-- For JQuery ito VVV -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'editor_nav.php'; ?>
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
                    <!-- TODO : Fix this add dynamic insert of pages -->
                    <!-- PHP : Get the name per item in the array of Pages -->
                    <!-- Add a Function to a button that will edit current pages sections and elements -->

                    <!-- Display The Pages -->
                    <?php

                    foreach ($pagesArray as $pageId => $pageDetails) {
                        $pageName = ucwords(strtolower($pageDetails['page_name']));
                        $lilPageLayout = "
                        <div class='page-node'>
                            <h3>$pageName</h3>
                            <div class='view_of_page'></div>
                            <button class='editBtn' onclick='' data-pageid='$pageId'>EDIT</button>
                        </div>
                        ";
                        echo $lilPageLayout;
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- PREVIEW OF WEBSITE -->
        <div class="preview-container">
            <iframe id="website_viewer" srcdoc="<?php echo htmlspecialchars($htmlLayout) ?>"></iframe>
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

    <!-- Modal wrapper (empty for now) -->
    <div id="editModal" class="modal">
        <div class="modal-content" id="modalContent">
            <!-- Modal content will be injected here -->
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("editModal");
            const modalContent = document.getElementById("modalContent");

            document.getElementById("nodeList").addEventListener("click", function(e) {
                if (e.target.classList.contains("editBtn")) {
                    const pageId = e.target.dataset.pageid;
                    console.log(pageId);
                    // Fetch modal layout from PHP
                    fetch(`get_modal_layout.php?page_id=${pageId}`)
                        .then(res => res.text())
                        .then(html => {
                            modalContent.innerHTML = html;
                            modal.style.display = "block";
                        });
                }
            });

            // Optional: close logic
            window.onclick = e => {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            };
        });
    </script>
</body>

</html>
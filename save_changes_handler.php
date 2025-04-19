<?php

include 'connect.php';

if (isset($_POST["page_id"]) && isset($_POST["elements"])) {
    $pageId = $_POST["page_id"];
    $elements = $_POST["elements"]; // This is an associative array: elementId => content

    foreach ($elements as $elementId => $newContent) {
        // Sanitize and encode the data (depending on how you're storing it)
        $sanitizedContent = mysqli_real_escape_string($conn, $newContent);
        $jsonContent = json_encode(["content" => $sanitizedContent]);

        // Update the specific element
        $sql = "UPDATE elements SET content = ? WHERE element_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $jsonContent, $elementId);
        mysqli_stmt_execute($stmt);
    }
} else {
    echo "Invalid request.";
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("editModal");
        const modalContent = document.getElementById("modalContent");

        // Intercept the form submit inside the modal
        modal.addEventListener("submit", function(e) {
            e.preventDefault(); // Stop default form submission

            const form = e.target;
            const formData = new FormData(form);

            fetch("save_changes_handler.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text()) // You can also use res.json() if you return JSON
                .then(response => {
                    console.log("Server Response:", response);

                    // OPTIONAL: Show a toast or success message here
                    alert("Changes saved!");

                    // Close modal
                    modal.style.display = "none";
                })
                .catch(error => {
                    console.error("Error saving changes:", error);
                    alert("Something went wrong.");
                });
        });

        // Open modal with content
        document.getElementById("nodeList").addEventListener("click", function(e) {
            if (e.target.classList.contains("editBtn")) {
                const pageId = e.target.dataset.pageid;

                fetch(`get_modal_layout.php?page_id=${pageId}`)
                    .then(res => res.text())
                    .then(html => {
                        modalContent.innerHTML = html;
                        modal.style.display = "block";
                    });
            }
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    });
</script>
<?php
include 'page_handler.php'; // includes $sections, $elements, etc.

$page_id = $_GET['page_id'] ?? null;

if (!$page_id) {
    echo "Page ID missing.";
    exit;
}

$pageName = ucwords(strtolower($pagesArray[$page_id]['page_name']));

function buildModalLayout($page_id, $pageName, $sections, $elements)
{
    $output = "
            <div class='modal-header'>
                <span class='close' onclick='document.getElementById(\"editModal\").style.display=\"none\";'>&times;</span>
                <h2>Edit Page: $pageName</h2>
            </div>
            <form method='post' action='save_changes_handler.php'>
                <input type='hidden' name='page_id' value='$page_id'>";

    foreach ($sections as $sectionId => $sectionDetail) {
        if ($sectionDetail['page_owner'] == $page_id) {
            $output .= "<div class='section-block'>";
            $output .= "<h3>" . htmlspecialchars(ucwords(strtolower($sectionDetail['section_name']))) . "</h3>";

            foreach ($elements as $elementId => $element) {
                if ($element['section_owner'] == $sectionId) {
                    $decoded = json_decode($element['element_content'], true);
                    if ($element['element_name'] == "Title Text") {
                        $value = $decoded['content'];
                        $output .= "<input type='text' name='elements[$elementId]' value='$value' placeholder='Title'><br>";
                    } elseif ($element['element_name'] == "Paragraph Text") {
                        $value = $decoded['content'];
                        $output .= "<textarea name='elements[$elementId]' rows='4' style='resize:none;'>$value</textarea><br>";
                    }
                }
            }
            $output .= "</div>";
        }
    }

    $output .= "<input type='submit' value='Save Changes'>
            </form>";

    return $output;
}

echo buildModalLayout($page_id, $pageName, $sectionsArray, $elementsArray);

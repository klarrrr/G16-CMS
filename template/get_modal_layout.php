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
                <input type='hidden' name='page_id' value='$page_id'>
                
                ";

    foreach ($sections as $sectionId => $sectionDetail) {
        if ($sectionDetail['page_owner'] == $page_id) {
            $output .= "<div class='section-block'>";
            $output .= "<h3>" . htmlspecialchars(ucwords(strtolower($sectionDetail['section_name']))) . "</h3>";

            foreach ($elements as $elementId => $element) {
                if ($element['section_owner'] == $sectionId) {
                    $decoded = json_decode($element['element_content'], true);
                    $value = $decoded['content'];
                    $placeholder = $element['element_name'];
                    $elementType = $element['element_type'];
                    $titleElementType = ucwords(strtolower($elementType));
                    $output .= "<h3>$titleElementType</h3>";

                    /* 
                    
                    * WHEN YOU WANT TO ADD ELEMENT TYPES TO EDIT ADD IT HERE
                    * SAVE CHANGES HANDLER IS ALREADY DYNAMIC SO NO NEED TO ADD IT THERE
                    * TEMPLATE HOME DYNAMIC IS WHERE YOU EDIT THE SECTIONS

                    */

                    switch ($elementType) {
                        case 'title':
                            $output .= "<input type='text' name='elements[$elementId]' value='$value' placeholder='$placeholder'><br>";
                            break;
                        case 'paragraph':
                            $output .= "<textarea name='elements[$elementId]' rows='4' style='resize:none;' placeholder='$placeholder'>$value</textarea><br>";
                            break;
                        case 'button':
                            $output .= "<input type='text' name='elements[$elementId]' value='$value' placeholder='Button Label'><br>";
                            break;
                        case 'image':
                            $output .= "<input type='url' name='elements[$elementId]' value='$value' placeholder='Image URL'><br>";
                            break;
                        case 'sub':
                            $output .= "<input type='text' name='elements[$elementId]' value='$value' placeholder='$placeholder'><br>";
                            break;
                        default:
                            $output .= "<input type='text' name='elements[$elementId]' value='$value' placeholder='$placeholder'><br>";
                            break;
                    }
                }
            }
            $output .= "</div>";
        }
    }

    $output .= "<div class='modal-footer'>
        <input type='submit' value='Save Changes'>
    </div>
    </form>";

    return $output;
}

function isValidHexColor($color)
{
    return preg_match('/^#[0-9A-Fa-f]{6}$/', $color);
}


echo buildModalLayout($page_id, $pageName, $sectionsArray, $elementsArray);

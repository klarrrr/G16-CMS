<?php

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

<?php

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

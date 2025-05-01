<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Create Article Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cms-preview-styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="create-article-right-editor-container">
        <div class="create-article-main" id='create-article-main'>
            <div class="create-navs">
                <div class="create-nav-one">
                    <!-- TODO MAKE DYNAMIC LATER -->
                    <div class="create-nav-one-title">
                        <h2>Article Document Title</h2>
                        <p>Created on May 1, 2025 - Klarenz Cobie Manrique</p>
                    </div>
                    <button id="create-post-article-btn">Post</button>
                </div>
                <div class="create-nav-two">
                    <div class="select-wrapper">
                        <select id="font-family">
                            <option value="">Select Font Family</option>
                            <option value="Arial" style='font-family:arial'>Arial</option>
                            <option value="Georgia" style='font-family:georgia'>Georgia</option>
                            <option value="Impact" style='font-family:impact'>Impact</option>
                            <option value="Times New Roman" style='font-family:times new roman'>Times New Roman</option>
                            <option value="Verdana" style='font-family:verdana'>Verdana</option>
                            <option value="Segoe UI" style='font-family:segoe ui'>Segoe UI</option>
                        </select>
                    </div>

                    <!-- Font Style -->
                    <div class="font-style">
                        <button><b>B</b></button>
                        <button><i>I</i></button>
                        <button><u>U</u></button>
                    </div>

                    <!-- Text Alignment -->
                    <div class="text-align">
                        <button><img src="text-svg/left-align-svgrepo-com.svg" alt=""></button>
                        <button><img src="text-svg/center-align-svgrepo-com.svg" alt=""></button>
                        <button><img src="text-svg/right-align-svgrepo-com.svg" alt=""></button>
                        <button><img src="text-svg/justify-align-svgrepo-com.svg" alt=""></button>
                    </div>

                    <!-- Bullet and Numbered Lists -->
                    <button id="bullet-list"><img src="text-svg/bullet-list-svgrepo-com.svg" alt=""></button>
                    <button id="numbered-list"><img src="text-svg/ordered-list-svgrepo-com.svg" alt=""></button>

                    <!-- Insert Image -->
                    <button id="insert-image"><img src="text-svg/image-svgrepo-com.svg" alt=""></button>
                </div>
            </div>
            <div class="create-canvas">
                <!-- TODO : MAKE DYNAMIC LATER -->
                <h1>Pinangunahan ng mga mag-aaral mula sa BS Entrepreneurship (BSEntrep) ang isang Community Extension Program para sa mga lokal na negosyante ngayong Abril 28 sa PLP Function Hall.</h1>
                <p>Sa temang "Strengthening Local Entrepreneurs: Building Capacity Amidst Challenges Faced by Small Business Owners," itinampok ang mga kapaki-pakinabang na palihan nina Mr. Marcial Dela Cruz ng Lamp Light Studios at Mr. Mark Pagaduan ng ReZtyle Clothing. Namahagi rin ng business packages ang mga mag-aaral ng BSEntrep sa mga piling benepisyaryo bilang tulong sa pagpapalago ng kanilang kabuhayan.</p>
                <p>Paalala ng isang tagapagsalita, “Huwag maliitin ang maliliit na negosyo, sapagkat negosyo pa rin ito," isang mensaheng nagpatibay sa pag-asa at determinasyon ng mga kalahok.</p>
                <p>Matagumpay na naisakatuparan ng mga mag-aaral ng BSEntrep ang layunin na palakasin ang kaalaman, kumpiyansa, at kakayahan ng maliliit na negosyante, patunay sa diwa ng malasakit ng Pamantasan. </p>

                <h1>Pinangunahan ng mga mag-aaral mula sa BS Entrepreneurship (BSEntrep) ang isang Community Extension Program para sa mga lokal na negosyante ngayong Abril 28 sa PLP Function Hall.</h1>
                <p>Sa temang "Strengthening Local Entrepreneurs: Building Capacity Amidst Challenges Faced by Small Business Owners," itinampok ang mga kapaki-pakinabang na palihan nina Mr. Marcial Dela Cruz ng Lamp Light Studios at Mr. Mark Pagaduan ng ReZtyle Clothing. Namahagi rin ng business packages ang mga mag-aaral ng BSEntrep sa mga piling benepisyaryo bilang tulong sa pagpapalago ng kanilang kabuhayan.</p>
                <p>Paalala ng isang tagapagsalita, “Huwag maliitin ang maliliit na negosyo, sapagkat negosyo pa rin ito," isang mensaheng nagpatibay sa pag-asa at determinasyon ng mga kalahok.</p>
                <p>Matagumpay na naisakatuparan ng mga mag-aaral ng BSEntrep ang layunin na palakasin ang kaalaman, kumpiyansa, at kakayahan ng maliliit na negosyante, patunay sa diwa ng malasakit ng Pamantasan. </p>

                <h1>Pinangunahan ng mga mag-aaral mula sa BS Entrepreneurship (BSEntrep) ang isang Community Extension Program para sa mga lokal na negosyante ngayong Abril 28 sa PLP Function Hall.</h1>
                <p>Sa temang "Strengthening Local Entrepreneurs: Building Capacity Amidst Challenges Faced by Small Business Owners," itinampok ang mga kapaki-pakinabang na palihan nina Mr. Marcial Dela Cruz ng Lamp Light Studios at Mr. Mark Pagaduan ng ReZtyle Clothing. Namahagi rin ng business packages ang mga mag-aaral ng BSEntrep sa mga piling benepisyaryo bilang tulong sa pagpapalago ng kanilang kabuhayan.</p>
                <p>Paalala ng isang tagapagsalita, “Huwag maliitin ang maliliit na negosyo, sapagkat negosyo pa rin ito," isang mensaheng nagpatibay sa pag-asa at determinasyon ng mga kalahok.</p>
                <p>Matagumpay na naisakatuparan ng mga mag-aaral ng BSEntrep ang layunin na palakasin ang kaalaman, kumpiyansa, at kakayahan ng maliliit na negosyante, patunay sa diwa ng malasakit ng Pamantasan. </p>

                <h1>Pinangunahan ng mga mag-aaral mula sa BS Entrepreneurship (BSEntrep) ang isang Community Extension Program para sa mga lokal na negosyante ngayong Abril 28 sa PLP Function Hall.</h1>
                <p>Sa temang "Strengthening Local Entrepreneurs: Building Capacity Amidst Challenges Faced by Small Business Owners," itinampok ang mga kapaki-pakinabang na palihan nina Mr. Marcial Dela Cruz ng Lamp Light Studios at Mr. Mark Pagaduan ng ReZtyle Clothing. Namahagi rin ng business packages ang mga mag-aaral ng BSEntrep sa mga piling benepisyaryo bilang tulong sa pagpapalago ng kanilang kabuhayan.</p>
                <p>Paalala ng isang tagapagsalita, “Huwag maliitin ang maliliit na negosyo, sapagkat negosyo pa rin ito," isang mensaheng nagpatibay sa pag-asa at determinasyon ng mga kalahok.</p>
                <p>Matagumpay na naisakatuparan ng mga mag-aaral ng BSEntrep ang layunin na palakasin ang kaalaman, kumpiyansa, at kakayahan ng maliliit na negosyante, patunay sa diwa ng malasakit ng Pamantasan. </p>
            </div>
            <div class="widget-toolbar">
                <h2>Widget</h2>
                <p>The compressed version of your article inside in a small box/widget.</p>
                <h3>Widget Title</h3>
                <input type="text" placeholder="Enter title here">
                <h3>Widget Paragraph</h3>
                <textarea name="" id=""></textarea>
            </div>
        </div>
        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>
        <!-- Populate the Selection Input of all the pages -->
        <script src="scripts/nav_panel_switcher.js"></script>
    </div>
</body>

</html>
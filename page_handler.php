<?php

// Directory where page files are stored
$pageDirectory = './pages/template1'; // Adjust the path as needed
$files = array_diff(scandir($pageDirectory), array('..', '.', 'template1_nav.php', 'template1_footer.php'));

$pages = [];

// Filter files that match the page pattern template1_*.php
foreach ($files as $file) {
    if (preg_match('/^template1_([a-zA-Z0-9_]+)\.php$/', $file, $matches)) {
        $pages[] = [
            'id' => $matches[1],
            'name' => ucfirst($matches[1]) // Capitalize first letter
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
                $bodyContent = "<h1>Welcome to the Home Page</h1>
<p>This is your homepage.</p>";
                break;
            case 'services':
                $bodyContent = "<h1>Our Services</h1>
<p>Details about what you offer.</p>";
                break;
            case 'contact':
                $bodyContent = "<h1>Contact Us</h1>
<p>Provide contact info or a form here.</p>";
                break;
            case 'about':
                $bodyContent = "<h1>About Us</h1>
<p>Tell your story here.</p>";
                break;
            default:
                $bodyContent = "<h1>$pageTitle</h1>
<p>You haven’t added any content yet.</p>";
        }

        $htmlTemplate = <<<HTML
    <?php include('template1_nav.php'); ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>$pageTitle</title>
        <link rel="stylesheet" href="../styles/styles_template1.css">
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
        $updatedNav = str_replace("</ul>", " $navEntry\n</ul>", $navContent);
        file_put_contents($navFile, $updatedNav);
    }

    echo "<script>
        alert('New page \"$page\" created.');
        location.href = location.href;
    </script>";
    exit;
}

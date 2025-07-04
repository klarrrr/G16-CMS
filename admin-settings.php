<?php

session_start();

require_once 'php-backend/connect.php';



// Fetch all settings

$siteSettings = [];

$aboutSettings = [];



// Get site settings grouped by their groups

$settingsQuery = $conn->query("SELECT setting_group, setting_name, setting_value FROM site_settings");

while ($row = $settingsQuery->fetch_assoc()) {

  $siteSettings[$row['setting_group']][$row['setting_name']] = $row['setting_value'];
}



// Get about settings

$aboutQuery = $conn->query("SELECT section_type, title, content, image_url, video_url FROM about_settings");

while ($row = $aboutQuery->fetch_assoc()) {

  $aboutSettings[$row['section_type']] = $row;
}



// Handle form submissions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $group = $_GET['group'] ?? '';

  $section = $_GET['section'] ?? '';



  // Handle regular settings updates

  if (!empty($group)) {

    try {

      $conn->begin_transaction();



      $stmt = $conn->prepare("

                INSERT INTO site_settings (setting_group, setting_name, setting_value) 

                VALUES (?, ?, ?)

                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)

            ");



      switch ($group) {

        case 'mail':

          $settings = [

            ['mail', 'email', $_POST['mail-email']],

            ['mail', 'password', $_POST['mail-password']],

            ['mail', 'sender_name', $_POST['mail-name']]

          ];

          break;



        case 'social':

          $settings = [

            ['social', 'facebook_url', $_POST['facebook']],

            ['social', 'instagram_url', $_POST['instagram']],

            ['social', 'pinterest_url', $_POST['pinterest']]

          ];

          break;



        case 'contact':

          $settings = [

            ['contact', 'address', $_POST['address']],

            ['contact', 'open_time_start', $_POST['open_time_start'] . ':00'],

            ['contact', 'open_time_end', $_POST['open_time_end'] . ':00'],

            ['contact', 'phone', $_POST['phone']]

          ];

          break;



        default:

          throw new Exception("Invalid settings group");
      }



      foreach ($settings as $setting) {

        $stmt->bind_param("sss", $setting[0], $setting[1], $setting[2]);

        $stmt->execute();
      }



      $conn->commit();

      $_SESSION['success'] = ucfirst($group) . ' settings updated successfully!';

      header("Location: admin-settings.php");

      exit;
    } catch (Exception $e) {

      $conn->rollback();

      $_SESSION['error'] = 'Error updating settings: ' . $e->getMessage();

      header("Location: admin-settings.php");

      exit;
    }
  }



  // Handle about page updates

  if (!empty($section)) {

    try {

      $stmt = $conn->prepare("

                INSERT INTO about_settings (section_type, title, content, image_url, video_url) 

                VALUES (?, ?, ?, ?, ?)

                ON DUPLICATE KEY UPDATE 

                    title = VALUES(title),

                    content = VALUES(content),

                    image_url = VALUES(image_url),

                    video_url = VALUES(video_url)

            ");



      $title = $_POST['title'] ?? null;

      $content = $_POST['content'] ?? null;



      // Process image URL - allow both full URLs and local paths

      $imageUrl = $_POST['image_url'] ?? null;

      if ($imageUrl) {

        // Clean up the path by removing leading ./ or /

        $imageUrl = preg_replace('/^\.?\//', '', $imageUrl);



        // If it's not a full URL, ensure it's a proper path

        if (!preg_match('/^https?:\/\//i', $imageUrl)) {

          // Remove any potentially dangerous characters

          $imageUrl = preg_replace('/[^a-zA-Z0-9\-_\.\/]/', '', $imageUrl);
        }
      }



      // Process video URL - should be full URL or empty

      $videoUrl = $_POST['video_url'] ?? null;

      if ($videoUrl && !preg_match('/^https?:\/\//i', $videoUrl)) {

        $videoUrl = ''; // Clear invalid video URLs

      }



      $stmt->bind_param("sssss", $section, $title, $content, $imageUrl, $videoUrl);

      $stmt->execute();



      $_SESSION['success'] = 'About section updated successfully!';

      header("Location: admin-settings.php");

      exit;
    } catch (Exception $e) {

      $_SESSION['error'] = 'Error updating about section: ' . $e->getMessage();

      header("Location: admin-settings.php");

      exit;
    }
  }
}

?>



<!DOCTYPE html>

<html lang="en">



<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Admin Settings - Lundayan Dashboard</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <link rel="stylesheet" href="styles-admin.css">

  <link rel="icon" href="pics/lundayan-logo.png">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
    * {

      box-sizing: border-box;

      margin: 0;

      padding: 0;
    }

    :root {
      --sidebar-width: 250px;
      --header-height: 70px;
      --transition-speed: 0.3s;
    }

    html,
    body {
      height: 100%;
    }

    body {

      font-family: 'Segoe UI', Arial, sans-serif;

      background: #f5f5f5;

      color: #333;

      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* Mobile menu toggle button */
    .mobile-menu-toggle {
      display: none;
      background: white;
      color: #222;
      border: none;
      padding: 1rem;
      width: 100%;
      text-align: left;
      font-size: 1rem;
      cursor: pointer;
      z-index: 1001;
    }

    .mobile-menu-toggle i {
      margin-right: 8px;
    }

    /* Main container layout */
    .main-container {
      display: flex;
      flex: 1;
      min-height: 0;
      /* Fix for flexbox scrolling */
    }

    /* Sidebar styling */

    .left-editor-container {

      flex: 0 0 250px;

      width: var(--sidebar-width);
      background: #222;

      height: 100vh;

      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      overflow-y: auto;

      transition: transform var(--transition-speed) ease;
      z-index: 1000;
    }



    /* Main content area */

    .right-editor-container {

      flex: 1;

      display: flex;

      flex-direction: column;

      height: 100vh;

      overflow-y: auto;

    }


    .right-editor-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin-left: var(--sidebar-width);
      transition: margin-left var(--transition-speed) ease;
      width: 100%;
      max-width: 100vw;
      overflow-x: hidden;
    }


    .page-header {

      background: white;

      padding: 1.5rem 2rem;

      border-bottom: 1px solid #e0e0e0;

      width: 100%;

    }



    .page-header h1 {

      font-size: 1.8rem;

      color: #222;

      font-weight: 600;

    }



    .page-header p {

      color: #666;

      font-size: 0.9rem;

      margin-top: 0.5rem;

    }



    .main-content {

      flex: 1;

      padding: 2rem;

      width: 100%;

      overflow-y: auto;
    }



    /* Modern Black & White Card Styles */

    .card {

      background: white;

      border-radius: 8px;

      padding: 1.5rem;

      margin-bottom: 1.5rem;

      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);

      border: 1px solid #e0e0e0;

      width: 100%;

    }



    .card h2 {

      font-size: 1.4rem;

      margin-bottom: 1.5rem;

      padding-bottom: 0.75rem;

      border-bottom: 1px solid #eee;

      color: #222;

      font-weight: 600;

    }



    .card h3 {

      font-size: 1.2rem;

      margin: 1.5rem 0 1rem 0;

      color: #333;

      font-weight: 500;

    }



    .card label {

      display: block;

      margin-bottom: 0.5rem;

      font-size: 0.9rem;

      color: #555;

      font-weight: 500;

    }



    .card input,

    .card select,

    .card textarea {

      width: 100%;

      padding: 0.75rem;

      margin-bottom: 1.25rem;

      border: 1px solid #ddd;

      border-radius: 4px;

      font-size: 0.95rem;

      transition: all 0.2s ease;

    }



    .card input:focus,

    .card select:focus,

    .card textarea:focus {

      outline: none;

      border-color: #999;

      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);

    }



    .card textarea {

      min-height: 120px;

      resize: vertical;

    }



    .card-footer {

      display: flex;

      justify-content: flex-end;

      margin-top: 1rem;

      padding-top: 1rem;

      border-top: 1px solid #eee;

      gap: 0.5rem;

    }



    .save-btn {

      background: #222;

      color: white;

      padding: 0.75rem 1.5rem;

      border: none;

      border-radius: 4px;

      cursor: pointer;

      font-size: 0.95rem;

      font-weight: 500;

      transition: all 0.2s ease;

    }



    .save-btn:hover {

      background: #111;

      transform: translateY(-1px);

    }



    .path-hint {

      font-size: 0.8rem;

      color: #777;

      margin: -0.5rem 0 1rem 0;

      line-height: 1.4;

    }



    /* Status Messages */

    .success,

    .error {

      border-radius: 4px;

      padding: 1rem;

      margin-bottom: 1.5rem;

      border-left: 4px solid;

      background: #f8f8f8;

    }



    .success {

      color: #155724;

      border-left-color: #28a745;

    }



    .error {

      color: #721c24;

      border-left-color: #dc3545;

    }



    /* Single column layout */

    .form-columns {

      display: flex;

      flex-direction: column;

      gap: 1.5rem;

      width: 100%;

    }



    .column {

      width: 100%;

    }



    @media (max-width: 768px) {

      body {

        flex-direction: column;

      }



      .left-editor-container {

        width: 100%;

        height: auto;

      }



      .main-content {

        padding: 1.5rem;

      }



      .card {

        padding: 1.25rem;

      }

    }



    /* Article Highlight Setting */



    .articles-list {

      max-height: 500px;

      overflow-y: auto;

      margin: 15px 0;

      border: 1px solid #ddd;

      border-radius: 5px;

    }



    .article-item {

      padding: 12px;

      border-bottom: 1px solid #eee;

      display: flex;

      align-items: center;

      justify-content: space-between;

    }



    .article-item:last-child {

      border-bottom: none;

    }



    .article-info {

      flex: 1;

    }



    .article-title {

      font-weight: 600;

      margin-bottom: 5px;

    }



    .article-date {

      color: #666;

      font-size: 0.9em;

    }



    .highlight-toggle {

      display: flex;

      align-items: center;

    }



    .toggle-switch {

      position: relative;

      display: inline-block;

      width: 50px;

      height: 24px;

      margin-left: 10px;

    }



    .toggle-switch input {

      opacity: 0;

      width: 0;

      height: 0;

    }



    .slider {

      position: absolute;

      cursor: pointer;

      top: 0;

      left: 0;

      right: 0;

      bottom: 0;

      background-color: #ccc;

      transition: .4s;

      border-radius: 24px;

    }



    .slider:before {

      position: absolute;

      content: "";

      height: 16px;

      width: 16px;

      left: 4px;

      bottom: 4px;

      background-color: white;

      transition: .4s;

      border-radius: 50%;

    }



    input:checked+.slider {

      background-color: #161616;

    }



    input:checked+.slider:before {

      transform: translateX(26px);

    }



    .loading-spinner {

      border: 4px solid #f3f3f3;

      border-top: 4px solid #161616;

      border-radius: 50%;

      width: 30px;

      height: 30px;

      animation: spin 1s linear infinite;

      margin: 20px auto;

    }



    @keyframes spin {

      0% {

        transform: rotate(0deg);

      }



      100% {

        transform: rotate(360deg);

      }

    }



    /* Iframe Generator Styles */

    .events-widget-preview {

      margin-bottom: 1.5rem;

      border: 1px dashed #ccc;

      padding: 1rem;

      border-radius: 8px;

    }



    .events-header {

      font-size: 1.3rem;

      font-weight: 600;

      margin-bottom: 1rem;

      color: #222;

    }



    .events-container {

      display: flex;

      gap: 1rem;

      overflow-x: auto;

      padding-bottom: 1rem;

      scrollbar-width: thin;

    }



    .event-card {

      flex: 0 0 250px;

      height: 200px;

      background: white;

      border-radius: 8px;

      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

      position: relative;

      overflow: hidden;

    }



    .event-image {

      width: 100%;

      height: 100%;

      object-fit: cover;

    }



    .event-overlay {

      position: absolute;

      bottom: -100%;

      left: 0;

      right: 0;

      background: rgba(0, 0, 0, 0.8);

      color: white;

      padding: 1rem;

      transition: bottom 0.3s ease;

    }



    .event-card:hover .event-overlay {

      bottom: 0;

    }



    .event-title {

      font-weight: 600;

      margin-bottom: 0.3rem;

    }



    .event-meta,

    .event-date {

      font-size: 0.85rem;

      opacity: 0.9;

    }


    /* Responsive adjustments */
    @media (max-width: 992px) {
      .mobile-menu-toggle {
        display: block;
      }

      .left-editor-container {
        transform: translateX(-100%);
      }

      .left-editor-container.active {
        transform: translateX(0);
      }

      .right-editor-container {
        margin-left: 0;
      }

      body.sidebar-open {
        overflow: hidden;
      }
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .left-editor-container {
        width: 100%;
        height: auto;
      }

      .main-content {
        padding: 1.5rem;
      }

      .card {
        padding: 1.25rem;
      }
    }

    /* iOS specific fixes */
    @supports (-webkit-touch-callout: none) {
      .left-editor-container {
        height: -webkit-fill-available;
      }
    }

    /* Tablet adjustments (≤ 992px) */
    @media (max-width: 992px) {
      .mobile-menu-toggle {
        display: block;
      }

      .left-editor-container {
        transform: translateX(-100%);
        width: 250px;
        position: fixed;
        z-index: 1001;
      }

      .left-editor-container.active {
        transform: translateX(0);
      }

      .right-editor-container {
        margin-left: 0;
      }

      body.sidebar-open {
        overflow: hidden;
      }

      .card,
      .main-content {
        padding: 1rem;
      }

      .form-columns {
        flex-direction: column;
      }
    }

    /* Phone adjustments (≤ 768px) */
    @media (max-width: 768px) {
      .page-header {
        padding: 1rem 1.25rem;
      }

      .page-header h1 {
        font-size: 1.4rem;
      }

      .main-content {
        padding: 1rem;
      }

      .card {
        padding: 1rem;
      }

      .card h2 {
        font-size: 1.2rem;
      }

      .card input,
      .card select,
      .card textarea {
        font-size: 0.9rem;
        padding: 0.65rem;
      }

      .save-btn {
        width: 100%;
        text-align: center;
      }

      .card-footer {
        flex-direction: column;
        align-items: stretch;
      }

      .events-container {
        flex-direction: column;
      }

      .event-card {
        width: 100%;
        height: 180px;
      }
    }

    /* Small devices (≤ 480px) */
    @media (max-width: 480px) {
      .mobile-menu-toggle {
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
      }

      .card h2,
      .card h3 {
        font-size: 1rem;
      }

      .card label {
        font-size: 0.85rem;
      }

      .event-title,
      .event-meta,
      .event-date {
        font-size: 0.8rem;
      }

      .events-header {
        font-size: 1.1rem;
      }
    }

    @media (max-width: 992px) {
      .right-editor-container {
        margin-left: 0;
        width: 100%;
      }
    }

    /* Overlay background when sidebar is open */
    .sidebar-overlay {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      /* dim effect */
      z-index: 999;
      display: none;
    }

    body.sidebar-open .sidebar-overlay {
      display: block;
    }

    .left-editor-container {
      top: 0;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }
  </style>

</head>



<body>



  <!-- Mobile menu toggle button -->
  <button class="mobile-menu-toggle" id="mobileMenuToggle">
    <i class="fas fa-bars"></i> Menu
  </button>

  <div class="main-container">
    <div class="left-editor-container" id="sidebar">
      <?php include 'admin-side-bar.php'; ?>
    </div>

    <div class="right-editor-container">

      <div class="page-header">

        <h1>Settings</h1>

        <p>Manage site configuration and content</p>

      </div>

      <div class="main-content">

        <?php if (isset($_SESSION['success'])): ?>

          <div class="success"><?= htmlspecialchars($_SESSION['success']);

                                unset($_SESSION['success']); ?></div>

        <?php endif; ?>



        <?php if (isset($_SESSION['error'])): ?>

          <div class="error"><?= htmlspecialchars($_SESSION['error']);

                              unset($_SESSION['error']); ?></div>

        <?php endif; ?>



        <div class="form-columns">



          <!-- Change Article Highlights -->

          <!-- Manage Article Highlights -->

          <form class="card" method="POST" action="php-backend/admin-update-highlight.php">

            <h3>Manage Highlighted Articles</h3>



            <div class="form-group">

              <label for="article-search">Search Articles:</label>

              <input type="text" id="article-search" placeholder="Search by title..." class="search-input">

            </div>



            <div class="articles-list" id="articles-container">

              <!-- Articles will be loaded here via JavaScript -->

              <div class="loading-spinner"></div>

            </div>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Highlights</button>

            </div>

          </form>



          <!-- Mail Configuration -->

          <form class="card" method="POST" action="admin-settings.php?group=mail">

            <h2>Mail Configuration</h2>

            <label for="mail-email">Email Address</label>

            <input type="email" id="mail-email" name="mail-email" value="<?= htmlspecialchars($siteSettings['mail']['email'] ?? '') ?>" required>



            <label for="mail-password">App Password</label>

            <input type="password" id="mail-password" name="mail-password" value="<?= htmlspecialchars($siteSettings['mail']['password'] ?? '') ?>" required>



            <label for="mail-name">Sender Name</label>

            <input type="text" id="mail-name" name="mail-name" value="<?= htmlspecialchars($siteSettings['mail']['sender_name'] ?? '') ?>" required>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Mail Settings</button>

            </div>

          </form>



          <!-- Social Media -->

          <form class="card" method="POST" action="admin-settings.php?group=social">

            <h2>Social Media</h2>

            <label for="facebook">Facebook URL</label>

            <input type="url" id="facebook" name="facebook" value="<?= htmlspecialchars($siteSettings['social']['facebook_url'] ?? '') ?>">



            <label for="instagram">Instagram URL</label>

            <input type="url" id="instagram" name="instagram" value="<?= htmlspecialchars($siteSettings['social']['instagram_url'] ?? '') ?>">



            <label for="pinterest">Pinterest URL</label>

            <input type="url" id="pinterest" name="pinterest" value="<?= htmlspecialchars($siteSettings['social']['pinterest_url'] ?? '') ?>">



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Social Media</button>

            </div>

          </form>



          <!-- Site Information -->

          <form class="card" method="POST" action="admin-settings.php?group=contact">

            <h2>Site Information</h2>

            <label for="address">Address</label>

            <input type="text" id="address" name="address" value="<?= htmlspecialchars($siteSettings['contact']['address'] ?? '') ?>">



            <label for="open_time_start">School Opens At</label>

            <input type="time" id="open_time_start" name="open_time_start"

              value="<?= isset($siteSettings['contact']['open_time_start']) ? htmlspecialchars(substr($siteSettings['contact']['open_time_start'], 0, 5)) : '' ?>">



            <label for="open_time_end">School Closes At</label>

            <input type="time" id="open_time_end" name="open_time_end"

              value="<?= isset($siteSettings['contact']['open_time_end']) ? htmlspecialchars(substr($siteSettings['contact']['open_time_end'], 0, 5)) : '' ?>">



            <label for="phone">Phone</label>

            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($siteSettings['contact']['phone'] ?? '') ?>">



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Site Info</button>

            </div>

          </form>



          <!-- About Page Content -->

          <form class="card" method="POST" action="admin-settings.php?section=banner">

            <h2>About Page Banner</h2>

            <label for="banner-video">Banner Video URL</label>

            <input type="url" id="banner-video" name="video_url"

              value="<?= htmlspecialchars($aboutSettings['banner']['video_url'] ?? '') ?>">

            <p class="path-hint">Must be a full URL (https://...)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Banner</button>

            </div>

          </form>



          <!-- [Rest of your form cards continue in the same single column layout] -->

          <!-- What is Lundayan -->

          <form class="card" method="POST" action="admin-settings.php?section=what_is">

            <h2>What is Lundayan</h2>

            <label for="what-is-title">Title</label>

            <input type="text" id="what-is-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['what_is']['title'] ?? 'What even is the Lundayan website?') ?>">



            <label for="what-is-content">Content</label>

            <textarea id="what-is-content" name="content" rows="6"><?=

                                                                    htmlspecialchars($aboutSettings['what_is']['content'] ?? 'Lundayan is an article publication platform...') ?></textarea>



            <label for="what-is-image">Image URL or Path</label>

            <input type="text" id="what-is-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['what_is']['image_url'] ?? 'pics/lundayan-logo.png') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Section</button>

            </div>

          </form>



          <!-- [Continue with all other form sections in the same single column format] -->

          <!-- Mission Section -->

          <form class="card" method="POST" action="admin-settings.php?section=mission">

            <h2>Our Mission</h2>

            <label for="mission-title">Title</label>

            <input type="text" id="mission-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['mission']['title'] ?? 'What is our mission?') ?>">



            <label for="mission-content">Content</label>

            <textarea id="mission-content" name="content" rows="6"><?=

                                                                    htmlspecialchars($aboutSettings['mission']['content'] ?? 'Our mission is to promote thoughtful discourse...') ?></textarea>



            <label for="mission-image">Image URL or Path</label>

            <input type="text" id="mission-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['mission']['image_url'] ?? 'pics/thinker.jpg') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Section</button>

            </div>

          </form>



          <!-- Who We Are -->

          <form class="card" method="POST" action="admin-settings.php?section=who_we_are">

            <h2>Who We Are</h2>

            <label for="who-we-are-title">Title</label>

            <input type="text" id="who-we-are-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['who_we_are']['title'] ?? 'Who are we?') ?>">



            <label for="who-we-are-content">Content</label>

            <textarea id="who-we-are-content" name="content" rows="6"><?=

                                                                      htmlspecialchars($aboutSettings['who_we_are']['content'] ?? 'We are student storytellers from...') ?></textarea>



            <label for="who-we-are-image">Image URL or Path</label>

            <input type="text" id="who-we-are-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['who_we_are']['image_url'] ?? 'pics/study-anime.gif') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Section</button>

            </div>

          </form>



          <!-- Roles Section -->

          <form class="card" method="POST" action="admin-settings.php?section=roles">

            <h2>Roles Section</h2>

            <label for="roles-title">Title</label>

            <input type="text" id="roles-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['roles']['title'] ?? 'What do we do?') ?>">



            <label for="roles-content">Intro Content</label>

            <textarea id="roles-content" name="content" rows="3"><?=

                                                                  htmlspecialchars($aboutSettings['roles']['content'] ?? '') ?></textarea>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Section</button>

            </div>

          </form>



          <!-- Writer Role -->

          <form class="card" method="POST" action="admin-settings.php?section=role_writer">

            <h3>Writer Role</h3>

            <label for="writer-title">Title</label>

            <input type="text" id="writer-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['role_writer']['title'] ?? 'Writer') ?>">



            <label for="writer-content">Description</label>

            <textarea id="writer-content" name="content" rows="3"><?=

                                                                  htmlspecialchars($aboutSettings['role_writer']['content'] ?? 'Writers contribute original articles...') ?></textarea>



            <label for="writer-image">Image URL or Path</label>

            <input type="text" id="writer-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['role_writer']['image_url'] ?? 'pics/typewriter.jpg') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Role</button>

            </div>

          </form>



          <!-- Reviewer Role -->

          <form class="card" method="POST" action="admin-settings.php?section=role_reviewer">

            <h3>Reviewer Role</h3>

            <label for="reviewer-title">Title</label>

            <input type="text" id="reviewer-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['role_reviewer']['title'] ?? 'Reviewer') ?>">



            <label for="reviewer-content">Description</label>

            <textarea id="reviewer-content" name="content" rows="3"><?=

                                                                    htmlspecialchars($aboutSettings['role_reviewer']['content'] ?? 'Reviewers ensure each piece meets...') ?></textarea>



            <label for="reviewer-image">Image URL or Path</label>

            <input type="text" id="reviewer-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['role_reviewer']['image_url'] ?? 'pics/reviewer.jpg') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Role</button>

            </div>

          </form>



          <!-- Reader Role -->

          <form class="card" method="POST" action="admin-settings.php?section=role_reader">

            <h3>Reader Role</h3>

            <label for="reader-title">Title</label>

            <input type="text" id="reader-title" name="title"

              value="<?= htmlspecialchars($aboutSettings['role_reader']['title'] ?? 'Reader') ?>">



            <label for="reader-content">Description</label>

            <textarea id="reader-content" name="content" rows="3"><?=

                                                                  htmlspecialchars($aboutSettings['role_reader']['content'] ?? 'Readers enjoy fresh, meaningful...') ?></textarea>



            <label for="reader-image">Image URL or Path</label>

            <input type="text" id="reader-image" name="image_url"

              value="<?= htmlspecialchars($aboutSettings['role_reader']['image_url'] ?? 'pics/reader.jpg') ?>">

            <p class="path-hint">Accept both full URLs (https://...) and local paths (pics/image.jpg or images/photo.png)</p>



            <div class="card-footer">

              <button type="submit" class="save-btn">Save Role</button>

            </div>

          </form>



          <!-- Announcements Widget Iframe Generator -->

          <div class="card">

            <h2>Embeddable Announcements Widget</h2>



            <div class="form-group">

              <label>Live Preview:</label>

              <div id="live-preview-container" style="border: 1px dashed #ccc; padding: 10px; border-radius: 5px; margin-bottom: 15px; background: #f8f9fa; min-height: 300px;">

                <iframe id="live-preview" src="announcements-widget.php?limit=5&layout=column" width="100%" height="300" frameborder="0" style="border:none;"></iframe>

              </div>

            </div>



            <div class="form-group">

              <label>Layout Style:</label>

              <div class="toggle-container" style="display: flex; align-items: center; margin-bottom: 15px;">

                <span style="margin-right: 10px;">Column</span>

                <label class="toggle-switch">

                  <input type="checkbox" id="layout-toggle">

                  <span class="slider"></span>

                </label>

                <span style="margin-left: 10px;">Row</span>

              </div>

            </div>



            <div class="form-group">

              <label for="iframe-width">Width:</label>

              <select id="iframe-width" class="form-control">

                <option value="100%">100% (Full width)</option>

                <option value="800px">800px</option>

                <option value="600px">600px</option>

                <option value="400px">400px</option>

                <option value="custom">Custom</option>

              </select>

              <input type="text" id="custom-width" style="display:none; margin-top:5px;" placeholder="e.g. 750px">

            </div>



            <div class="form-group">

              <label for="iframe-height">Height:</label>

              <input type="text" id="iframe-height" class="form-control" value="300px">

            </div>



            <div class="form-group">

              <label for="iframe-limit">Number of Announcements:</label>

              <input type="number" id="iframe-limit" class="form-control" value="5" min="1" max="10">

            </div>



            <div class="form-group">

              <label>Embed Code:</label>

              <textarea id="iframe-code" rows="4" class="form-control" readonly></textarea>

            </div>



            <div class="card-footer">

              <button type="button" id="generate-iframe" class="save-btn">Generate Code</button>

              <button type="button" id="copy-iframe" class="save-btn">Copy Code</button>

            </div>

          </div>

          <div class="card">

            <h2>Upcoming Events Widget</h2>



            <div class="form-group">

              <label>Live Preview:</label>

              <div id="events-preview-container" style="border: 1px dashed #ccc; padding: 10px; border-radius: 5px; margin-bottom: 15px; background: white;">

                <iframe id="events-preview" src="events-widget.php?view=list&limit=5&startdate=<?php echo date('Y-m-d'); ?>" width="100%" height="500" frameborder="0" style="border:none;"></iframe>

              </div>

            </div>



            <div class="form-group">

              <label>Default View:</label>

              <select id="view-select" class="form-control" style="margin-bottom: 15px;">

                <option value="list">List View (Upcoming Events)</option>

                <option value="calendar">Calendar View</option>

              </select>

            </div>



            <div class="form-group">

              <label>Number of Events:</label>

              <select id="limit-select" class="form-control" style="margin-bottom: 15px;">

                <option value="5">Show 5</option>

                <option value="10">Show 10</option>

                <option value="20">Show 20</option>

                <option value="all">Show All</option>

              </select>

            </div>



            <div class="form-group">

              <label>Start Date:</label>

              <input type="date" id="start-date" class="form-control" style="margin-bottom: 15px;" value="<?php echo date('Y-m-d'); ?>">

            </div>



            <div class="form-group">

              <label>Width:</label>

              <select id="width-select" class="form-control" style="margin-bottom: 15px;">

                <option value="100%">100% (Full width)</option>

                <option value="800px">800px</option>

                <option value="600px">600px</option>

                <option value="400px">400px</option>

                <option value="custom">Custom</option>

              </select>

              <input type="text" id="custom-width" style="display:none; margin-top:5px;" placeholder="e.g. 750px or 80%">

            </div>



            <div class="form-group">

              <label>Height:</label>

              <input type="text" id="height-input" class="form-control" style="margin-bottom: 15px;" value="500px">

              <p class="path-hint">Use "auto" for list view to expand with content, or specific height like "500px"</p>

            </div>



            <div class="form-group">

              <label>Embed Code:</label>

              <textarea id="embed-code" class="form-control" rows="4" readonly style="font-family: monospace; margin-bottom: 15px;"></textarea>

              <button id="copy-embed" class="save-btn">Copy Code</button>

            </div>

          </div>











        </div>

      </div>

    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileToggle = document.getElementById('mobileMenuToggle');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const body = document.body;

      // Initialize sidebar state
      function initSidebar() {
        if (window.innerWidth > 992) {
          sidebar.classList.add('active');
          mainContent.classList.add('shifted');
        }
      }

      // Toggle sidebar
      mobileToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('active');
        body.classList.toggle('sidebar-open');

        // Change icon
        const icon = this.querySelector('i');
        if (sidebar.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });

      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992 &&
          !sidebar.contains(e.target) &&
          e.target !== mobileToggle &&
          sidebar.classList.contains('active')) {
          closeSidebar();
        }
      });

      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
          sidebar.classList.add('active');
          mainContent.classList.add('shifted');
        } else {
          if (sidebar.classList.contains('active')) {
            mainContent.classList.remove('shifted');
          }
        }
      });

      function closeSidebar() {
        sidebar.classList.remove('active');
        body.classList.remove('sidebar-open');
        const icon = mobileToggle.querySelector('i');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }

      // Initialize
      initSidebar();
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const viewSelect = document.getElementById('view-select');

      const limitSelect = document.getElementById('limit-select');

      const startDate = document.getElementById('start-date');

      const widthSelect = document.getElementById('width-select');

      const customWidth = document.getElementById('custom-width');

      const heightInput = document.getElementById('height-input');

      const previewIframe = document.getElementById('events-preview');

      const embedCode = document.getElementById('embed-code');

      const copyButton = document.getElementById('copy-embed');



      // Toggle custom width field

      widthSelect.addEventListener('change', function() {

        customWidth.style.display = this.value === 'custom' ? 'block' : 'none';

        updateWidget();

      });



      function updateWidget() {

        const view = viewSelect.value;

        const limit = limitSelect.value;

        const date = startDate.value;

        let width = widthSelect.value;

        if (width === 'custom') width = customWidth.value || '100%';

        const height = heightInput.value || (view === 'list' ? 'auto' : '500px');



        // Update iframe preview

        previewIframe.src = `events-widget.php?view=${view}&limit=${limit}&startdate=${date}&width=${width}&height=${height}`;



        // Update preview container size

        document.getElementById('events-preview-container').style.height = height === 'auto' ? 'auto' : height;



        // Update embed code

        const code = `<iframe src="events-widget.php?view=${view}&limit=${limit}&startdate=${date}&width=${width}&height=${height}" width="${width}" height="${height}" frameborder="0" style="border:none;"></iframe>`;

        embedCode.value = code;

      }



      viewSelect.addEventListener('change', updateWidget);

      limitSelect.addEventListener('change', updateWidget);

      startDate.addEventListener('change', updateWidget);

      widthSelect.addEventListener('change', updateWidget);

      customWidth.addEventListener('input', updateWidget);

      heightInput.addEventListener('input', updateWidget);



      copyButton.addEventListener('click', function() {

        embedCode.select();

        document.execCommand('copy');

        copyButton.textContent = 'Copied!';

        setTimeout(() => {

          copyButton.textContent = 'Copy Code';

        }, 2000);

      });



      // Initialize

      updateWidget();

    });
  </script>





  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const themeSelect = document.getElementById('theme-select');

      const sizeRadios = document.querySelectorAll('input[name="size"]');

      const previewIframe = document.getElementById('calendar-preview');

      const embedCode = document.getElementById('embed-code');

      const copyButton = document.getElementById('copy-embed');



      // Update preview and embed code when options change

      function updateWidget() {

        const theme = themeSelect.value;

        const size = document.querySelector('input[name="size"]:checked').value;



        // Update iframe preview

        previewIframe.src = `calendar-widget.php?theme=${theme}&size=${size}`;



        // Update embed code

        const code = `<iframe src="calendar-widget.php?theme=${theme}&size=${size}" width="${getWidth(size)}" height="${getHeight(size)}" frameborder="0" style="border:none;"></iframe>`;

        embedCode.value = code;

      }



      // Helper functions for size dimensions

      function getWidth(size) {

        switch (size) {

          case 'small':
            return '300';

          case 'medium':
            return '500';

          case 'large':
            return '700';

          default:
            return '500';

        }

      }



      function getHeight(size) {

        switch (size) {

          case 'small':
            return '300';

          case 'medium':
            return '400';

          case 'large':
            return '500';

          default:
            return '400';

        }

      }



      // Event listeners

      themeSelect.addEventListener('change', updateWidget);

      sizeRadios.forEach(radio => {

        radio.addEventListener('change', updateWidget);

      });



      copyButton.addEventListener('click', function() {

        embedCode.select();

        document.execCommand('copy');

        copyButton.textContent = 'Copied!';

        setTimeout(() => {

          copyButton.textContent = 'Copy Code';

        }, 2000);

      });



      // Initialize

      updateWidget();

    });
  </script>



  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const widthSelect = document.getElementById('iframe-width');

      const customWidth = document.getElementById('custom-width');

      const heightInput = document.getElementById('iframe-height');

      const limitInput = document.getElementById('iframe-limit');

      const layoutToggle = document.getElementById('layout-toggle');

      const iframeCode = document.getElementById('iframe-code');

      const livePreview = document.getElementById('live-preview');



      // Toggle custom width field

      widthSelect.addEventListener('change', function() {

        customWidth.style.display = this.value === 'custom' ? 'block' : 'none';

        updateIframe();

      });



      // Update both preview and code

      function updateIframe() {

        let width = widthSelect.value;

        if (width === 'custom') width = customWidth.value || '100%';

        const height = heightInput.value || '300px';

        const limit = limitInput.value || '5';

        const layout = layoutToggle.checked ? 'row' : 'column';



        // Update live preview

        livePreview.src = `announcements-widget.php?limit=${limit}&layout=${layout}`;

        livePreview.style.width = width;

        livePreview.style.height = height;



        // Update embed code with correct localhost path

        const basePath = 'announcements-widget.php';

        const code = `<iframe src="${basePath}?limit=${limit}&layout=${layout}" width="${width}" height="${height}" frameborder="0" style="border:none; background-color: white; border-radius: 0.5rem"></iframe>`;

        iframeCode.value = code;



        // Adjust preview container height

        document.getElementById('live-preview-container').style.minHeight = height;

      }



      // Copy to clipboard

      document.getElementById('copy-iframe').addEventListener('click', function() {

        iframeCode.select();

        document.execCommand('copy');

        this.textContent = 'Copied!';

        setTimeout(() => this.textContent = 'Copy Code', 2000);

      });



      // Generate on any change

      [widthSelect, customWidth, heightInput, limitInput, layoutToggle].forEach(el => {

        el.addEventListener('change', updateIframe);

        el.addEventListener('input', updateIframe);

      });



      // Initial update

      updateIframe();

    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Get all image URL inputs

      const imageInputs = document.querySelectorAll('input[name="image_url"]');



      imageInputs.forEach(input => {

        input.addEventListener('change', function() {

          const value = this.value.trim();

          if (value && !value.match(/^(https?:\/\/|\/|pics\/|images\/)/i)) {

            alert('Please enter either:\n- A full URL starting with http:// or https://\n- A local path starting with pics/ or images/');

          }

        });

      });



      // For video URLs, ensure they're full URLs

      const videoInputs = document.querySelectorAll('input[name="video_url"]');

      videoInputs.forEach(input => {

        input.addEventListener('change', function() {

          const value = this.value.trim();

          if (value && !value.match(/^https?:\/\//i)) {

            alert('Video URL must be a full URL starting with http:// or https://');

            this.value = '';

          }

        });

      });

    });
  </script>



  <!-- Sanitize Input Boxes -->

  <script>
    function sanitizeInputText(text) {

      // Normalize to remove full-width/bold/special formatting

      text = text.normalize("NFKC");



      // Remove invisible/control characters EXCEPT:

      // - Tab (\u0009)

      // - Newline (\u000A)

      // - Carriage return (\u000D)

      text = text.replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F\u007F]+/g, "");



      // Remove private-use Unicode characters

      text = text.replace(/[\u{E000}-\u{F8FF}\u{F0000}-\u{FFFFD}\u{100000}-\u{10FFFD}]/gu, "");



      // Allow only one space

      text = text.replace(/\s+/g, ' ');



      // DO NOT trim here if you want to allow intentional leading/trailing spaces

      return text;

    }





    // Attach the sanitizer to inputs and textareas

    function attachSanitizerToInputs() {

      const inputs = document.querySelectorAll("input[type='text'], textarea, input[type='url']");



      inputs.forEach(input => {

        input.addEventListener('input', () => {

          const original = input.value;

          const cleaned = sanitizeInputText(original);

          if (original !== cleaned) {

            input.value = cleaned;

          }

        });



        input.addEventListener('paste', (e) => {

          e.preventDefault();

          const pastedText = (e.clipboardData || window.clipboardData).getData('text');

          const cleaned = sanitizeInputText(pastedText);

          document.execCommand("insertText", false, cleaned);

        });

      });

    }



    document.addEventListener('DOMContentLoaded', attachSanitizerToInputs);
  </script>



  <!-- Article Highlight script -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Load all articles

      fetchArticles();



      // Search functionality

      document.getElementById('article-search').addEventListener('input', function(e) {

        const searchTerm = e.target.value.toLowerCase();

        const articles = document.querySelectorAll('.article-item');



        articles.forEach(article => {

          const title = article.querySelector('.article-title').textContent.toLowerCase();

          if (title.includes(searchTerm)) {

            article.style.display = 'flex';

          } else {

            article.style.display = 'none';

          }

        });

      });

    });



    function fetchArticles() {

      const container = document.getElementById('articles-container');

      container.innerHTML = '<div class="loading-spinner"></div>';



      fetch('php-backend/get-all-articles.php')

        .then(response => response.json())

        .then(articles => {

          container.innerHTML = '';



          if (articles.length === 0) {

            container.innerHTML = '<p class="no-articles">No published articles found</p>';

            return;

          }



          articles.forEach(article => {

            const articleEl = document.createElement('div');

            articleEl.className = 'article-item';

            articleEl.innerHTML = `

          <div class="article-info">

            <div class="article-title">${article.widget_title || article.article_title}</div>

            <div class="article-date">Posted: ${new Date(article.date_posted).toLocaleDateString()}</div>

          </div>

          <div class="highlight-toggle">

            <span>Highlight:</span>

            <label class="toggle-switch">

              <input type="checkbox" name="highlight[${article.article_id}]" 

                ${article.highlight == 1 ? 'checked' : ''}>

              <span class="slider"></span>

            </label>

          </div>

        `;

            container.appendChild(articleEl);

          });

        })

        .catch(error => {

          console.error('Error:', error);

          container.innerHTML = '<p class="error-message">Failed to load articles. Please try again.</p>';

        });

    }
  </script>



  <!-- <script src="scripts/menu_button-admin.js"></script> -->

</body>



</html>
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

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar styling */
    .left-editor-container {
      flex: 0 0 250px;
      background: #222;
      height: 100vh;
      overflow-y: auto;
    }

    /* Main content area */
    .right-editor-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow-y: auto;
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
    }

    /* Modern Black & White Card Styles */
    .card {
      background: white;
      border-radius: 8px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.08);
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
      box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
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
    .success, .error {
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
  </style>
</head>

<body>
  <div class="left-editor-container">
    <?php include 'admin-side-bar.php'; ?>
  </div>
  
  <div class="right-editor-container">
    <div class="page-header">
      <h1>Settings</h1>
      <p>Manage site configuration and content</p>
    </div>
    
    <div class="main-content">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <div class="form-columns">
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
      </div>
    </div>
  </div>

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
  <script src="scripts/menu_button-admin.js"></script>
</body>
</html>
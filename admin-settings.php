<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Settings - Lundayan Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f0f2f5;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #0F5132;
      color: #ecf0f1;
      padding: 20px;
      height: 100vh;
      position: sticky;
      top: 0;
      overflow-y: auto;
    }

    .sidebar h2 {
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 15px 0;
    }

    .sidebar ul li a {
      color: #ecf0f1;
      text-decoration: none;
      display: block;
      padding: 8px 0;
    }

    .sidebar ul li a:hover {
      text-decoration: underline;
    }

    main.settings-content {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
    }

    header h1 {
      margin-bottom: 20px;
    }

    .success {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 4px;
      max-width: 700px;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 4px;
      max-width: 700px;
    }

    .form-columns {
      display: flex;
      gap: 20px;
      max-width: 1440px;
      margin-bottom: 30px;
    }

    .column {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .card {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card h2 {
      margin-bottom: 15px;
      border-bottom: 2px solid #3498db;
      padding-bottom: 5px;
      color: #2980b9;
    }

    .card h3 {
      margin-top: 20px;
      margin-bottom: 10px;
      color: #34495e;
    }

    .card label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .card input,
    .card select,
    .card textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-family: inherit;
      font-size: 1rem;
    }

    .card input:focus,
    .card select:focus,
    .card textarea:focus {
      outline: none;
      border-color: #3498db;
    }

    .card-footer {
      display: flex;
      justify-content: flex-end;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid #eee;
    }
    
    .save-btn {
      background-color: #0F5132;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9rem;
    }
    
    .save-btn:hover {
      background-color: #0d462a;
    }

    .path-hint {
      font-size: 0.8em; 
      color: #666;
      margin-top: -10px;
      margin-bottom: 10px;
    }

    @media (max-width: 900px) {
      .form-columns {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <?php include 'admin-side-bar.php' ?>

  <main class="settings-content">
    <header>
      <h1>Settings</h1>
    </header>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="form-columns">
      <!-- LEFT COLUMN -->
      <div class="column">
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
      </div>

      <!-- RIGHT COLUMN -->
      <div class="column">
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
      </div>
    </div>

    <!-- About Page Content Management -->
    <div class="form-columns">
      <!-- LEFT COLUMN -->
      <div class="column">
        <!-- Banner Settings -->
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
      </div>

      <!-- RIGHT COLUMN -->
      <div class="column">
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
  </main>

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
</body>
</html>
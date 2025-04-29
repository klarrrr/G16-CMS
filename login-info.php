<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Information</title>
  <link rel="stylesheet" href="login-info.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <!-- Navigation -->
  <?php include 'nav_dashboard.php' ?>

  <div class="main-container">
    <div class="settings-choices">
      <h3>Account Settings</h3>
      
      <ul>
        <li><a href="profileSettings.php">Personal Information</a></li>
        <li> <a href="login-info.php">Username & Password</a></li>
        <li>Notification</li>
        <li>Connected Accounts</li>
      </ul>
    </div>

    <!-- Login Info -->
    <div class="container">
      <h2>Login Info</h2>
      
      <div class="info-section">
        <p class="info-title">Account email:</p>
        <div class="email-input">
          <input type="text" id="myEmailInput" disabled>
          <button onclick="enableEmailInput()" class='bx bxs-edit'></button>
        </div>
        <div class="confirmed">Confirmed</div>
      </div>
      
      <div class="info-section">
        <p class="info-title">Password:</p>
        <div class="password-input">
          <input type="password" id="myPassInput" disabled>
          <button onclick="openModal()" class='bx bxs-edit'></button>
        </div>

        <!-- Modal container with iframe -->
        <div id="popupModal" class="modal">
          <div class="iframe-wrapper">
            <iframe src="change-pass.php" frameborder="0"></iframe>
          </div>
        </div>

        <button onclick="disableAllInput()" id="save-button" class="save-btn">Save Changes</button>
      </div>
    </div>
  </div>

  <script src="on-click.js" defer></script>
</body>
</html>
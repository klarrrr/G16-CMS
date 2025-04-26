<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Information</title>
  <link rel="stylesheet" href="login-info.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="container">
    <h2>Login Info</h2>
    
    <div class="info-section">
      <p class="info-title">Account email:</p>
      <div class="email-input">
        <input type="text" id="myInput" disabled>
        <button onclick="enableInput()" class='bx bxs-edit'></button>
      </div>
      <div class="confirmed">Confirmed</div>
    </div>
    
    <div class="info-section">
      <p class="info-title">Password:</p>
      <div class="password-input">
        <input type="password" id="myPassInput" disabled>
        <button onclick="enableInput()" class='bx bxs-edit'></button>
      </div>
      <button class="save-btn">Save Changes</button>
    </div>
  
  </div>
  <script src="on-click.js" defer></script>
</body>
</html>
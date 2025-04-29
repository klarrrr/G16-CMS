<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="change-password.css">
</head>
<body>
  <div class="container">
    <h2>Change Password</h2>
    <form action="change_password.php" method="POST">
      <div class="form-group">
        <label class="required">Current Password</label>
        <input type="password" name="current_password" required>
      </div>
      <div class="form-group">
        <label class="required">New Password</label>
        <input type="password" name="new_password" required>
      </div>
      <div class="form-group">
        <label class="required">Verify New Password</label>
        <input type="password" name="confirm_password" required>
      </div>
      <div class="form-group requirements">
        <strong>Password Requirements</strong><br>
        Passwords must be at least 8 characters long.<br>
        Passwords must include at least 1 non-alphabetical character.<br>
        Passwords are case-sensitive<br>
        Password must be with at least STRONG strength.
      </div>
      <div class="buttons">
        <button type="submit" class="save">Save</button>
        <button type="button" class="cancel" onclick="window.parent.closeModal()">Cancel</button>
      </div>
    </form>
  </div>
  
  <script src="on-click.js" defer></script>
</body>
</html>

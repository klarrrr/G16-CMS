<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Manage Users - Lundayan Dashboard</title>
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

    html, body {
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
      min-height: 0; /* Fix for flexbox scrolling */
    }

    /* Sidebar styling */
    .left-editor-container {
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

    /* User Grid Styles */
    .user-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
    }

    .user-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid #e0e0e0;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .user-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-cover-photo {
      width: 100%;
      height: 120px;
      background-color: #e1e1e1;
      position: relative;
      overflow: hidden;
    }

    .user-cover-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .user-details {
      padding: 1rem;
      display: flex;
      gap: 1rem;
    }

    .user-profile-pic {
      height: 60px;
      width: 60px;
      border-radius: 50%;
      background-color: #e1e1e1;
      border: 3px solid white;
      margin-top: -30px;
      position: relative;
      overflow: hidden;
    }

    .user-profile-pic img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .user-info {
      flex: 1;
    }

    .user-name {
      font-size: 1.1rem;
      font-weight: bold;
      margin-bottom: 0.3rem;
    }

    .user-email {
      font-size: 0.9rem;
      color: #666;
    }

    .user-type {
      display: inline-block;
      padding: 0.2rem 0.5rem;
      background: #222;
      color: #f4f4f4;
      border-radius: 4px;
      font-size: 0.7rem;
      margin-top: 0.5rem;
      text-transform: capitalize;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal.active {
      display: flex;
    }

    .modal-content {
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .modal-content h2 {
      margin-bottom: 1rem;
    }

    .modal-content input,
    .modal-content select {
      width: 100%;
      padding: 0.6rem;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .modal-actions {
      text-align: right;
    }

    .modal-actions button {
      padding: 0.5rem 1rem;
      margin-left: 0.5rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .cancel-btn {
      background: #ccc;
      color: #333;
    }

    .cancel-btn:hover {
      background: #bbb;
    }

    .add-user-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #222;
      color: white;
      font-size: 1.5rem;
      border: none;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .add-user-btn:hover {
      background: #111;
      transform: translateY(-2px);
    }

    /* Fallback icon styles */
    .fallback-icon {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #888;
      font-size: 24px;
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

    /* Responsive adjustments */
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

      .user-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

      .user-grid {
        grid-template-columns: 1fr;
      }

      .add-user-btn {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
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

      .user-name {
        font-size: 1rem;
      }

      .user-email {
        font-size: 0.85rem;
      }

      .modal-content {
        padding: 1.5rem;
        margin: 0 1rem;
      }
    }

    .sidebar-overlay {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
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

    <div class="right-editor-container" id="mainContent">
      <div class="page-header">
        <div style='display:flex; flex-direction:column;'>
          <h1>Manage Users</h1>
          <p>Manage user configuration or add new users</p>
        </div>
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

        <div class="user-grid" id="userGrid">
          <!-- User cards will be injected here -->
          <div class="loading-spinner"></div>
        </div>
      </div>
    </div>
  </div>

  <button class="add-user-btn" onclick="openUserModal()">+</button>

  <div class="modal" id="userModal">
    <div class="modal-content">
      <h2 id="modalTitle">Edit User</h2>

      <input type="text" id="firstName" placeholder="First Name">
      <input type="text" id="lastName" placeholder="Last Name">
      <input type="email" id="email" placeholder="Email">
      <input type="password" id="password" placeholder="Password (leave blank to keep current)">
      <select id="userType">
        <option value="writer">Writer</option>
        <option value="reviewer">Reviewer</option>
      </select>

      <div class="modal-actions">
        <button class="cancel-btn" onclick="closeUserModal()">Cancel</button>
        <button class="save-btn" onclick="saveUser()">Save</button>
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
    let users = [];
    let editingUserId = null;

    function renderUsers() {
      const grid = document.getElementById('userGrid');
      grid.innerHTML = '<div class="loading-spinner"></div>';

      $.ajax({
        url: 'php-backend/admin-populate-users.php',
        type: 'POST',
        dataType: 'json',
        success: (res) => {
          users = res;
          grid.innerHTML = '';

          if (res.length === 0) {
            grid.innerHTML = '<p class="no-users">No users found</p>';
            return;
          }

          res.forEach(user => {
            const card = document.createElement('div');
            card.className = 'user-card';
            card.onclick = () => openUserModal(user.user_id);

            // Create cover photo container
            const coverPhotoDiv = document.createElement('div');
            coverPhotoDiv.className = 'user-cover-photo';
            if (user.cover_photo) {
              const coverImg = document.createElement('img');
              coverImg.src = user.cover_photo;
              coverImg.alt = 'Cover Photo';
              coverImg.onerror = function() {
                this.style.display = 'none';
                const fallback = document.createElement('div');
                fallback.className = 'fallback-icon';
                fallback.innerHTML = '📷';
                coverPhotoDiv.appendChild(fallback);
              };
              coverPhotoDiv.appendChild(coverImg);
            } else {
              const fallback = document.createElement('div');
              fallback.className = 'fallback-icon';
              fallback.innerHTML = '🏞️';
              coverPhotoDiv.appendChild(fallback);
            }

            // Create profile picture container
            const profilePicDiv = document.createElement('div');
            profilePicDiv.className = 'user-profile-pic';
            if (user.profile_picture) {
              const profileImg = document.createElement('img');
              profileImg.src = user.profile_picture;
              profileImg.alt = 'Profile Picture';
              profileImg.onerror = function() {
                this.style.display = 'none';
                const fallback = document.createElement('div');
                fallback.className = 'fallback-icon';
                fallback.innerHTML = '👤';
                profilePicDiv.appendChild(fallback);
              };
              profilePicDiv.appendChild(profileImg);
            } else {
              const fallback = document.createElement('div');
              fallback.className = 'fallback-icon';
              fallback.innerHTML = '👤';
              profilePicDiv.appendChild(fallback);
            }

            // Create user details
            const userDetailsDiv = document.createElement('div');
            userDetailsDiv.className = 'user-details';
            userDetailsDiv.appendChild(profilePicDiv);

            const userInfoDiv = document.createElement('div');
            userInfoDiv.className = 'user-info';
            userInfoDiv.innerHTML = `
              <div class="user-name">${user.user_first_name} ${user.user_last_name}</div>
              <div class="user-email">${user.user_email}</div>
              <div class="user-type">${user.user_type}</div>
            `;
            userDetailsDiv.appendChild(userInfoDiv);

            // Assemble the card
            card.appendChild(coverPhotoDiv);
            card.appendChild(userDetailsDiv);

            grid.appendChild(card);
          });
        },
        error: (error) => {
          console.error('Error fetching users:', error);
          grid.innerHTML = '<p class="error-message">Failed to load users. Please try again.</p>';
        }
      });
    }

    function openUserModal(userId = null) {
      const modal = document.getElementById('userModal');
      modal.classList.add('active');

      if (userId) {
        editingUserId = userId;
        const user = users.find(u => u.user_id === userId);
        document.getElementById('modalTitle').innerText = 'Edit User';
        document.getElementById('firstName').value = user.user_first_name;
        document.getElementById('lastName').value = user.user_last_name;
        document.getElementById('email').value = user.user_email;
        document.getElementById('userType').value = user.user_type;
        document.getElementById('password').value = '';
        document.getElementById('password').placeholder = 'Password (leave blank to keep current)';
      } else {
        editingUserId = null;
        document.getElementById('modalTitle').innerText = 'Add User';
        document.getElementById('firstName').value = '';
        document.getElementById('lastName').value = '';
        document.getElementById('email').value = '';
        document.getElementById('userType').value = 'writer';
        document.getElementById('password').value = '';
        document.getElementById('password').placeholder = 'Password';
      }
    }

    function closeUserModal() {
      document.getElementById('userModal').classList.remove('active');
    }

    function saveUser() {
      const firstName = document.getElementById('firstName').value.trim();
      const lastName = document.getElementById('lastName').value.trim();
      const email = document.getElementById('email').value.trim();
      const userType = document.getElementById('userType').value;
      const password = document.getElementById('password').value.trim();

      if (!firstName || !lastName || !email || !userType) {
        alert('Please fill out all required fields');
        return;
      }

      const data = {
        user_id: editingUserId,
        first_name: firstName,
        last_name: lastName,
        email: email,
        user_type: userType
      };

      if (password) data.password = password;

      const url = editingUserId ? 'php-backend/update-user.php' : 'php-backend/add-user.php';

      $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: (response) => {
          if (response.success) {
            closeUserModal();
            renderUsers();
          } else {
            alert(response.message || 'Failed to save user');
          }
        },
        error: (err) => {
          console.error('Error saving user:', err);
          alert('Failed to save user. Please try again.');
        }
      });
    }

    // Initialize
    renderUsers();
  </script>

</body>

</html>
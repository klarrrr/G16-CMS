<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Manage Users</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 0;
      display: flex;
    }

    .sidebar {
      width: 250px;
      background-color: #0F5132;
      color: #ecf0f1;
      padding: 20px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
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

    main.manager-users {
      margin-left: 250px;
      padding: 2rem;
      width: calc(100% - 250px);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .user-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }

    .user-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.2s;
    }

    .user-card:hover {
      transform: translateY(-5px);
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
      color: gray;
    }

    .user-type {
      display: inline-block;
      padding: 0.2rem 0.5rem;
      background: #e1f5fe;
      color: #0288d1;
      border-radius: 4px;
      font-size: 0.8rem;
      margin-top: 0.5rem;
    }

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
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .modal-actions {
      text-align: right;
    }

    .modal-actions button {
      padding: 0.5rem 1rem;
      margin-left: 0.5rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .cancel-btn {
      background: #ccc;
    }

    .save-btn {
      background: #0F5132;
      color: white;
    }

    .add-user-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #0F5132;
      color: white;
      font-size: 2rem;
      border: none;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      z-index: 100;
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
  </style>
</head>

<body>

  <?php include 'admin-side-bar.php'; ?>

  <main class="manager-users">
    <div class="container">
      <div class="header">
        <h1>Manage Users</h1>
      </div>

      <div class="user-grid" id="userGrid">
        <!-- User cards will be injected here -->
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
  </main>

  <script>
    let users = [];
    let editingUserId = null;

    function renderUsers() {
      const grid = document.getElementById('userGrid');
      grid.innerHTML = '';

      $.ajax({
        url: 'php-backend/admin-populate-users.php',
        type: 'POST',
        dataType: 'json',
        success: (res) => {
          users = res;

          res.forEach(user => {
            const card = document.createElement('div');
            card.className = 'user-card';
            card.onclick = () => openUserModal(user.user_id);
            
            // Create cover photo container
            const coverPhotoDiv = document.createElement('div');
            coverPhotoDiv.className = 'user-cover-photo';
            if (user.cover_photo) {
              const coverImg = document.createElement('img');
              coverImg.src = 'data:image/png;base64,' + user.cover_photo;
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
              profileImg.src = 'data:image/png;base64,' + user.profile_picture;
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
      } else {
        editingUserId = null;
        document.getElementById('modalTitle').innerText = 'Add User';
        document.getElementById('firstName').value = '';
        document.getElementById('lastName').value = '';
        document.getElementById('email').value = '';
        document.getElementById('userType').value = 'writer';
        document.getElementById('password').value = '';
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
        success: () => {
          closeUserModal();
          renderUsers();
        },
        error: (err) => {
          console.error('Error saving user:', err);
          alert('Failed to save user.');
        }
      });
    }

    renderUsers();
  </script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Manage Users</title>
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <style>
    .manager-users {
      overflow-y: scroll;
      height: 100vh;
    }

    main.manager-users {
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

      * {
        font-family: sub;
      }
    }

    .user-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); */
      border: 1px solid lightgray;
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
      background: #14452F;
      color: #f4f4f4;
      border-radius: 4px;
      font-size: 0.7rem;
      margin-top: 0.5rem;
      text-transform: capitalize;
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

      * {
        font-family: sub;
      }
    }

    .modal-content h2 {
      margin-bottom: 1rem;
      font-family: main;
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

      &:hover {
        background-color: #bbb;
      }
    }

    .save-btn {
      background-color: #161616;
      color: #f4f4f4;
      border: 1px solid #161616 !important;

      &:hover {
        background-color: #f4f4f4;
        color: #161616;
      }
    }

    .add-user-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #161616;
      color: white;
      font-size: 2rem;
      border: none;
      width: 50px;
      height: 50px;
      border-radius: 5px;
      cursor: pointer;
      margin: 1rem;
      box-shadow: rgba(22, 22, 22, 0.4) 5px 5px,
        rgba(22, 22, 22, 0.3) 10px 10px,
        rgba(22, 22, 22, 0.2) 15px 15px,
        rgba(22, 22, 22, 0.1) 20px 20px,
        rgba(22, 22, 22, 0.05) 25px 25px;
      z-index: 100;

      &:hover {
        transform: scale(1.05);
        box-shadow: rgba(14, 63, 126, 0.04) 0px 0px 0px 1px, rgba(42, 51, 69, 0.04) 0px 1px 1px -0.5px, rgba(42, 51, 70, 0.04) 0px 3px 3px -1.5px, rgba(42, 51, 70, 0.04) 0px 6px 6px -3px, rgba(14, 63, 126, 0.04) 0px 12px 12px -6px, rgba(14, 63, 126, 0.04) 0px 24px 24px -12px;
      }
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
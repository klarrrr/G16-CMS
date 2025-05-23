<?php
session_start();
// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
        }

        .container {
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .user-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .user-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
            overflow: hidden;
        }

        .user-card:hover {
            transform: translateY(-5px);
        }

        .user-name {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .user-email {
            font-size: 0.9rem;
            color: gray;
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
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 1rem;
        }

        .modal-content input {
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
            background: #3498db;
            color: white;
        }

        .add-user-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2ecc71;
            color: white;
            font-size: 2rem;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .user_profile_pic {
            img {
                height: 50px;
            }
        }

        .user_cover_photo {
            img {
                max-height: 100px;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php include 'admin-side-bar.php' ?>

    <main class="manager-users">
        <div class="container">
            <div class="header">
                <h1>Manage Users</h1>
            </div>

            <div class="user-grid" id="userGrid">
                <!-- User cards will be injected here by JavaScript -->
            </div>
        </div>

        <!-- Floating Add User Button -->
        <button class="add-user-btn" onclick="openUserModal()">+</button>

        <!-- Edit/Add User Modal -->
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
        // Assuming `users` is a global variable to store fetched users
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
                    users = res; // Save users globally for reference

                    res.forEach(user => {
                        const card = document.createElement('div');
                        card.className = 'user-card';
                        card.onclick = () => openUserModal(user.user_id);
                        card.innerHTML = `
                    <div class="user-name">${user.user_first_name} ${user.user_last_name}</div>
                    <div class="user-email">${user.user_email}</div>
                    <div class="user-profile-pic">
                        <img src="${user.profile_picture ? 'data:image/png;base64,' + user.profile_picture : 'default-profile.png'}" alt="Profile Picture">
                    </div>
                    <div class="user-cover-photo">
                        <img src="${user.cover_photo ? 'data:image/png;base64,' + user.cover_photo : 'default-cover.png'}" alt="Cover Photo">
                    </div>
                `;
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

            if (password) {
                data.password = password;
            }

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

        // Initial call to populate users
        renderUsers();
    </script>

</body>

</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

if (strtolower($_SESSION['user_type']) == 'writer') {
    header('Location: editor-dashboard.php');
    exit;
}

include 'php-backend/connect.php';

$user_id = $_SESSION['user_id'];
$fname = $_SESSION['user_first'];
$lname = $_SESSION['user_last'];
$email = $_SESSION['user_email'];
$profile_pic = $_SESSION['profile_picture'];
$cover_photo = $_SESSION['cover_photo'];

$user_type = null;

$query = "SELECT user_type FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $user_type = $row['user_type'];
}

$articles = [];
$query = "SELECT * FROM articles LIMIT 5";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $articles[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Inbox Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const openPage = 'inbox';
    </script>
    <style>
        .invitation-container {
            background-color: white;
            border: 1px solid #d3d3d3;
            border-radius: 8px;
            padding: 20px;
            margin: 2rem;
        }

        .invitation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #d3d3d3;
            padding-bottom: 15px;
        }

        .invitation-header h2 {
            color: #161616;
            margin: 0;
        }

        .invitation-tabs {
            display: flex;
            gap: 10px;
        }

        .tab-btn {
            padding: 8px 16px;
            background-color: transparent;
            border: 1px solid #d3d3d3;
            border-radius: 20px;
            cursor: pointer;
            color: #161616;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background-color: #161616;
            color: #f4f4f4;
        }

        .invitations-list {
            min-height: 300px;
            overflow-y: auto;
            height: 100%;
            max-height: 500px;
        }

        .invitation-card {
            background-color: white;
            border: 1px solid #d3d3d3;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .invitation-title {
            font-size: 1.2rem;
            color: #161616;
            margin: 0 0 10px 0;
        }

        .invitation-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: #666;
            font-size: 0.9rem;
        }

        .invitation-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-accept {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-accept:hover {
            background-color: #3e8e41;
        }

        .btn-reject {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-reject:hover {
            background-color: #d32f2f;
        }

        .invitation-status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-accepted {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-rejected {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .loading-spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top: 4px solid #161616;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 50px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container">
        <div class="main-page" id='main-page'>
            <div class="add-article-title-container" id='inbox-header-container'>
                <div class="article-page-title">
                    <h1>Inbox</h1>
                    <p>Invitations</p>
                </div>
            </div>
            <div class="invitation-container" id='invitation-container'>
                <!-- Add Invitation here -->
                <!-- Give the ability to accept and reject invitations -->
                <div class="invitation-header">
                    <h2>Review Invitations</h2>
                    <div class="invitation-tabs">
                        <button class="tab-btn active" data-tab="pending">Pending</button>
                        <button class="tab-btn" data-tab="accepted">Accepted</button>
                        <button class="tab-btn" data-tab="rejected">Rejected</button>
                    </div>
                </div>

                <div class="invitations-list" id="invitations-list">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>

    <!-- Date Formatter -->
    <script src="scripts/date-formatter.js"></script>

    <script>
        const userId = '<?php echo $user_id ?>';
    </script>

    <script>
        $(document).ready(function() {
            let currentTab = 'pending';

            // Load invitations when page loads
            loadInvitations(currentTab);

            // Tab switching
            $('.tab-btn').click(function() {
                $('.tab-btn').removeClass('active');
                $(this).addClass('active');
                currentTab = $(this).data('tab');
                loadInvitations(currentTab);
            });

        });

        function respondToInvitation(inviteId, response) {
            if (!confirm(`Are you sure you want to ${response} this invitation?`)) return;

            $.ajax({
                url: 'php-backend/respond-to-invitation.php',
                type: 'POST',
                data: {
                    invite_id: inviteId,
                    response: response
                },
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        // Reload the current tab
                        const currentTab = $('.tab-btn.active').data('tab');
                        loadInvitations(currentTab);

                        // Show success message
                        alert(`Invitation ${response} successfully!`);
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function() {
                    alert('Error processing your request. Please try again.');
                }
            });
        }

        function loadInvitations(status) {
            $('#invitations-list').html('<div class="loading-spinner"></div>');

            $.ajax({
                url: 'php-backend/get-reviewer-invitations.php',
                type: 'GET',
                data: {
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    if (response.length === 0) {
                        $('#invitations-list').html(`
                        <div class="empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 6L12 13L2 6" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>No ${status} invitations</h3>
                            <p>You don't have any ${status} review invitations at this time.</p>
                        </div>
                    `);
                        return;
                    }

                    let html = '';
                    response.forEach(invite => {
                        html += `
                        <div class="invitation-card" data-invite-id="${invite.invite_id}">
                            <h3 class="invitation-title">${invite.article_title}</h3>
                            <div class="invitation-meta">
                                <span>From: ${invite.inviter_name}</span>
                                <span>Invited: ${formatDateTime(invite.invite_date)}</span>
                                <span class="invitation-status status-${invite.status}">${invite.status}</span>
                            </div>
                            <p>${invite.message || 'Please review this article and provide your feedback.'}</p>
                            
                            ${invite.status === 'pending' ? `
                            <div class="invitation-actions">
                                <button class="btn-accept" onclick="respondToInvitation(${invite.invite_id}, 'accepted')">Accept</button>
                                <button class="btn-reject" onclick="respondToInvitation(${invite.invite_id}, 'rejected')">Reject</button>
                            </div>
                            ` : ''}
                        </div>
                    `;
                    });

                    $('#invitations-list').html(html);
                },
                error: function() {
                    $('#invitations-list').html(`
                    <div class="empty-state">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V12" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16H12.01" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3>Error loading invitations</h3>
                        <p>Please try again later.</p>
                    </div>
                `);
                }
            });
        }
    </script>

</body>

</html>
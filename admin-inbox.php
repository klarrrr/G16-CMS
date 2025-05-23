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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --primary-color: #0F5132;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-color: #dee2e6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #212529;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #0F5132;
            color: #ecf0f1;
            padding: 20px;
            height: 100vh;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 20px;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
        }

        .inbox-container {
            display: flex;
            gap: 20px;
        }

        .message-list {
            flex: 1;
            max-width: 350px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .message-list-header {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message-list-title {
            font-size: 18px;
            font-weight: 600;
        }

        .message-search {
            padding: 10px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .message-search input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .message-items {
            height: calc(100vh - 250px);
            overflow-y: auto;
        }

        .message-item {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .message-item:hover {
            background-color: var(--light-color);
        }

        .message-item.active {
            background-color: #e9f5fe;
        }

        .message-item.unread {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .message-sender {
            font-size: 15px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }

        .message-subject {
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 5px;
        }

        .message-preview {
            font-size: 13px;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-date {
            font-size: 12px;
            color: #6c757d;
        }

        .message-detail {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .message-detail-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .message-detail-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .message-sender-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sender-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .sender-details {
            line-height: 1.3;
        }

        .sender-name {
            font-weight: 600;
        }

        .sender-email {
            font-size: 14px;
            color: var(--primary-color);
        }

        .message-date-time {
            font-size: 14px;
            color: #6c757d;
            text-align: right;
        }

        .message-content {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
            line-height: 1.6;
        }

        .message-reply {
            padding: 20px;
            border-top: 1px solid var(--border-color);
        }

        .reply-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            resize: vertical;
            min-height: 100px;
            margin-bottom: 10px;
        }

        .reply-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--border-color);
        }

        .btn-outline:hover {
            background-color: var(--light-color);
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ced4da;
        }

        @media (max-width: 992px) {
            .inbox-container {
                flex-direction: column;
            }

            .message-list {
                max-width: 100%;
            }

            .message-items {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <?php include 'admin-side-bar.php' ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Inbox</h1>
                <div>
                    <button class="btn btn-primary" id="refreshBtn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <div class="inbox-container">
                <!-- Message List -->
                <div class="message-list">
                    <div class="message-list-header">
                        <div class="message-list-title">Messages</div>
                    </div>
                    <div class="message-search">
                        <input type="text" id="searchMessages" placeholder="Search messages...">
                    </div>
                    <div class="message-items" id="messageList">
                        <!-- Messages will be loaded here -->
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Loading messages...</p>
                        </div>
                    </div>
                </div>

                <!-- Message Detail -->
                <div class="message-detail" id="messageDetail">
                    <div class="empty-state">
                        <i class="fas fa-envelope-open"></i>
                        <p>Select a message to view</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal" id="replyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 1000;">
        <div class="modal-content" style="background: white; padding: 2rem; border-radius: 8px; width: 100%; max-width: 600px;">
            <h2 style="margin-bottom: 1rem;">Reply to Message</h2>
            <div id="replyForm">
                <input type="hidden" id="replyMessageId">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">To:</label>
                    <input type="text" id="replyToEmail" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;" readonly>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Subject:</label>
                    <input type="text" id="replySubject" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Message:</label>
                    <textarea id="replyMessage" style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; min-height: 200px;"></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                    <button class="btn btn-outline" onclick="closeReplyModal()">Cancel</button>
                    <button class="btn btn-primary" onclick="sendReply()">Send Reply</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Load messages on page load
            loadMessages();

            // Refresh button
            $('#refreshBtn').click(function() {
                loadMessages();
            });

            // Search functionality
            $('#searchMessages').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                if (searchTerm.length > 0) {
                    $('.message-item').each(function() {
                        const text = $(this).text().toLowerCase();
                        $(this).toggle(text.includes(searchTerm));
                    });
                } else {
                    $('.message-item').show();
                }
            });
        });

        function loadMessages() {
            $('#messageList').html('<div class="empty-state"><i class="fas fa-spinner fa-spin"></i><p>Loading messages...</p></div>');

            $.ajax({
                url: 'php-backend/fetch-messages.php',
                type: 'GET',
                dataType: 'json',
                success: function(messages) {
                    if (messages.length === 0) {
                        $('#messageList').html('<div class="empty-state"><i class="fas fa-inbox"></i><p>No messages found</p></div>');
                        return;
                    }

                    let html = '';
                    messages.forEach(message => {
                        const initials = message.sender_first_name.charAt(0) + message.sender_last_name.charAt(0);
                        const preview = message.message.length > 50 ? message.message.substring(0, 50) + '...' : message.message;
                        const date = new Date(message.date_created).toLocaleString();

                        html += `
                            <div class="message-item" onclick="viewMessage(${message.inbox_id})" data-id="${message.inbox_id}">
                                <div class="message-sender">
                                    <span>${message.sender_first_name} ${message.sender_last_name}</span>
                                    <span class="message-date">${date}</span>
                                </div>
                                <div class="message-subject">${message.subject}</div>
                                <div class="message-preview">${preview}</div>
                            </div>
                        `;
                    });

                    $('#messageList').html(html);
                },
                error: function(error) {
                    console.error('Error loading messages:', error);
                    $('#messageList').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Error loading messages</p></div>');
                }
            });
        }

        function viewMessage(messageId) {
            $('.message-item').removeClass('active');
            $(`.message-item[data-id="${messageId}"]`).addClass('active');

            $.ajax({
                url: 'php-backend/fetch-message.php',
                type: 'GET',
                data: {
                    id: messageId
                },
                dataType: 'json',
                success: function(message) {
                    const date = new Date(message.date_created).toLocaleString();
                    const initials = message.sender_first_name.charAt(0) + message.sender_last_name.charAt(0);

                    const html = `
                        <div class="message-detail-header">
                            <h2 class="message-detail-title">${message.subject}</h2>
                            <div class="message-meta">
                                <div class="message-sender-info">
                                    <div class="sender-avatar">${initials}</div>
                                    <div class="sender-details">
                                        <div class="sender-name">${message.sender_first_name} ${message.sender_last_name}</div>
                                        <div class="sender-email">${message.sender_email}</div>
                                    </div>
                                </div>
                                <div class="message-date-time">${date}</div>
                            </div>
                        </div>
                        <div class="message-content">
                            ${message.message.replace(/\n/g, '<br>')}
                        </div>
                        <div class="message-reply">
                            <button class="btn btn-primary" onclick="openReplyModal(${message.inbox_id}, '${message.sender_email}', 'Re: ${message.subject}')">
                                <i class="fas fa-reply"></i> Reply
                            </button>
                        </div>
                    `;

                    $('#messageDetail').html(html);
                },
                error: function(error) {
                    console.error('Error loading message:', error);
                    $('#messageDetail').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Error loading message</p></div>');
                }
            });
        }

        function openReplyModal(messageId, email, subject) {
            $('#replyMessageId').val(messageId);
            $('#replyToEmail').val(email);
            $('#replySubject').val(subject);
            $('#replyMessage').val('');
            $('#replyModal').show();
        }

        function closeReplyModal() {
            $('#replyModal').hide();
        }

        function sendReply() {
            const messageId = $('#replyMessageId').val();
            const email = $('#replyToEmail').val();
            const subject = $('#replySubject').val();
            const message = $('#replyMessage').val();

            if (!subject || !message) {
                alert('Please fill in all required fields');
                return;
            }

            $.ajax({
                url: 'php-backend/send-reply.php',
                type: 'POST',
                data: {
                    message_id: messageId,
                    email: email,
                    subject: subject,
                    message: message
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Reply sent successfully');
                        closeReplyModal();
                    } else {
                        alert('Failed to send reply: ' + response.error);
                    }
                },
                error: function(error) {
                    console.error('Error sending reply:', error);
                    alert('Error sending reply');
                }
            });
        }
    </script>
</body>

</html>
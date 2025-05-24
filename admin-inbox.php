<?php
session_start();
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
        --border-color: #dee2e6;
        --light-color: #f8f9fa;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
        transition: all 0.2s ease-in-out;
    }

    body {
        background-color: #f4f4f4;
    }

    .sidebar {
        width: 250px;
        background-color: var(--primary-color);
        color: #fff;
        height: 100vh;
        position: fixed;
        padding: 20px;
    }

    .sidebar h2 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #fff;
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
        padding: 8px 0;
        display: block;
    }

    .sidebar ul li a:hover {
        text-decoration: underline;
    }

    .main-content {
        margin-left: 250px;
        padding: 30px;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .inbox-container {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }

    .message-list {
        width: 350px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .message-items {
        max-height: 70vh;
        overflow-y: auto;
    }

    .message-item {
        padding: 15px;
        border-bottom: 1px solid var(--border-color);
        cursor: pointer;
    }

    .message-item:hover {
        background-color: var(--light-color);
    }

    .message-detail {
        flex: 1;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .message-content {
        padding: 20px;
        line-height: 1.6;
        overflow-y: auto;
    }

    .message-reply {
        padding: 20px;
        border-top: 1px solid var(--border-color);
        text-align: right;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    /* Modal Styles */
    #replyModal {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
    }

    .modal-content input,
    .modal-content textarea {
        width: 100%;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
    }
</style>
</head>
<body>

    <?php include 'admin-side-bar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title">Inbox</h1>
            <button class="btn btn-primary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        </div>

        <div class="inbox-container">
            <!-- Message List -->
            <div class="message-list">
                <div class="message-items" id="messageList">
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-2x"></i>
                        <p>Loading messages...</p>
                    </div>
                </div>
            </div>

            <!-- Message Detail -->
            <div class="message-detail" id="messageDetail">
                <div class="empty-state">
                    <i class="fas fa-envelope-open fa-2x"></i>
                    <p>Select a message to view</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal" id="replyModal">
        <div class="modal-content">
            <h2>Reply to Message</h2>
            <input type="hidden" id="replyMessageId">
            <input type="text" id="replyToEmail" readonly placeholder="To..." style="width:100%;margin-bottom:10px;">
            <input type="text" id="replySubject" placeholder="Subject" style="width:100%;margin-bottom:10px;">
            <textarea id="replyMessage" style="width:100%;min-height:150px;margin-bottom:10px;"></textarea>
            <div style="text-align:right;">
                <button class="btn" onclick="closeReplyModal()">Cancel</button>
                <button class="btn btn-primary" onclick="sendReply()">Send</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            loadMessages();
            $('#refreshBtn').click(loadMessages);
        });

        function loadMessages() {
            $('#messageList').html('<div class="empty-state"><i class="fas fa-spinner fa-spin"></i><p>Loading messages...</p></div>');
            $.getJSON('php-backend/fetch-messages.php', function (messages) {
                if (!messages.length) {
                    $('#messageList').html('<div class="empty-state"><i class="fas fa-inbox"></i><p>No messages found</p></div>');
                    return;
                }
                let html = '';
                messages.forEach(m => {
                    html += `
                        <div class="message-item" onclick="viewMessage(${m.inbox_id})" data-id="${m.inbox_id}">
                            <strong>${m.sender_first_name} ${m.sender_last_name}</strong><br>
                            <span>${m.subject}</span><br>
                            <small>${new Date(m.date_created).toLocaleString()}</small>
                        </div>`;
                });
                $('#messageList').html(html);
            });
        }

        function viewMessage(id) {
            $('.message-item').removeClass('active');
            $(`.message-item[data-id="${id}"]`).addClass('active');
            $.getJSON('php-backend/fetch-message.php', { id }, function (m) {
                const html = `
                    <div style="padding:20px;">
                        <h2>${m.subject}</h2>
                        <p><strong>${m.sender_first_name} ${m.sender_last_name}</strong> (${m.sender_email})</p>
                        <p>${new Date(m.date_created).toLocaleString()}</p>
                    </div>
                    <div class="message-content">${m.message.replace(/\n/g, '<br>')}</div>
                    <div class="message-reply">
                        <button class="btn btn-primary" onclick="openReplyModal(${m.inbox_id}, '${m.sender_email}', 'Re: ${m.subject}')">Reply</button>
                    </div>
                `;
                $('#messageDetail').html(html);
            });
        }

        function openReplyModal(id, email, subject) {
            $('#replyMessageId').val(id);
            $('#replyToEmail').val(email);
            $('#replySubject').val(subject);
            $('#replyMessage').val('');
            $('#replyModal').css('display', 'flex');
        }

        function closeReplyModal() {
            $('#replyModal').hide();
        }

        function sendReply() {
            const messageId = $('#replyMessageId').val();
            const email = $('#replyToEmail').val();
            const subject = $('#replySubject').val();
            const message = $('#replyMessage').val();

            if (!subject || !message) return alert('Please complete all fields.');

            $.post('php-backend/send-reply.php', {
                message_id: messageId,
                email,
                subject,
                message
            }, function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert('Reply sent.');
                    closeReplyModal();
                } else {
                    alert('Failed: ' + data.error);
                }
            });
        }
    </script>
</body>
</html>

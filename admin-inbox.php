<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Inbox</title>
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <style>
    .inbox-content * {
      font-family: sub;
    }

    main.inbox-content {
      flex: 1;
      overflow-y: auto;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
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

    .btn {
      padding: 0.6rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-primary {
      background-color: #161616;
      color: #f4f4f4;
      border: 1px solid #161616;

      &:hover {
        background-color: #f4f4f4;
        color: #161616;
      }
    }

    .inbox-container {
      display: flex;
      gap: 1.5rem;
      height: calc(100vh - 110px);
      padding: 2rem;
    }

    .message-list {
      width: 350px;
      background: #fff;
      border-radius: 10px;
      /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); */
      display: flex;
      flex-direction: column;
      overflow: hidden;
      border: 1px solid lightgray;
    }

    .message-items {
      border-radius: 10px;
      flex: 1;
      overflow-y: auto;
    }

    .message-item {
      padding: 1rem;
      border-bottom: 1px solid #eee;
      cursor: pointer;
    }

    .message-item:hover {
      background: #f8f9fa;
    }

    .message-item.active {
      background: #e9ecef;
    }

    .message-detail {
      flex: 1;
      background: #fff;
      border-radius: 10px;
      /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); */
      display: flex;
      flex-direction: column;
      border: 1px solid lightgray;
    }

    .message-header {
      padding: 1.5rem;
      border-bottom: 1px solid #eee;
    }

    .message-content {
      flex: 1;
      padding: 1.5rem;
      overflow-y: auto;
      line-height: 1.6;
    }

    .message-actions {
      padding: 1rem;
      border-top: 1px solid #eee;
      text-align: right;
    }

    .empty-state {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      color: #666;
    }

    .empty-state i {
      font-size: 2rem;
      margin-bottom: 1rem;
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
      max-width: 600px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);

      * {
        font-family: sub;
      }

      h2 {
        font-family: main;
      }
    }

    .modal-content input,
    .modal-content textarea {
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
  </style>
</head>

<body>
  <?php include 'admin-side-bar.php'; ?>

  <main class="inbox-content">
    <div class="page-header">
      <div style='display:flex; flex-direction:column;'>
        <h1 style='font-family: main;'>Inbox</h1>
        <p>Read your daily emails</p>
      </div>
      <button class="btn btn-primary" id="refreshBtn">
        <i class="fas fa-sync-alt"></i> Refresh
      </button>
    </div>

    <div class="inbox-container">
      <!-- Message List -->
      <div class="message-list">
        <div class="message-items" id="messageList">
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
  </main>

  <!-- Reply Modal -->
  <div class="modal" id="replyModal">
    <div class="modal-content">
      <h2>Reply to Message</h2>
      <input type="hidden" id="replyMessageId">
      <input type="text" id="replyToEmail" readonly placeholder="To...">
      <input type="text" id="replySubject" placeholder="Subject">
      <textarea id="replyMessage" rows="6"></textarea>

      <div class="modal-actions">
        <button class="cancel-btn" onclick="closeReplyModal()">Cancel</button>
        <button class="save-btn" onclick="sendReply()">Send Reply</button>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      loadMessages();
      $('#refreshBtn').click(loadMessages);
    });

    function loadMessages() {
      $('#messageList').html('<div class="empty-state"><i class="fas fa-spinner fa-spin"></i><p>Loading messages...</p></div>');

      $.getJSON('php-backend/fetch-messages.php', function(messages) {
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
      }).fail(function() {
        $('#messageList').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load messages</p></div>');
      });
    }

    function viewMessage(id) {
      $('.message-item').removeClass('active');
      $(`.message-item[data-id="${id}"]`).addClass('active');

      $.getJSON('php-backend/fetch-message.php', {
        id
      }, function(m) {
        const html = `
          <div class="message-header">
            <h2>${m.subject}</h2>
            <p><strong>From:</strong> ${m.sender_first_name} ${m.sender_last_name} &lt;${m.sender_email}&gt;</p>
            <p><strong>Date:</strong> ${new Date(m.date_created).toLocaleString()}</p>
          </div>
          <div class="message-content">${m.message.replace(/\n/g, '<br>')}</div>
          <div class="message-actions">
            <button class="btn btn-primary" onclick="openReplyModal(${m.inbox_id}, '${m.sender_email}', 'Re: ${m.subject}')">
              <i class="fas fa-reply"></i> Reply
            </button>
          </div>
        `;

        $('#messageDetail').html(html);
      }).fail(function() {
        $('#messageDetail').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load message</p></div>');
      });
    }

    function openReplyModal(id, email, subject) {
      $('#replyMessageId').val(id);
      $('#replyToEmail').val(email);
      $('#replySubject').val(subject);
      $('#replyMessage').val('');
      $('#replyModal').addClass('active');
    }

    function closeReplyModal() {
      $('#replyModal').removeClass('active');
    }

    function sendReply() {
      const messageId = $('#replyMessageId').val();
      const email = $('#replyToEmail').val();
      const subject = $('#replySubject').val();
      const message = $('#replyMessage').val();

      if (!subject || !message) {
        alert('Please complete all fields.');
        return;
      }

      $.post('php-backend/send-reply.php', {
        message_id: messageId,
        email: email,
        subject: subject,
        message: message
      }, function(response) {
        const data = JSON.parse(response);
        if (data.success) {
          alert('Reply sent successfully!');
          closeReplyModal();
        } else {
          alert('Failed to send reply: ' + data.error);
        }
      }).fail(function() {
        alert('Error sending reply. Please try again.');
      });
    }
  </script>
</body>

</html>
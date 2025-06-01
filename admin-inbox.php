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
      height: 100%;
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

    /* Messages Pagination */
    .message-pagination {
      padding: 1rem;
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      border-top: 1px solid #eee;
    }

    .message-pagination button {
      padding: 0.5rem 0.8rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      background: white;
      cursor: pointer;
    }

    .message-pagination button.active {
      background: #161616;
      color: white;
      border-color: #161616;
    }

    .message-pagination button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
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


    .popup-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: none;
      justify-content: center;
      align-items: center;
      -webkit-backdrop-filter: blur(10px);
      backdrop-filter: blur(10px);
      /* Safari */
      background-color: rgba(0, 0, 0, 0.3);
      z-index: 9999;
      animation: fadeInBackdrop 0.4s ease-in-out forwards;
      opacity: 0;
    }

    .popup-message {
      background: white;
      color: black;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      text-align: center;
      animation: fadeInPopup 0.4s ease forwards;
      opacity: 0;
      transform: scale(0.95);
    }

    .popup-message p {
      margin-bottom: 20px;
      font-size: 18px;
      color: black;
    }

    .popup-message button {
      padding: 10px 20px;
      background-color: #161616;
      color: #f4f4f4;
      border: 1px solid #161616;
      color: white;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .popup-message button:hover {
      background-color: #f4f4f4;
      color: #161616;
    }

    /* Animations */
    @keyframes fadeInPopup {
      0% {
        opacity: 0;
        transform: scale(0.95);
      }

      100% {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes fadeInBackdrop {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
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
      <!-- Message List -->
      <div class="message-list">
        <div class="message-items" id="messageList">
          <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p>Loading messages...</p>
          </div>
        </div>
        <div class="message-pagination" id="messagePagination"></div>
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
        <button class="save-btn" onclick="sendReply()" id='replySendBtn'>Send Reply</button>
      </div>
    </div>
  </div>

  <div id="popup-backdrop" class="popup-backdrop">
    <div id="popup-message" class="popup-message">
      <p id="popup-text">Message sent!</p>
      <button onclick="closePopup()">Close</button>
    </div>
  </div>

  <!-- Popup Script -->
  <script>
    function closePopup() {
      document.getElementById('popup-backdrop').style.display = 'none';
    }

    window.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);
      const status = params.get('status');
      if (status === 'success' || status === 'fail') {
        const text = status === 'success' ? 'Message sent successfully!' : 'Failed to send message. Try again.';
        document.getElementById('popup-text').textContent = text;
        document.getElementById('popup-backdrop').style.display = 'flex';
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      loadMessages();
      $('#refreshBtn').click(function() {
        loadMessages(currentPage); // Refresh current page
      });
    });

    let currentPage = 1;
    const messagesPerPage = 10; // Adjust as needed

    // Modify your loadMessages function
    function loadMessages(page = 1) {
      currentPage = page;

      // Refresh Loading Messages
      $('#messageList').html('<div class="empty-state"><i class="fas fa-spinner fa-spin"></i><p>Loading messages...</p></div>');
      $('#messagePagination').html('');

      $.getJSON('php-backend/fetch-messages.php', {
        page,
        per_page: messagesPerPage
      }, function(response) {
        if (!response.messages || !response.messages.length) {
          $('#messageList').html('<div class="empty-state"><i class="fas fa-inbox"></i><p>No messages found</p></div>');
          return;
        }

        // Render messages
        let html = '';
        response.messages.forEach(m => {
          html += `
        <div class="message-item" onclick="viewMessage(${m.inbox_id})" data-id="${m.inbox_id}">
          <strong>${m.sender_first_name} ${m.sender_last_name}</strong><br>
          <span>${m.subject}</span><br>
          <small>${new Date(m.date_created).toLocaleString()}</small>
        </div>`;
        });
        $('#messageList').html(html);

        // Render pagination
        renderPagination(response.total, messagesPerPage, page);

      }).fail(function() {
        $('#messageList').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load messages</p></div>');
      });
    }

    // Pagination JSs

    // Add this new function for pagination rendering
    function renderPagination(totalMessages, perPage, currentPage) {
      const totalPages = Math.ceil(totalMessages / perPage);
      const pagination = $('#messagePagination');

      if (totalPages <= 1) return;

      // Previous button
      pagination.append(`
    <button onclick="loadMessages(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
      <i class="fas fa-chevron-left"></i>
    </button>
  `);

      // Page numbers
      const maxVisiblePages = 5;
      let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
      let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

      // Adjust if we're at the end
      if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
      }

      // Always show first page
      if (startPage > 1) {
        pagination.append(`
      <button onclick="loadMessages(1)" ${1 === currentPage ? 'class="active"' : ''}>1</button>
    `);
        if (startPage > 2) {
          pagination.append('<span>...</span>');
        }
      }

      // Middle pages
      for (let i = startPage; i <= endPage; i++) {
        pagination.append(`
      <button onclick="loadMessages(${i})" ${i === currentPage ? 'class="active"' : ''}>${i}</button>
    `);
      }

      // Always show last page
      if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
          pagination.append('<span>...</span>');
        }
        pagination.append(`
      <button onclick="loadMessages(${totalPages})" ${totalPages === currentPage ? 'class="active"' : ''}>${totalPages}</button>
    `);
      }

      // Next button
      pagination.append(`
    <button onclick="loadMessages(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
      <i class="fas fa-chevron-right"></i>
    </button>
  `);
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
      const submitButton = document.getElementById('replySendBtn'); // Your reply button's ID

      if (!subject || !message) {
        alert('Please complete all fields.');
        return;
      }

      // Disable the button while sending
      submitButton.disabled = true;
      submitButton.textContent = 'Sending...';

      $.ajax({
        url: 'php-backend/send-reply.php',
        type: 'post',
        dataType: 'json',
        data: {
          message_id: messageId,
          email: email,
          subject: subject,
          message: message
        },
        success: (data) => {
          if (data.success) {
            // Show success popup
            document.getElementById('popup-text').textContent = 'Reply sent successfully!';
            document.getElementById('popup-backdrop').style.display = 'flex';

            closeReplyModal();
            loadMessages();
            $('#messageDetail').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load message</p></div>');
          } else {
            // Show error message
            document.getElementById('popup-text').textContent = 'Failed to send reply: ' + (data.error || 'Please try again.');
            document.getElementById('popup-backdrop').style.display = 'flex';
          }
        },
        error: (error) => {
          console.log(error);
          document.getElementById('popup-text').textContent = 'Error sending reply. Please try again.';
          document.getElementById('popup-backdrop').style.display = 'flex';
        }
      }).always(() => {
        // Re-enable the button
        submitButton.disabled = false;
        submitButton.textContent = 'Send Reply';
      });

    }
  </script>
</body>

</html>
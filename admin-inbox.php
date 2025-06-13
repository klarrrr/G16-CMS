<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Inbox</title>
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
      min-height: 0;
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
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      padding: 1rem;
      border-bottom: 1px solid #e0e0e0;
      width: 100%;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .page-header h1 {
      font-size: 1.4rem;
      color: #222;
      font-weight: 600;
    }

    .page-header p {
      color: #666;
      font-size: 0.8rem;
      margin-top: 0.25rem;
    }

    .btn {
      padding: 0.5rem 0.8rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 0.9rem;
    }

    .btn-primary {
      background-color: #161616;
      color: #f4f4f4;
      border: 1px solid #161616;
    }

    .btn-primary:hover {
      background-color: #f4f4f4;
      color: #161616;
    }

    .btn-back {
      background: none;
      border: none;
      font-size: 1.2rem;
      margin-right: 0.5rem;
      cursor: pointer;
      color: #161616;
    }

    .inbox-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: calc(100vh - var(--header-height));
      overflow: hidden;
    }

    /* Message List View */
    .message-list-view {
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
      background: white;
    }

    .message-items {
      flex: 1;
      overflow-y: auto;
    }

    .message-item {
      padding: 1rem;
      border-bottom: 1px solid #eee;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .message-item:hover {
      background: #f8f9fa;
    }

    .message-item.active {
      background: #e9ecef;
    }

    .message-item .sender {
      font-weight: 600;
      margin-bottom: 0.25rem;
      display: flex;
      justify-content: space-between;
    }

    .message-item .subject {
      font-weight: 500;
      margin-bottom: 0.25rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .message-item .preview {
      color: #666;
      font-size: 0.9rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .message-item .date {
      color: #999;
      font-size: 0.8rem;
    }

    .message-pagination {
      padding: 0.75rem;
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      border-top: 1px solid #eee;
      background: white;
    }

    .message-pagination button {
      padding: 0.4rem 0.6rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      background: white;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 0.8rem;
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

    /* Message Detail View */
    .message-detail-view {
      flex: 1;
      display: none;
      flex-direction: column;
      background: white;
      overflow: hidden;
      position: relative; /* Added for proper button positioning */
    }

    .message-detail-view.active {
      display: flex;
    }

    .message-header {
      padding: 1rem;
      border-bottom: 1px solid #eee;
      position: sticky;
      top: 0;
      background: white;
      z-index: 50;
    }

    .message-header .subject {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .message-header .sender-info {
      display: flex;
      align-items: center;
      margin-bottom: 0.5rem;
    }

    .message-header .sender-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #e0e0e0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.75rem;
      color: #666;
      font-weight: 600;
    }

    .message-header .sender-details {
      flex: 1;
    }

    .message-header .sender-name {
      font-weight: 600;
    }

    .message-header .sender-email {
      color: #666;
      font-size: 0.9rem;
    }

    .message-header .message-date {
      color: #999;
      font-size: 0.8rem;
    }

    .message-content {
      flex: 1;
      padding: 1rem;
      overflow-y: auto;
      line-height: 1.6;
      white-space: pre-wrap;
      margin-bottom: 60px; /* Space for the fixed button */
    }

    .message-actions {
      position: fixed;
      bottom: 0;
      left: var(--sidebar-width);
      right: 0;
      padding: 1rem;
      background: white;
      border-top: 1px solid #eee;
      display: flex;
      justify-content: center;
      z-index: 40;
    }

    #replyButton {
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      width: auto;
      min-width: 120px;
      max-width: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .empty-state {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      color: #666;
      padding: 2rem;
      text-align: center;
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
      padding: 1.5rem;
      border-radius: 10px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      margin: 1rem;
    }

    .modal-content h2 {
      font-size: 1.3rem;
      margin-bottom: 1rem;
      color: #222;
    }

    .modal-content input,
    .modal-content textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 0.95rem;
    }

    .modal-content textarea {
      min-height: 120px;
      resize: vertical;
    }

    .modal-actions {
      text-align: right;
      margin-top: 1rem;
    }

    .modal-actions button {
      padding: 0.6rem 1rem;
      margin-left: 0.5rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .cancel-btn {
      background: #ddd;
    }

    .cancel-btn:hover {
      background: #ccc;
    }

    .save-btn {
      background-color: #161616;
      color: #f4f4f4;
      border: 1px solid #161616;
    }

    .save-btn:hover {
      background-color: #f4f4f4;
      color: #161616;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .mobile-menu-toggle {
        display: block;
      }

      .left-editor-container {
        transform: translateX(-100%);
        width: 280px;
        position: fixed;
        z-index: 1001;
      }

      .left-editor-container.active {
        transform: translateX(0);
      }

      .right-editor-container {
        margin-left: 0;
      }

      .message-actions {
        left: 0;
      }

      body.sidebar-open {
        overflow: hidden;
      }

      /* On mobile, show either list or detail view */
      .message-list-view {
        display: flex;
      }
      .message-detail-view {
        display: none;
      }
      .message-detail-view.active {
        display: flex;
      }
    }

    @media (min-width: 993px) {
      /* On desktop, show both views side by side */
      .inbox-container {
        flex-direction: row;
      }
      .message-list-view {
        width: 350px;
        border-right: 1px solid #e0e0e0;
      }
      .message-detail-view {
        display: flex;
        flex: 1;
      }
    }

    @media (max-width: 768px) {
      .page-header {
        padding: 0.75rem;
      }

      .page-header h1 {
        font-size: 1.2rem;
      }

      .page-header p {
        font-size: 0.75rem;
      }

      .btn {
        padding: 0.4rem 0.7rem;
        font-size: 0.8rem;
      }

      #replyButton {
        width: 100%;
        max-width: none;
        justify-content: center;
      }

      .message-item {
        padding: 0.75rem;
      }

      .message-header {
        padding: 0.75rem;
      }

      .message-content {
        padding: 0.75rem;
        margin-bottom: 60px;
      }

      .modal-content {
        padding: 1.25rem;
      }
    }

    /* Overlay background when sidebar is open */
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

    /* Animations for view transitions */
    @keyframes slideIn {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }

    @keyframes slideOut {
      from { transform: translateX(0); }
      to { transform: translateX(100%); }
    }

    .message-detail-view.active {
      animation: slideIn 0.3s ease-out;
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
      <!-- Message List Header -->
      <div class="page-header" id="listHeader">
        <div style='display:flex; flex-direction:column;'>
          <h1>Inbox</h1>
          <p>Read your daily emails</p>
        </div>
        <button class="btn btn-primary" id="refreshBtn">
          <i class="fas fa-sync-alt"></i> Refresh
        </button>
      </div>

      <!-- Message Detail Header (hidden by default) -->
      <div class="page-header" id="detailHeader" style="display: none;">
        <button class="btn-back" id="backButton">
          <i class="fas fa-arrow-left"></i>
        </button>
        <div style='display:flex; flex-direction:column;'>
          <h1 id="detailTitle">Message</h1>
        </div>
      </div>

      <div class="inbox-container">
        <!-- Message List View -->
        <div class="message-list-view" id="messageListView">
          <div class="message-items" id="messageList">
            <div class="empty-state">
              <i class="fas fa-inbox"></i>
              <p>Loading messages...</p>
            </div>
          </div>
          <div class="message-pagination" id="messagePagination"></div>
        </div>

        <!-- Message Detail View -->
        <div class="message-detail-view" id="messageDetailView">
          <div class="message-header" id="messageHeader">
            <div class="subject" id="messageSubject"></div>
            <div class="sender-info">
              <div class="sender-avatar" id="senderAvatar"></div>
              <div class="sender-details">
                <div class="sender-name" id="senderName"></div>
                <div class="sender-email" id="senderEmail"></div>
              </div>
              <div class="message-date" id="messageDate"></div>
            </div>
          </div>
          <div class="message-content" id="messageContent"></div>
        </div>
      </div>
    </div>
    
    <!-- Fixed Reply Button (moved outside right-editor-container) -->
    <div class="message-actions" id="fixedReplyButton" style="display: none;">
      <button class="btn btn-primary" id="replyButton">
        <i class="fas fa-reply"></i> Reply
      </button>
    </div>
  </div>

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

  <!-- Popup for success/error messages -->
  <div id="popup-backdrop" class="popup-backdrop" style="display: none;">
    <div id="popup-message" class="popup-message">
      <p id="popup-text">Message sent!</p>
      <button onclick="closePopup()">Close</button>
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
          
          // On desktop, show both views
          document.getElementById('listHeader').style.display = 'flex';
          document.getElementById('detailHeader').style.display = 'none';
          document.getElementById('messageListView').style.display = 'flex';
          document.getElementById('messageDetailView').style.display = 'flex';
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

    let currentPage = 1;
    const messagesPerPage = 10;
    let currentMessageId = null;

    $(document).ready(function() {
      loadMessages();
      
      $('#refreshBtn').click(function() {
        loadMessages(currentPage);
      });
      
      $('#backButton').click(function() {
        showMessageListView();
      });
      
      $('#replyButton').click(function() {
        if (currentMessageId) {
          openReplyModal(currentMessageId);
        }
      });
    });

    function loadMessages(page = 1) {
      currentPage = page;
      showMessageListView();

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

        let html = '';
        response.messages.forEach(m => {
          const initials = (m.sender_first_name.charAt(0) + m.sender_last_name.charAt(0)).toUpperCase();
          const date = new Date(m.date_created);
          const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
          const preview = m.message.length > 50 ? m.message.substring(0, 50) + '...' : m.message;
          
          html += `
            <div class="message-item" onclick="viewMessage(${m.inbox_id})" data-id="${m.inbox_id}">
              <div class="sender">
                <span>${m.sender_first_name} ${m.sender_last_name}</span>
                <span class="date">${formattedDate}</span>
              </div>
              <div class="subject">${m.subject}</div>
              <div class="preview">${preview}</div>
            </div>`;
        });
        $('#messageList').html(html);

        renderPagination(response.total, messagesPerPage, page);

      }).fail(function() {
        $('#messageList').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load messages</p></div>');
      });
    }

    function renderPagination(totalMessages, perPage, currentPage) {
      const totalPages = Math.ceil(totalMessages / perPage);
      const pagination = $('#messagePagination');

      if (totalPages <= 1) return;

      pagination.append(`
        <button onclick="loadMessages(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
          <i class="fas fa-chevron-left"></i>
        </button>
      `);

      const maxVisiblePages = 5;
      let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
      let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

      if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
      }

      if (startPage > 1) {
        pagination.append(`
          <button onclick="loadMessages(1)" ${1 === currentPage ? 'class="active"' : ''}>1</button>
        `);
        if (startPage > 2) {
          pagination.append('<span>...</span>');
        }
      }

      for (let i = startPage; i <= endPage; i++) {
        pagination.append(`
          <button onclick="loadMessages(${i})" ${i === currentPage ? 'class="active"' : ''}>${i}</button>
        `);
      }

      if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
          pagination.append('<span>...</span>');
        }
        pagination.append(`
          <button onclick="loadMessages(${totalPages})" ${totalPages === currentPage ? 'class="active"' : ''}>${totalPages}</button>
        `);
      }

      pagination.append(`
        <button onclick="loadMessages(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
          <i class="fas fa-chevron-right"></i>
        </button>
      `);
    }

    function viewMessage(id) {
      currentMessageId = id;
      
      if (window.innerWidth <= 992) {
        showMessageDetailView();
      }
      
      $('.message-item').removeClass('active');
      $(`.message-item[data-id="${id}"]`).addClass('active');

      document.getElementById('fixedReplyButton').style.display = 'flex';

      // Load message details
      $.getJSON('php-backend/fetch-message.php', { id }, function(m) {
        const initials = (m.sender_first_name.charAt(0) + m.sender_last_name.charAt(0)).toUpperCase();
        const date = new Date(m.date_created);
        const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        $('#detailTitle').text(m.subject);
        $('#messageSubject').text(m.subject);
        $('#senderAvatar').text(initials);
        $('#senderName').text(`${m.sender_first_name} ${m.sender_last_name}`);
        $('#senderEmail').text(m.sender_email);
        $('#messageDate').text(formattedDate);
        $('#messageContent').html(m.message.replace(/\n/g, '<br>'));
        
        // Update reply button
        $('#replyButton').attr('onclick', `openReplyModal(${m.inbox_id}, '${m.sender_email}', 'Re: ${m.subject.replace(/'/g, "\\'")}')`);
      }).fail(function() {
        $('#messageContent').html('<div class="empty-state"><i class="fas fa-exclamation-circle"></i><p>Failed to load message</p></div>');
      });
    }

    function showMessageListView() {
      if (window.innerWidth <= 992) {
        document.getElementById('listHeader').style.display = 'flex';
        document.getElementById('detailHeader').style.display = 'none';
        document.getElementById('messageListView').style.display = 'flex';
        document.getElementById('messageDetailView').style.display = 'none';
        document.getElementById('fixedReplyButton').style.display = 'none';
      }
    }

    function showMessageDetailView() {
      if (window.innerWidth <= 992) {
        document.getElementById('listHeader').style.display = 'none';
        document.getElementById('detailHeader').style.display = 'flex';
        document.getElementById('messageListView').style.display = 'none';
        document.getElementById('messageDetailView').style.display = 'flex';
        document.getElementById('messageDetailView').classList.add('active');
        document.getElementById('fixedReplyButton').style.display = 'flex';
      }
    }

    function openReplyModal(id, email = null, subject = null) {
      if (email) $('#replyToEmail').val(email);
      if (subject) $('#replySubject').val(subject);
      $('#replyMessageId').val(id);
      $('#replyMessage').val('');
      $('#replyModal').addClass('active');
    }

    function closeReplyModal() {
      $('#replyModal').removeClass('active');
    }

    function closePopup() {
      document.getElementById('popup-backdrop').style.display = 'none';
    }

    function sendReply() {
      const messageId = $('#replyMessageId').val();
      const email = $('#replyToEmail').val();
      const subject = $('#replySubject').val();
      const message = $('#replyMessage').val();
      const submitButton = document.getElementById('replySendBtn');

      if (!subject || !message) {
        document.getElementById('popup-text').textContent = 'Please complete all fields.';
        document.getElementById('popup-backdrop').style.display = 'flex';
        return;
      }

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
            document.getElementById('popup-text').textContent = 'Reply sent successfully!';
            document.getElementById('popup-backdrop').style.display = 'flex';
            
            closeReplyModal();
            loadMessages();
            if (window.innerWidth <= 992) {
              showMessageListView();
            }
          } else {
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
        submitButton.disabled = false;
        submitButton.textContent = 'Send Reply';
      });
    }
  </script>
</body>

</html>
<?php

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: editor-dashboard.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lundayan : Sign In</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        .error-msg {
            font-size: 0.8em;
            color: salmon;
            display: none;
        }

        .error-visible {
            display: block !important;
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .modal h2 {
            margin-top: 0;
            color: #0a5c36;
        }

        .modal p {
            margin-bottom: 1.5rem;
            color: #666;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .modal-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .modal-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: #0a5c36;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal-btn:hover {
            background-color: #084b2d;
        }
    </style>
</head>

<body>
    <main class='sign-in-main'>
        <a href="index.php" id='sign-in-home'>« Go Back</a>
        <section class='sign-in-details'>

            <div class="sign-in-title-container">
                <h1>LUNDAYAN</h1>
                <p id='sign-in-paragraph'>Sign in to modify, create and share <br>exciting news and posts</p>
            </div>

            <!-- Sign In Form -->
            <form id="sign-in-form" class="sign-in-user-input" style='display: flex;' novalidate>
                <div class="sign-in-title-container" style='display: none;' id='sign-in-title-inside'>
                    <h1>LUNDAYAN</h1>
                    <p id='sign-in-paragraph'>Sign in to modify, create and share <br>exciting news and posts</p>
                </div>

                <label class="error-msg" id="sign-in-email-error"></label>
                <input type="email" class='sign-in-input-box' placeholder="Enter your email here" id='sign-in-email' autocomplete="email" title="Input valid email">

                <label class="error-msg" id="sign-in-pass-error"></label>
                <input type="password" class='sign-in-input-box' placeholder="Enter your password here" id='sign-in-pass' autocomplete="current-password" title="Input password">

                <button type="submit" class='sign-btn' id='sign-in-btn'>Sign in</button>
                <a href="#" id='forgot-pass'>Forgot Password?</a>

                <hr>

                <div style='display: none;' id='sign-in-footer-inside'>
                    <p>&copy; 2025 Lundayan - Student Publication - Pamantasan ng Lungsod ng Pasig. All rights reserved.</p>
                </div>
            </form>
        </section>

        <footer class='sign-in-footer' id='sign-in-footer-outside'>
            <p>&copy; 2025 Lundayan - Student Publication - Pamantasan ng Lungsod ng Pasig. All rights reserved.</p>
        </footer>
    </main>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-modal" onclick="closeForgotPasswordModal()">&times;</span>
            <h2>Forgot Password</h2>
            <p>Enter your email address and we'll notify the admin to reset your password.</p>

            <div class="form-group">
                <label for="forgotEmail">Email Address</label>
                <input type="email" id="forgotEmail" class="modal-input" placeholder="Your registered email">
                <div id="forgotEmailError" class="error-msg"></div>
            </div>

            <button id="submitForgotPassword" class="modal-btn" onclick="submitForgotPassword()">Send Request</button>
        </div>
    </div>

    <script>
        // Sign In Form Submission
        $('#sign-in-form').submit(function(e) {
            e.preventDefault();
            let email = $('#sign-in-email').val().trim();
            let pass = $('#sign-in-pass').val().trim();
            let valid = true;

            $('#sign-in-email-error').text('').removeClass('error-visible');
            $('#sign-in-pass-error').text('').removeClass('error-visible');


            if (!pass) {
                $('#sign-in-pass-error').text('* Password cannot be empty').addClass('error-visible');
                valid = false;
            }

            if (valid) {
                const email = $('#sign-in-email').val();
                const pass = $('#sign-in-pass').val();

                $.ajax({
                    url: 'login.php',
                    method: 'POST',
                    data: {
                        email: email,
                        pass: pass
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (result.status === 'success') {
                            window.location.href = result.redirect; // Use redirect from backend
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.log("Response:", xhr.responseText);
                        alert("Something went wrong. Check the console.");
                    }
                });
            }
        });

        // Forgot Password Modal Functions
        $('#forgot-pass').click(function(e) {
            e.preventDefault();
            openForgotPasswordModal();
        });

        function openForgotPasswordModal() {
            $('#forgotPasswordModal').show();
            $('#forgotEmail').val($('#sign-in-email').val()); // Pre-fill with email from sign-in form
        }

        function closeForgotPasswordModal() {
            $('#forgotPasswordModal').hide();
            $('#forgotEmailError').text('').removeClass('error-visible');
        }

        function submitForgotPassword() {
            const email = $('#forgotEmail').val().trim();
            $('#forgotEmailError').text('').removeClass('error-visible');

            if (!email) {
                $('#forgotEmailError').text('* Email is required').addClass('error-visible');
                return;
            }

-

            // Show loading state
            $('#submitForgotPassword').prop('disabled', true).text('Sending...');

            $.ajax({
                url: 'php-backend/forgot-password.php',
                method: 'POST',
                data: {
                    email: email
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Password reset request sent to admin. You will be notified once your password is reset.');
                        closeForgotPasswordModal();
                    } else {
                        alert(response.message || 'Failed to send request. Please try again.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again later.');
                },
                complete: function() {
                    $('#submitForgotPassword').prop('disabled', false).text('Send Request');
                }
            });
        }

        // Global Enter key listener
        $(document).on('keydown', function(e) {
            if (e.key === 'Enter') {
                const isSignInVisible = $('#sign-in-form').is(':visible');
                const isSignUpVisible = $('#sign-up-form').is(':visible');
                const isForgotPasswordVisible = $('#forgotPasswordModal').is(':visible');

                if (isSignInVisible) {
                    e.preventDefault();
                    $('#sign-in-btn').click();
                } else if (isSignUpVisible) {
                    e.preventDefault();
                    $('#sign-up-btn').click();
                } else if (isForgotPasswordVisible) {
                    e.preventDefault();
                    $('#submitForgotPassword').click();
                }
            }
        });

        // Helper function to validate Pasig email
        function isValidPasigEmail(email) {
            const pasigDomain = /@plpasig\.edu\.ph$/i;
            return pasigDomain.test(email);
        }
    </script>

-
    <script>
        $(document).on('keydown', function(e) {
            if (e.key === 'Enter') {
                const isSignInVisible = $('#sign-in-form').is(':visible');
                const isSignUpVisible = $('#sign-up-form').is(':visible');

                if (isSignInVisible) {
                    e.preventDefault();
                    $('#sign-in-btn').click();
                } else if (isSignUpVisible) {
                    e.preventDefault();
                    $('#sign-up-btn').click();
                }
            }
        });
    </script>
</body>

</html>
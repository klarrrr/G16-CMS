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
    </style>
</head>

<body>
    <main class='sign-in-main'>
        <a href="lundayan-site-home.php" id='sign-in-home'>« Go Back</a>
        <section class='sign-in-details'>
            <div class="sign-in-title-container">
                <h1>LUNDAYAN</h1>
                <p id='sign-in-paragraph'>Sign in to modify, create and share <br>exciting news and posts</p>
            </div>

            <!-- Sign In Form -->
            <form id="sign-in-form" class="sign-in-user-input" style='display: flex;' novalidate>
                <label class="error-msg" id="sign-in-email-error"></label>
                <input type="email" class='sign-in-input-box' placeholder="Enter your email here" id='sign-in-email' autocomplete="email" title="Input valid email">

                <label class="error-msg" id="sign-in-pass-error"></label>
                <input type="password" class='sign-in-input-box' placeholder="Enter your password here" id='sign-in-pass' autocomplete="current-password" title="Input password">

                <button type="submit" class='sign-btn' id='sign-in-btn'>Sign in</button>
                <a href="#" id='forgot-pass'>Forgot Password?</a>

                <hr>
            </form>
        </section>

        <footer class='sign-in-footer'>
            <p>&copy; 2025 Lundayan - Student Publication - Pamantasan ng Lungsod ng Pasig. All rights reserved.</p>
        </footer>
    </main>

    <script>
        $('#sign-in-form').submit(function(e) {
            e.preventDefault();
            let email = $('#sign-in-email').val().trim();
            let pass = $('#sign-in-pass').val().trim();
            let valid = true;

            $('#sign-in-email-error').text('').removeClass('error-visible');
            $('#sign-in-pass-error').text('').removeClass('error-visible');

            if (!isValidPasigEmail(email)) {
                $('#sign-in-email-error').text('* Incorrect Format - Pasig Email Only').addClass('error-visible');
                valid = false;
            }
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
                            window.location.href = 'editor-dashboard.php';
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
    </script>

    <!-- Some events -->

    <script>
        // Global Enter key listener
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
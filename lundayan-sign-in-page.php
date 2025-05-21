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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <input type="email" class='sign-in-input-box' placeholder="Enter your email here" id='sign-in-email' autocomplete="email">

                <label class="error-msg" id="sign-in-pass-error"></label>
                <div class="password-toggle-container">
                    <input type="password" class='sign-in-input-box' placeholder="Enter your password here" id='sign-in-pass' autocomplete="current-password" style="appearance: none; -webkit-text-security: disc;">
                    <i class='bx bx-hide toggle-password' data-target="sign-in-pass"></i>
                </div>

                <button type="submit" class='sign-btn'>Sign in</button>
                <a href="#" id='forgot-pass'>Forgot Password?</a>

                <hr>
                <button type="button" id="create-account" class='create-or-sign-in-btn'>Create New Account</button>
            </form>

            <!-- Sign Up Form -->
            <form id="sign-up-form" class="sign-in-user-input" style='display: none;' novalidate>
                <label class="error-msg" id="reg-first-name-error"></label>
                <input type="text" class='sign-in-input-box' placeholder='Enter first name' id="reg-first-name" autocomplete="off">

                <label class="error-msg" id="reg-last-name-error"></label>
                <input type="text" class='sign-in-input-box' placeholder='Enter last name' id="reg-last-name" autocomplete="off">

                <label class="error-msg" id="reg-email-error"></label>
                <input type="email" class='sign-in-input-box' placeholder="Enter your email here" id='reg-email' autocomplete="off">

                <label class="error-msg" id="reg-pass-error"></label>
                <div class="password-toggle-container">
                    <input type="password" class='sign-in-input-box' placeholder="Enter your password here" id='reg-pass' autocomplete="new-password" style="appearance: none; -webkit-text-security: disc;">
                    <i class='bx bx-hide toggle-password' data-target="reg-pass"></i>
                </div>

                <label class="error-msg" id="reg-re-pass-error"></label>
                <div class="password-toggle-container">
                    <input type="password" class='sign-in-input-box' placeholder="Re-enter your password here" id='reg-re-pass' autocomplete="new-password" style="appearance: none; -webkit-text-security: disc;">
                    <i class='bx bx-hide toggle-password' data-target="reg-re-pass"></i>
                </div>

                <select id="reg-user-type" class='sign-in-input-box'>
                    <option value="writer">Writer</option>
                    <option value="reviewer">Reviewer</option>
                </select>

                <button type="submit" class='sign-btn'>Create account</button>
                <hr>
                <button type="button" id="back-sign-in" class='create-or-sign-in-btn'>Already Have Account</button>
            </form>
        </section>

        <footer class='sign-in-footer'>
            <p>&copy; 2025 Lundayan - Student Publication - Pamantasan ng Lungsod ng Pasig. All rights reserved.</p>
        </footer>
    </main>

    <script>
        function isValidPasigEmail(email) {
            return /^[a-zA-Z0-9._%+-]+@plpasig\.edu\.ph$/.test(email);
        }

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

        $('#sign-up-form').submit(function(e) {
            e.preventDefault();
            let fname = $('#reg-first-name').val().trim();
            let lname = $('#reg-last-name').val().trim();
            let email = $('#reg-email').val().trim();
            let pass = $('#reg-pass').val().trim();
            let repass = $('#reg-re-pass').val().trim();
            let valid = true;

            $('.error-msg').text('').removeClass('error-visible');

            if (!fname) {
                $('#reg-first-name-error').text('* First name cannot be empty').addClass('error-visible');
                valid = false;
            }
            if (!lname) {
                $('#reg-last-name-error').text('* Last name cannot be empty').addClass('error-visible');
                valid = false;
            }
            if (!isValidPasigEmail(email)) {
                $('#reg-email-error').text('* Incorrect Format - Pasig Email Only').addClass('error-visible');
                valid = false;
            }
            if (!pass) {
                $('#reg-pass-error').text('* Password cannot be empty').addClass('error-visible');
                valid = false;
            } else if (pass.length < 8) {
                $('#reg-pass-error').text('* Cannot be less than 8 characters').addClass('error-visible');
                valid = false;
            }
            if (!repass || pass !== repass) {
                $('#reg-re-pass-error').text('* Passwords don\'t match').addClass('error-visible');
                valid = false;
            }

            if (valid) {
                const first = $('#reg-first-name').val();
                const last = $('#reg-last-name').val();
                const email = $('#reg-email').val();
                const pass = $('#reg-pass').val();
                const re_pass = $('#reg-re-pass').val();
                const user_type = $('#reg-user-type').val();

                if (pass !== re_pass) {
                    alert("Passwords do not match!");
                    return;
                }

                $.post('register.php', {
                    first,
                    last,
                    email,
                    pass,
                    user_type
                }, function(data) {
                    if (data.status === 'success') {
                        alert("Account created! You can now log in.");
                        $('#back-sign-in').click();
                    } else {
                        alert(data.message);
                    }
                }, 'json').fail(function(xhr) {
                    console.error("Error:", xhr.responseText);
                    alert("Something went wrong. See console.");
                });
            }
        });
    </script>

    <!-- Some events -->

    <script>
        $(document).on('click', '.toggle-password', function() {
            const inputId = $(this).data('target');
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';
            $(this).toggleClass('bx-hide bx-show');
        });

        // Sign In - Trigger with Enter key
        $('#sign-in-email, #sign-in-pass').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                $('#sign-in-btn').click();
            }
        });

        // Sign Up - Trigger with Enter key
        $('#reg-first-name, #reg-last-name, #reg-email, #reg-pass, #reg-re-pass').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                $('#sign-up-btn').click();
            }
        });

        $('#create-account').click(function() {
            $('#sign-in-form').hide();
            $('#sign-up-form').show();
        });

        $('#back-sign-in').click(function() {
            $('#sign-up-form').hide();
            $('#sign-in-form').show();
        });
    </script>
</body>

</html>
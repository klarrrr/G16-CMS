<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lundayan : Sign In</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <main class='sign-in-main'>
        <a href="lundayan-site-home.php" id='sign-in-home'>« Go Back</a>
        <section class='sign-in-details'>
            <div class="sign-in-title-container">
                <h1>LUNDAYAN</h1>
                <p id='sign-in-paragraph'>Sign in to modify, create and share <br>exciting news and posts</p>
            </div>
            <!-- SIGN IN -->
            <div class="sign-in-user-input" id='sign-in-container' style='display: flex;'>
                <label for="email-box" style='font-size: 0.8em; color: salmon; display: none;' id='incorret-format'>* Incorrect Format - Pasig Email Only</label>
                <input type="email" name='email-box' class='sign-in-input-box' placeholder="Enter your email here" id='sign-in-email'>

                <label for="empty-pass" style='font-size: 0.8em; color: salmon; display: none;' id='empty-pass'>* Password cannot be empty</label>
                <input type="password" name='pass-box' class='sign-in-input-box' placeholder="Enter your password here" id='sign-in-pass'>

                <button id='sign-in-btn' class='sign-btn'>Sign in</button>

                <a href="#" id='forgot-pass'>Forgot Password?</a>

                <hr>

                <button id="create-account" class='create-or-sign-in-btn'>Create New Account</button>
            </div>
            <!-- SIGN UP REGISTER -->
            <div class="sign-in-user-input" id='sign-up-container' style='display: none;'>
                <label for="reg-email-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-incorrect-format'>* Incorrect Format - Pasig Email Only</label>
                <input type="email" name='reg-email-box' class='sign-in-input-box' placeholder="Enter your email here" id='reg-email'>

                <label for="reg-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-empty-pass'>* Password cannot be empty</label>
                <label for="reg-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-less-pass'>* Cannot be less than 8 characters</label>
                <label for="reg-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-match-pass'>* Passwords don't match</label>
                <input type="password" name='reg-pass-box' class='sign-in-input-box' placeholder="Enter your password here" id='reg-pass'>

                <label for="reg-re-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-re-empty-pass'>* Password cannot be empty</label>
                <label for="reg-re-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-re-less-pass'>* Cannot be less than 8 characters</label>
                <label for="reg-re-pass-box" style='font-size: 0.8em; color: salmon; display: none;' id='reg-re-match-pass'>* Passwords don't match</label>
                <input type="password" name='reg-re-pass-box' class='sign-in-input-box' placeholder="Re-enter your password here" id='reg-re-pass'>

                <button id='sign-up-btn' class='sign-btn'>Create account</button>

                <hr>

                <button id="back-sign-in" class='create-or-sign-in-btn'>Already Have Account</button>
            </div>
        </section>
        <footer class='sign-in-footer'>
            <p>&copy; 2025 Lundayan - Student Publication - Pamantasan ng Lungsod ng Pasig. All rights reserved.</p>
        </footer>
    </main>
    <!-- Handles the validation of account -->
    <script src='scripts/account-handler.js'></script>
    <!-- Handles the functioanlity -->
     <script src="scripts/sign-up-function.js"></script>
</body>

</html>
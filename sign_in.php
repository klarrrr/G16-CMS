<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="styles_account_page.css">
</head>

<body>
    <?php include 'nav_dashboard.php' ?>
    <div class="account_page">
        <div class="left_side">
            <video autoplay loop muted>
                <source src="Video/topographic_textures.mp4" type="video/mp4">
                Your browser does not support video tag.
            </video>
            <h1>contento</h1>
        </div>
        <div class="right_side">
            <form action="account_handler.php" method="post">
                <div class="text_container">
                    <h2>Welcome to Contento!</h2>
                    <p>Login your account</p>
                </div>
                <div class="email_container">
                    <label for="user_email">Email</label>
                    <input type="email" name="user_email" id="" class="input_enter" placeholder="Enter your email">
                </div>
                <div class="password_container">
                    <label for="user_pass">Password</label>
                    <input type="password" name="user_pass" id="" class="input_enter" placeholder="Enter your password">
                </div>
                <input type="submit" value="Login" name="login_account">
            </form>
            <div class="login_and_dont_have_container">
                <div class="dont_have_acc_container">
                    <p>Don't have an account?</p>
                    <a href="">Register</a>
                </div>
                <div class="login_account_container">
                    <p>Login account with</p>
                    <div class="icon_container">
                        <a href=""><img src="svg/google.svg" alt="Login with google"></a>
                        <a href=""><img src="svg/facebook.svg" alt="Login with facebook"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
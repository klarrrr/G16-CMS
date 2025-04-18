<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link rel="stylesheet" href="styles_account_page.css">
</head>

<body>
    <div class="account_page">
        <div class="left_side">
            <video autoplay loop muted>
                <source src="Video/topographic_textures.mp4" type="video/mp4">
                Your browser does not support video tag.
            </video>
            <h1>contento</h1>
        </div>
        <div class="right_side">
            <div class="dont_have_acc_container">
                <p>Don't have an account?</p>
                <button>Register</button>
            </div>
            <form action="" method="post">
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
                <input type="submit" value="Login">
            </form>
            <div class="login_account_container">
                <p>Login account with</p>
            </div>
        </div>
    </div>
</body>

</html>
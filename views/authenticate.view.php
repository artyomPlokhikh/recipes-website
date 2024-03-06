<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleForm.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
    
</head>
<body>


    <?php require "partials/header.php"; ?>


    <div class="hero">
    
        <?php check_login_errors(); ?>

        <div class="wrapper">
        <form action="includes/formLogin.inc.php" method="post">
            <h1>Log in</h1>
            <div class="input-box">
                <input type="text" placeholder="Your name" name="username">
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password"  id="password" name="pwd">
                <span class="password-icon">
                <i class="fa-solid fa-lock" id="locked"></i>
                <i class="fa-solid fa-lock-open" id="unlocked"></i>
                </span>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="registration">Join now</a></p>
            </div>
        </form>
        </div>
    </div>


<script src="scripts/script.js"></script>
<script src="scripts/scriptForm.js"></script>
</body>
</html>
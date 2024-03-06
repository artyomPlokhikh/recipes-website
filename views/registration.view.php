<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/styleForm.css">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
    
</head>
<body>



<?php require "partials/header.php"; ?>



    <div class="hero">
    <?php check_upload_errors_ingredients(); ?>

        <div class="wrapper">

            <form action="includes/formhandler.php" method="POST" id="regForm">

                <h1>Sign up</h1>
                <?php signup_inputs() ?>
                <button type="submit" class="btn" id="joinNowBtn">Join now</button>

    
                <div class="register-link">
                    <p>Have an account? <a href="authenticate">Log in</a></p>
                </div>
            </form>

        </div>
    </div>

    <?php
    unset($_SESSION["errors_signup"]);
    unset($_SESSION["signup_data"]);
    ?>

<script src="scripts/script.js"></script>
<script src="scripts/scriptForm.js"></script>
</body>
</html>




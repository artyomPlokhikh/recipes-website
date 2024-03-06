<?php


if (isset($_SESSION["user_id"])){
    header("Location: /");
    die();
}



/**
 * Checks and displays upload errors related to ingredient upload.
 */
function check_upload_errors_ingredients(): void {
    if (isset($_SESSION["errors_signup"])){
        $errors = $_SESSION["errors_signup"];

        foreach ($errors as $error)
        {
            echo "<p style='color: red;font-size: 14px;'>". $error ."</p>";
        }

    }
}



/**
 * Generates HTML input elements for the signup form, taking into account session data and errors.
 * If email or username data is stored in the session and there are no corresponding errors,
 * the stored value is used as the default value for the input field.
 */
function signup_inputs(): void {
        if (
            isset($_SESSION["signup_data"]["email"]) && 
            !isset($_SESSION["errors_signup"]["email_registered"])
        ) {
            echo 
            '
                <div class="input-box">
                    <input type="email" placeholder="yourname@example.com" name="email" required value="' . htmlspecialchars($_SESSION["signup_data"]["email"]) . '">
                    <i class="fa-solid fa-envelope"></i>
                </div>
            ';
        } else 
        {
            echo 
            '
                <div class="input-box">
                    <input type="email" placeholder="yourname@example.com" name="email" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
            ';
        }



        if (
            isset($_SESSION["signup_data"]["username"]) && 
            !isset($_SESSION["errors_signup"]["username_taken"])
            ) {
                echo 
                '
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username"  id="username" required value="' . htmlspecialchars($_SESSION["signup_data"]["username"]) . '">
                    </div>
                ';
        } else 
        {
            echo 
            '
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username"  id="username" required>
                </div>
            ';
        }



        echo 
        '
            <div class="input-box">
                <input type="password" name="pwd" placeholder="Password"  id="password" required>
                <span class="password-icon">
                    <i class="fa-solid fa-lock" id="locked"></i>
                    <i class="fa-solid fa-lock-open" id="unlocked"></i>
                </span>
            </div>
        ';
        echo 
        '
            <div class="input-box">
                <input type="password" name="pwdConfirm" placeholder="Confirm password"  id="confirmPassword" required>
                <span class="password-icon">
                    <i class="fa-solid fa-lock" id="lockedConfirm"></i>
                    <i class="fa-solid fa-lock-open" id="unlockedConfirm"></i>
                </span>
                <span class="explain-text">Your password should have at least 8 characters.</span>
            </div>
        ';

};


require "views/registration.view.php";


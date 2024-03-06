<?php


function check_login_errors()
{
    if (isset($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        foreach ($errors as $error) 
        {
            echo "<p style='color: red;font-size: 14px;'>". $error ."</p>";
        }

        unset($_SESSION["errors_login"]);
    }
};


if (isset($_SESSION["user_id"])){
    header("Location: /");
    die();
}


require "views/authenticate.view.php";
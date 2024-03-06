<?php

require_once(__DIR__ . '/../functions.php');



/**
 * Checks and displays any settings errors stored in the session.
 * If errors are found, it iterates through the errors, displays them in red, and clears the session errors.
 */
function check_settings_errors(): void {
    if (isset($_SESSION["errors_settings"])){
        $errors = $_SESSION["errors_settings"];

        foreach ($errors as $error) 
        {
            echo "<p style='color: red;font-size: 14px;'>". $error ."</p>";
        }

        unset($_SESSION["errors_settings"]);
    }
};



require("views/profileSettings.view.php");
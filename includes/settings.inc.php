<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pwd = trim($_POST["pwd"]);
    $pwdConfirm = trim($_POST["pwdConfirm"]);


    try {

        // Database connection and other includes
        require_once("../config.php");
        require("dbh.inc.php");
        require("../models/settings.php");
        require_once(__DIR__ . '/../functions.php');


        $result = get_user_settings($pdo, $username);


        // ERROR HANDLER
        $errors = validateSettingsData($pdo, $username, $email, $pwd, $pwdConfirm, $result);

        if ($errors) {
            handleSettingsErrors($errors);
        }


        updateUserInfo($pdo, $username, $email);
        updatePwd($pdo, $pwd);
        storeUserSessionDataSettings($username, $email);


        $pdo = null;
        $statement = null;


        redirectToProfile($_SESSION['user_id']);

    } catch (PDOException $e){
        die("Query failed: " . $e->getMessage());
    }
} else {
    redirectToHome();
}

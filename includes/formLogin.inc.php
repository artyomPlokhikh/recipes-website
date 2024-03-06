<?php

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    // Get form data
    $username = trim($_POST["username"]);
    $pwd = trim($_POST["pwd"]);

    try {

        // Database connection and other includes
        require("dbh.inc.php");
        require("../config.php");
        require("../functions.php");
        require("../models/authenticate.php");


        $result = get_user($pdo, $username);


        // Validate user input and handle errors
        $errors = validateLoginData($pdo, $username, $pwd, $result);
        
        if ($errors) {
            handleLoginErrors($errors);
        }


        // Store user session data
        storeUserSessionDataLogin($result);

        
        // Close database connection
        $pdo = null;
        $statement = null;


        // Redirect to home page
        redirectToHome();

    } catch (PDOException $e){
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home if the request method is not POST
    redirectToHome();
}
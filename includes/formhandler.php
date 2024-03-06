<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $pwd = trim($_POST["pwd"]);

    try {
        
        // Database connection and other includes
        require("dbh.inc.php");
        require("../config.php");
        require("../functions.php");
        require("../models/registration.php");

        
        // Validate user input and handle errors
        $errors = validateUserData($pdo, $email, $username, $pwd);

        if ($errors) {
            handleRegistrationErrors($errors, $email, $username);
        }


        // Insert user details into the database
        insertUserDetails($pdo, $email, $username, $pwd);


        // Retrieve user details from the database
        $result = get_user($pdo, $username);


        // Store user session data
        storeUserSessionData($result);


        // Close database connection
        $pdo = null;


        // Redirect to home page
        redirectToHome();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home if the request method is not POST
    redirectToHome();
}

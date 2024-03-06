<?php

/**
 * Checks if the provided email is in a valid format.
 *
 * @param string $email User-provided email.
 * @return bool Returns true if the email is invalid, otherwise false.
 */
function is_email_invalid(string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the provided username is already taken in the database.
 *
 * @param object $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @return bool Returns true if the username is taken, otherwise false.
 */
function is_username_taken(object $pdo, string $username): bool {
    if (get_username($pdo, $username)) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the provided email is already registered in the database.
 *
 * @param object $pdo   PDO database connection.
 * @param string $email User-provided email.
 * @return bool Returns true if the email is already registered, otherwise false.
 */
function is_email_registered(object $pdo, string $email): bool {
    if (get_email($pdo, $email)) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the provided passwords do not match.
 *
 * @param string $pwd         User-provided password.
 * @param string $pwdConfirm  User-provided confirmation password.
 * @return bool Returns true if the passwords don't match, otherwise false.
 */
function is_pwd_invalid(string $pwd, string $pwdConfirm): bool {
    if ($pwd !== $pwdConfirm) {
        return true;
    }
    else {
        return false;  
    }
}



/**
 * Checks if the provided password is too small (less than 8 characters).
 *
 * @param string $pwd User-provided password.
 * @return bool Returns true if the password is too small, otherwise false.
 */
function is_pwd_small(string $pwd): bool {
    if (strlen($pwd) < 8){
        return true;
    }
    else{
        return false;
    }
}



/**
 * Retrieves a username from the database based on the provided username.
 *
 * @param object $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @return array|null Associative array containing the username, or null if not found.
 */
function get_username(object $pdo, string $username): ?array {
    $query = "SELECT username FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();

    $result = $statement -> fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return null;
    }

    return $result;
}



/**
 * Retrieves an email from the database based on the provided email.
 *
 * @param object $pdo   PDO database connection.
 * @param string $email User-provided email.
 * @return array|null Associative array containing the email, or null if not found.
 */
function get_email(object $pdo, string $email): ?array {
    $query = "SELECT email FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();

    $result = $statement -> fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return null;
    }

    return $result;
}



/**
 * Retrieves user details from the database based on the provided username for settings.
 *
 * @param object $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @return array|null Associative array containing user details, or null if not found.
 */
function get_user_settings(object $pdo, string $username): ?array {
    $query = "SELECT * FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();

    $result = $statement -> fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return null;
    }
    
    return $result;
}



/**
 * Validates user settings input data and returns an array of errors.
 *
 * @param object $pdo       PDO database connection.
 * @param string $username   User-provided username.
 * @param string $email      User-provided email.
 * @param string $pwd        User-provided password.
 * @param string $pwdConfirm User-provided confirmation password.
 * @param array  $result     Associative array containing existing user details.
 * @return array Associative array of errors.
 */
function validateSettingsData($pdo, $username, $email, $pwd, $pwdConfirm, $result): array {

    $errors = [];

    if (trim($username) === "") {
        $username = $_SESSION["user_username"];
    }

    if (trim($email) === "") {
        $email = $_SESSION["user_email"];
    }

    if ($username !== $_SESSION["user_username"] && is_username_taken($pdo, $username)) {
        $errors["username_taken"] = "Username already taken";
    }

    if ($email !== $_SESSION["user_email"]) {
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used";
        }

        if (is_email_registered($pdo, $email)) {
            $errors["email_registered"] = "Email already registered";
        }
    }

    if ($pwd !== "") {
        if (is_pwd_invalid($pwd, $pwdConfirm)) {
            $errors["pwd_invalid"] = "Passwords don't match";
        }
        if (is_pwd_small($pwd)) {
            $errors["pwd_small"] = "Your password is too small";
        }

    }

    return $errors;
}



/**
 * Stores user settings form errors in the session and redirects to the settings page.
 *
 * @param array $errors Associative array of errors.
 */
function handleSettingsErrors($errors): void {
    $_SESSION["errors_settings"] = $errors;
    redirectToSettings();
}



/**
 * Updates user information in the database.
 *
 * @param object $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @param string $email    User-provided email.
 */
function updateUserInfo($pdo, $username, $email): void {
    $query = "UPDATE users SET username = :username, email = :email WHERE id = :user_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":user_id", $_SESSION["user_id"]);
    $statement->execute();
}



/**
 * Updates user password in the database.
 *
 * @param object $pdo PDO database connection.
 * @param string $pwd User-provided password.
 */
function updatePwd($pdo, $pwd): void {
    if ($pwd !== "") {
        $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT);
        $query = "UPDATE users SET pwd = :hashedPwd WHERE id = :user_id;";
        $statement = $pdo->prepare($query);
        
        $statement->bindParam(":hashedPwd", $hashedPwd);
        $statement->bindParam(":user_id", $_SESSION["user_id"]);
        $statement->execute();
    }
}



/**
 * Stores user session data after updating settings.
 *
 * @param string $username User-provided username.
 * @param string $email    User-provided email.
 */
function storeUserSessionDataSettings($username, $email): void {
    $_SESSION["user_username"] = $username;
    $_SESSION["user_email"] = $email;
}
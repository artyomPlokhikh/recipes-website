<?php

/**
 * Checks if any of the provided inputs (email, username, password) is empty.
 *
 * @param string $email    User-provided email.
 * @param string $username User-provided username.
 * @param string $pwd      User-provided password.
 * @return bool Returns true if any input is empty, otherwise false.
 */
function is_input_empty(string $email, string $username, string $pwd): bool {
    if (empty($email) || empty($username) || empty($pwd)) {
        return true;
    }
    else {
        return false;
    }
}



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
 * Checks if the provided password is too small (less than 8 characters).
 *
 * @param string $pwd User-provided password.
 * @return bool Returns true if the password is invalid, otherwise false.
 */
function is_pwd_invalid($pwd): bool {
    if (strlen($pwd) < 8){
        return true;
    }
    else{
        return false;
    }
}



/**
 * Validates user input data for registration and returns an array of errors.
 *
 * @param object $pdo      PDO database connection.
 * @param string $email    User-provided email.
 * @param string $username User-provided username.
 * @param string $pwd      User-provided password.
 * @return array Associative array of errors.
 */
function validateUserData($pdo, $email, $username, $pwd): array {
    $errors = [];

    if (is_input_empty($email, $username, $pwd)) {
        $errors["empty_input"] = "Fill in all fields";
    }

    if (is_email_invalid($email)) {
        $errors["invalid_email"] = "Invalid email used";
    }

    if (is_username_taken($pdo, $username)) {
        $errors["username_taken"] = "Username already taken";
    }

    if (is_email_registered($pdo, $email)) {
        $errors["email_registered"] = "Email already registered";
    }

    if (is_pwd_invalid($pwd)) {
        $errors["password_invalid"] = "Your password is too small";
    }

    return $errors;
}



/**
 * Stores registration form errors in the session, stores user input data, and redirects to registration page.
 *
 * @param array  $errors   Associative array of errors.
 * @param string $email    User-provided email.
 * @param string $username User-provided username.
 */
function handleRegistrationErrors($errors, $email, $username): void {
    $_SESSION["errors_signup"] = $errors;

    $signupData = [
        "email" => $email,
        "username" => $username,
    ];

    $_SESSION["signup_data"] = $signupData;

    redirectToRegistration();
}



/**
 * Inserts user details into the database after hashing the password.
 *
 * @param object $pdo      PDO database connection.
 * @param string $email    User-provided email.
 * @param string $username User-provided username.
 * @param string $pwd      User-provided password.
 */
function insertUserDetails($pdo, $email, $username, $pwd): void {
    $query = "INSERT INTO users (email, username, pwd) VALUES (:email, :username, :pwd);";
    $statement = $pdo->prepare($query);

    $options = [
        'cost' => 10,
    ];

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $statement->bindParam(":email", $email);
    $statement->bindParam(":username", $username);
    $statement->bindParam(":pwd", $hashedPwd);

    $statement->execute();
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
 * Retrieves user details from the database based on the provided username.
 *
 * @param object $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @return array|null Associative array containing user details, or null if not found.
 */
function get_user(object $pdo, string $username): ?array {
    $query = "SELECT * FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();

    $result = $statement -> fetch(PDO::FETCH_ASSOC);
    return $result;
}



/**
 * Stores user session data after successful login or registration.
 *
 * @param array $result Associative array containing user data.
 */
function storeUserSessionData($result): void {
    $_SESSION["user_id"] = $result["id"];
    $_SESSION["user_username"] = $result["username"];
    $_SESSION["user_email"] = $result["email"];
    $_SESSION["role"] = $result["role"];
}
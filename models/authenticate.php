<?php

/**
 * Checks if the provided result indicates a wrong username.
 *
 * @param bool|array $result Result of a query or operation.
 * @return bool Returns true if the username is wrong, otherwise false.
 */
function is_username_wrong(bool|array $result): bool {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}



/**
 * Checks if the provided password does not match the hashed password.
 *
 * @param string $pwd         Plain text password.
 * @param string $hashedPwd   Hashed password stored in the database.
 * @return bool Returns true if the password is wrong, otherwise false.
 */
function is_password_wrong(string $pwd, string $hashedPwd): bool {
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}



/**
 * Validates login data and returns an array of errors.
 *
 * @param PDO    $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @param string $pwd      User-provided password.
 * @param array  $result   Result of a query or operation.
 * @return array Associative array of errors.
 */
function validateLoginData($pdo, $username, $pwd, $result): array {
    $errors = [];

    if (is_input_empty($username, $pwd)) {
        $errors["empty_input"] = "Fill in all fields!";
    }

    if (is_username_wrong($result)) {
        $errors["login_incorrect"] = "Incorrect info!";
    }

    if (!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])) {
        $errors["login_incorrect"] = "Incorrect info!";
    }

    return $errors;
}



/**
 * Stores login errors in the session and redirects to the login page.
 *
 * @param array $errors Associative array of errors.
 */
function handleLoginErrors($errors): void {
    $_SESSION["errors_login"] = $errors;
    redirectToLogin();
}



/**
 * Retrieves user data from the database based on the provided username.
 *
 * @param PDO    $pdo      PDO database connection.
 * @param string $username User-provided username.
 * @return array Associative array containing user data.
 */
function get_user(object $pdo, string $username): array {
    $query = "SELECT * FROM users WHERE username = :username;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":username", $username);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}



/**
 * Checks if the provided username or password is empty.
 *
 * @param string $username User-provided username.
 * @param string $pwd      User-provided password.
 * @return bool Returns true if either username or password is empty, otherwise false.
 */
function is_input_empty(string $username, string $pwd): bool {
    if (empty($username) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}



/**
 * Stores user session data after successful login.
 *
 * @param array $result Associative array containing user data.
 */
function storeUserSessionDataLogin($result): void {
    $_SESSION["user_id"] = $result["id"];
    $_SESSION["user_username"] = $result["username"];
    $_SESSION["user_email"] = $result["email"];
    $_SESSION["role"] = $result["role"];
}

<?php

/**
 * Dump and die - Outputs a formatted dump of a variable and terminates the script.
 *
 * @param mixed $value - The variable to be dumped.
 */
function dd($value): void {
    echo"<pre>";
        var_dump( $value );
    echo"</pre>";

    die();
}



/**
 * Redirects to the home page.
 */
function redirectToHome(): void {
    header("Location: /~plokhart/");
    die();
}



/**
 * Redirects to the profile page with the specified user ID.
 *
 * @param int $user_id - The user ID.
 */
function redirectToProfile(int $user_id): void {
    header("Location: /~plokhart/profile?id=" . $user_id);
    die();
}



/**
 * Redirects to the recipe page with the specified recipe ID.
 *
 * @param int $recipe_id - The recipe ID.
 */
function redirectToRecipe(int $recipe_id): void {
    header("Location: /~plokhart/recipe?id=" . $recipe_id);
    die();
}



/**
 * Redirects to the registration page.
 */
function redirectToRegistration(): void {
    header("Location: /~plokhart/registration");
    die();
}



/**
 * Redirects to the login page.
 */
function redirectToLogin(): void {
    header("Location: /~plokhart/authenticate");
    die();
}



/**
 * Redirects to the settings page.
 */
function redirectToSettings(): void {
    header("Location: /~plokhart/profile/settings");
    die();
}



define ('SITE_ROOT', realpath(dirname(__FILE__)));









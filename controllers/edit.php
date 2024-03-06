<?php

require_once(__DIR__ . '/../includes/dbh.inc.php');
require_once(__DIR__ . '/../functions.php');



$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($queryString, $params);

$recipe_id = isset($params['id']) ? $params['id'] : null;



$recipeQuery = "SELECT * FROM recipes WHERE recipe_id = :recipe_id";
$recipeStatement = $pdo->prepare($recipeQuery);
$recipeStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$recipeStatement->execute();
$selected_recipe = $recipeStatement->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION["user_id"]) || ($_SESSION["user_id"] != $selected_recipe["user_id"]) 
&&
(!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin'))
{
    header("Location: /~plokhart/");
    exit();
}



$ingredientsQuery = "SELECT * FROM ingredients WHERE recipe_id = :recipe_id";
$ingredientsStatement = $pdo->prepare($ingredientsQuery);
$ingredientsStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$ingredientsStatement->execute();
$selected_ingredients = $ingredientsStatement->fetchAll(PDO::FETCH_ASSOC);


$amountDict = [
    '0' => '',
    'half' => '½',
    'third' => '⅓',
    'quarter' => '¼'
];

$units = ['Please select...', 'bag', 'bar', 'bulb', 'capsule', 'cl', 'clove', 'cup', 'drop', 'g', 'gallon', 'head', 'kg', 'l', 'lb', 'leaf', 'loaf', 'meter', 'ml', 'package', 'piece', 'pinch', 'pint', 'scoop', 'sheet', 'slice', 'spoon', 'stick', 'tea bag', 'tea spoon'];


$stepsQuery = "SELECT * FROM cooking_steps WHERE recipe_id = :recipe_id";
$stepsStatement = $pdo->prepare($stepsQuery);
$stepsStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$stepsStatement->execute();
$selected_steps = $stepsStatement->fetchAll(PDO::FETCH_ASSOC);



/**
 * Checks and displays a specific edit error stored in the session.
 * If the specified error is found, it displays the error message in red, and then clears the session error.
 *
 * @param string $error - The key of the error message in the session.
 */
function check_edit_errors(string $error): void {
    if (isset($_SESSION["errors_edit"][$error])) {
        echo "<p style='color: red;font-size: 14px;'>". $_SESSION["errors_edit"][$error] ."</p>";
        unset($_SESSION["errors_edit"][$error]);
    }
}



/**
 * Checks and displays image-related edit errors stored in the session.
 * Calls the check_edit_errors function for each specific image-related error.
 */
function check_edit_errors_image(): void {
    check_edit_errors("invalid_image_ext");
    check_edit_errors("image_errors");
    check_edit_errors("image_small");
    check_edit_errors("image_big");
}



/**
 * Checks and displays ingredient-related edit errors stored in the session.
 * Calls the check_edit_errors function for each specific ingredient-related error.
 */
function check_edit_errors_ingredients(): void {
    check_edit_errors("invalid_ingredientAmount");
    check_edit_errors("empty_ingredientAmount");
    check_edit_errors("invalid_ingredientUnit");
    check_edit_errors("no_ingredients");
}


require('views/edit.view.php');

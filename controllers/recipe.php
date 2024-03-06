<?php

require_once(__DIR__ . '/../includes/dbh.inc.php');

$queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($queryString, $params);



$recipe_id = isset($params['id']) ? $params['id'] : null;

$recipeQuery = "SELECT * FROM recipes WHERE recipe_id = :recipe_id";
$recipeStatement = $pdo->prepare($recipeQuery);
$recipeStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$recipeStatement->execute();
$selected_recipe = $recipeStatement->fetch(PDO::FETCH_ASSOC);



$ingredientsQuery = "SELECT * FROM ingredients WHERE recipe_id = :recipe_id";
$ingredientsStatement = $pdo->prepare($ingredientsQuery);
$ingredientsStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$ingredientsStatement->execute();
$selected_ingredients = $ingredientsStatement->fetchAll(PDO::FETCH_ASSOC);



$stepsQuery = "SELECT * FROM cooking_steps WHERE recipe_id = :recipe_id";
$stepsStatement = $pdo->prepare($stepsQuery);
$stepsStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
$stepsStatement->execute();
$selected_steps = $stepsStatement->fetchAll(PDO::FETCH_ASSOC);



$authorQuery = "SELECT * FROM users WHERE id = :id";
$authorStatement = $pdo->prepare($authorQuery);
$authorStatement->bindParam(':id', $selected_recipe["user_id"], PDO::PARAM_INT);
$authorStatement->execute();
$selected_author = $authorStatement->fetch(PDO::FETCH_ASSOC);

    

$amountDict = [
    '0' => '',
    'half' => '½',
    'third' => '⅓',
    'quarter' => '¼'
];

foreach ($selected_ingredients as &$ingredient):
    if (array_key_exists($ingredient["amountIntegerValue"], $amountDict)) {
        $ingredient["amountIntegerValue"] = $amountDict[$ingredient["amountIntegerValue"]];
    }
    if (array_key_exists($ingredient["amountFractionValue"], $amountDict)) {
        $ingredient["amountFractionValue"] = $amountDict[$ingredient["amountFractionValue"]];
    }
endforeach;

unset($ingredient);



require "views/recipe.view.php";
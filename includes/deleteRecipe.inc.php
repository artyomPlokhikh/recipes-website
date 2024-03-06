<?php
require("../functions.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get recipe ID from the POST data
    $recipe_id = $_POST["recipe_id"];

    try {
        // Include necessary files and establish a database connection
        require_once("../config.php");
        require("dbh.inc.php");

        // Check if the user has permission to delete the recipe
        if (!hasPermissionToDeleteRecipe($pdo, $recipe_id)) {
            redirectToHome();
        }

        // Delete the recipe
        deleteRecipe($pdo, $recipe_id);

        // Redirect to the user's profile after deletion
        redirectToProfile($_SESSION["user_id"]);
    } catch (PDOException $e) {
        // Handle database errors
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home if the request method is not POST
    redirectToHome();
}

// Function to check if the user has permission to delete the recipe
function hasPermissionToDeleteRecipe($pdo, $recipe_id) {
    $recipeQuery = "SELECT user_id FROM recipes WHERE recipe_id = :recipe_id";
    $recipeStatement = $pdo->prepare($recipeQuery);
    $recipeStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $recipeStatement->execute();
    $selected_recipe = $recipeStatement->fetch(PDO::FETCH_ASSOC);

    return ($selected_recipe["user_id"] === $_SESSION["user_id"] || $_SESSION["role"] === 'admin');
}

// Function to delete the recipe
function deleteRecipe($pdo, $recipe_id) {
    $deleteQuery = "DELETE FROM recipes WHERE recipe_id = :recipe_id";
    $deleteStatement = $pdo->prepare($deleteQuery);
    $deleteStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $deleteStatement->execute();
}
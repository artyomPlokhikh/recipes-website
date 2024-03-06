<?php

/**
 * Checks if the current user has permission to edit the specified recipe.
 *
 * @param PDO    $pdo       PDO database connection.
 * @param int    $recipe_id ID of the recipe to be edited.
 * @return bool Returns true if the user has permission, otherwise false.
 */
function hasPermissionToEditRecipe($pdo, $recipe_id): bool {
    $recipeQuery = "SELECT user_id FROM recipes WHERE recipe_id = :recipe_id";
    $recipeStatement = $pdo->prepare($recipeQuery);
    $recipeStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $recipeStatement->execute();
    $selected_recipe = $recipeStatement->fetch(PDO::FETCH_ASSOC);

    return ($selected_recipe["user_id"] == $_SESSION["user_id"] || $_SESSION["role"] == 'admin');
}



/**
 * Validates form data for editing a recipe and returns an array of errors.
 *
 * @param string $recipe_title        Title of the recipe.
 * @param int    $portionValue        Portion value of the recipe.
 * @param string $portionType         Portion type of the recipe.
 * @param int    $prepTimeHoursValue  Prep time hours of the recipe.
 * @param int    $prepTimeMinsValue   Prep time minutes of the recipe.
 * @param array  $ingredients         Array containing ingredient details.
 * @return array Associative array of errors.
 */
function validateEditData($recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue, $ingredients): array {
    $errors = [];

    if (is_recipe_empty($recipe_title)) {
        $errors["empty_recipeName"] = "Please, name your recipe";
    }

    if (is_portionValue_invalid($portionValue)) {
        $errors["invalid_portionValue"] = "Invalid portion value";
    }

    if (is_portionType_invalid($portionType)) {
        $errors["invalid_portionType"] = "Invalid portion type";
    }

    if (is_preptime_invalid($prepTimeHoursValue, $prepTimeMinsValue)) {
        $errors["invalid_preptime"] = "Invalid prep time";
    }

    if (is_preptime_empty($prepTimeHoursValue, $prepTimeMinsValue)) {
        $errors["empty_preptime"] = "Empty prep time";
    }

    if (is_ingredientAmount_invalid($ingredients)) {
        $errors["invalid_ingredientAmount"] = "Invalid ingredient amount";
    }

    if (is_ingredientAmount_empty($ingredients)) {
        $errors["empty_ingredientAmount"] = "Empty ingredient amount";
    }

    if (is_ingredientUnit_invalid($ingredients)) {
        $errors["invalid_ingredientUnit"] = "Invalid ingredient unit";
    }

    return $errors;
}



/**
 * Stores edit form errors in the session and redirects back to the edit page.
 *
 * @param array $errors    Associative array of errors.
 * @param int   $recipe_id ID of the recipe being edited.
 */
function handleEditErrors($errors, $recipe_id): void {
    $_SESSION["errors_edit"] = $errors;
    header("Location: /~plokhart/edit?id=$recipe_id");
    die();
}



/**
 * Updates the details of a recipe in the database.
 *
 * @param PDO    $pdo                PDO database connection.
 * @param int    $recipe_id          ID of the recipe to be updated.
 * @param string $recipe_title       New title of the recipe.
 * @param int    $portionValue       New portion value of the recipe.
 * @param string $portionType        New portion type of the recipe.
 * @param int    $prepTimeHoursValue New prep time hours of the recipe.
 * @param int    $prepTimeMinsValue  New prep time minutes of the recipe.
 */
function updateRecipeDetails($pdo, $recipe_id, $recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue): void {

    $query = "UPDATE recipes 
            SET recipe_title = :recipe_title,
                portionValue = :portionValue,
                portionType = :portionType,
                prepTimeHoursValue = :prepTimeHoursValue,
                prepTimeMinsValue = :prepTimeMinsValue
            WHERE recipe_id = :recipe_id";

    $statement = $pdo->prepare($query);
    $statement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $statement->bindParam(':recipe_title', $recipe_title, PDO::PARAM_STR);
    $statement->bindParam(':portionValue', $portionValue, PDO::PARAM_INT);
    $statement->bindParam(':portionType', $portionType, PDO::PARAM_STR);
    $statement->bindParam(':prepTimeHoursValue', $prepTimeHoursValue, PDO::PARAM_INT);
    $statement->bindParam(':prepTimeMinsValue', $prepTimeMinsValue, PDO::PARAM_INT);
    $statement->execute();
}



/**
 * Handles the deletion and insertion of ingredients for a recipe.
 *
 * @param PDO   $pdo         PDO database connection.
 * @param int   $recipe_id   ID of the recipe to which ingredients belong.
 * @param array $ingredients Array containing ingredient details.
 */
function handleIngredients($pdo, $recipe_id, $ingredients): void {
    // Delete existing ingredients
    $deleteQuery = "DELETE FROM ingredients WHERE recipe_id = :recipe_id";
    $deleteStatement = $pdo->prepare($deleteQuery);
    $deleteStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $deleteStatement->execute();

    // Insert new ingredients
    foreach ($ingredients as $ingredient) {
        $insertQuery = "INSERT INTO ingredients (recipe_id, amountIntegerValue, amountFractionValue, amountUnitValue, ingredientNameValue) 
                        VALUES (:recipe_id, :amountInteger, :amountFraction, :amountUnit, :ingredientName)";
        $insertStatement = $pdo->prepare($insertQuery);
        $insertStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $insertStatement->bindParam(':amountInteger', $ingredient['amountInteger'], PDO::PARAM_INT);
        $insertStatement->bindParam(':amountFraction', $ingredient['amountFraction'], PDO::PARAM_STR);
        $insertStatement->bindParam(':amountUnit', $ingredient['amountUnit'], PDO::PARAM_STR);
        $insertStatement->bindParam(':ingredientName', $ingredient['ingredientName'], PDO::PARAM_STR);
        $insertStatement->execute();
    }
}



/**
 * Handles the deletion and insertion of cooking steps for a recipe.
 *
 * @param PDO   $pdo         PDO database connection.
 * @param int   $recipe_id   ID of the recipe to which cooking steps belong.
 * @param array $steps       Array containing cooking steps.
 */
function handleCookingSteps($pdo, $recipe_id, $steps): void {
    // Delete existing cooking steps
    $deleteQuery = "DELETE FROM cooking_steps WHERE recipe_id = :recipe_id";
    $deleteStatement = $pdo->prepare($deleteQuery);
    $deleteStatement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
    $deleteStatement->execute();

    // Insert new cooking steps
    foreach ($steps as $step) {
        $query = "INSERT INTO cooking_steps (recipe_id, step_description) VALUES (:recipe_id, :step_description)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        $statement->bindParam(':step_description', $step, PDO::PARAM_STR);
        $statement->execute();
    }
}

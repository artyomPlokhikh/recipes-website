<?php

/**
 * Checks if the recipe title is empty.
 *
 * @param string $recipe_title Recipe title.
 * @return bool Returns true if the recipe title is empty, otherwise false.
 */
function is_recipe_empty($recipe_title): bool {
    if (empty($recipe_title)){
        return true;
    } 
    else {
        return false;
    }
}



/**
 * Checks if the portion value is within a valid range.
 *
 * @param int $portionValue Portion value.
 * @return bool Returns true if the portion value is invalid, otherwise false.
 */
function is_portionValue_invalid($portionValue): bool {
    if (!($portionValue >= 1 && $portionValue < 100)) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the portion type is valid.
 *
 * @param string $portionType Portion type.
 * @return bool Returns true if the portion type is invalid, otherwise false.
 */
function is_portionType_invalid($portionType): bool {
    $portionTypeOptions = ["servings", "pieces"];
    if (!in_array($portionType, $portionTypeOptions)) {
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the preparation time values are within valid ranges.
 *
 * @param int $prepTimeHoursValue Hours in preparation time.
 * @param int $prepTimeMinsValue  Minutes in preparation time.
 * @return bool Returns true if the preparation time is invalid, otherwise false.
 */
function is_preptime_invalid($prepTimeHoursValue, $prepTimeMinsValue): bool {
    if (!($prepTimeHoursValue >= 0 && $prepTimeHoursValue < 100) ||
        !($prepTimeMinsValue >= 0 && $prepTimeMinsValue < 60)
    ) {
        return true;
    } else {
        return false;
    }
}



/**
 * Checks if the preparation time is empty.
 *
 * @param int $prepTimeHoursValue Hours in preparation time.
 * @param int $prepTimeMinsValue  Minutes in preparation time.
 * @return bool Returns true if the preparation time is empty, otherwise false.
 */
function is_preptime_empty($prepTimeHoursValue, $prepTimeMinsValue): bool {
    if ($prepTimeHoursValue == 0 && $prepTimeMinsValue == 0) {
        return true;
    } else {
        return false;
    }
}



/**
 * Checks if the ingredient amounts are within valid ranges.
 *
 * @param array $ingredients Array of ingredients with amount details.
 * @return bool Returns true if any ingredient amount is invalid, otherwise false.
 */
function is_ingredientAmount_invalid($ingredients): bool {
    $fractionOptions = ['0', 'half', 'third', 'quarter'];

    foreach ($ingredients as $ingredient) {
        if (!($ingredient['amountInteger'] >= 0 && $ingredient['amountInteger'] < 100) ||
            !(in_array($ingredient['amountFraction'], $fractionOptions))
        ) {
            return true;
        }
    }

    return false;
}



/**
 * Checks if any ingredient amount is empty.
 *
 * @param array $ingredients Array of ingredients with amount details.
 * @return bool Returns true if any ingredient amount is empty, otherwise false.
 */
function is_ingredientAmount_empty($ingredients): bool {
    foreach ($ingredients as $ingredient) {
        if ($ingredient['amountInteger'] == 0 && $ingredient['amountFraction'] == "0") {
            return true;
        }
    }

    return false;
}



/**
 * Checks if the ingredient units are valid.
 *
 * @param array $ingredients Array of ingredients with unit details.
 * @return bool Returns true if any ingredient unit is invalid, otherwise false.
 */
function is_ingredientUnit_invalid($ingredients): bool {
    $unitOptions = ['bag', 'bar', 'bulb', 'capsule', 'cl', 'clove', 'cup', 'drop', 'g', 'gallon', 'head', 'kg', 'l', 'lb', 'leaf', 'loaf', 'meter', 'ml', 'package', 'piece', 'pinch', 'pint', 'scoop', 'sheet', 'slice', 'spoon', 'stick', 'tea bag', 'tea spoon'];

    foreach ($ingredients as $ingredient) {
        if (!in_array($ingredient['amountUnit'], $unitOptions)) {
            return true;
        }
    }

    return false;
}



/**
 * Checks if the ingredients array is empty.
 *
 * @param array $ingredients Array of ingredients.
 * @return bool Returns true if there are no ingredients, otherwise false.
 */
function no_ingredients($ingredients): bool {
    if (empty($ingredients)) {
        return true;
    } else {
        return false;
    }
}



/**
 * Checks if the cooking steps array is empty.
 *
 * @param array $steps Array of cooking steps.
 * @return bool Returns true if there are no cooking steps, otherwise false.
 */
function no_steps($steps): bool {
    if (empty($steps)) {
        return true;
    } else {
        return false;
    }
}



/**
 * Validates recipe form data and returns an array of errors.
 *
 * @param string $recipe_title       Recipe title.
 * @param int    $portionValue       Portion value.
 * @param string $portionType        Portion type.
 * @param int    $prepTimeHoursValue Hours in preparation time.
 * @param int    $prepTimeMinsValue  Minutes in preparation time.
 * @param array  $ingredients        Array of ingredients with details.
 * @param array  $steps              Array of cooking steps.
 * @return array Associative array of errors.
 */
function validateFormData($recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue, $ingredients, $steps): array {
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
    
    if (no_ingredients($ingredients)) {
        $errors["no_ingredients"] = "Please add your ingredients";
    }

    if (no_steps($steps)) {
        $errors["no_steps"] = "Please add your cooking steps";
    }

    return $errors;
}



/**
 * Checks if the image file extension is invalid.
 *
 * @param string $fileActualExt File's actual extension.
 * @param array  $allowed       Array of allowed file extensions.
 * @return bool Returns true if the image extension is invalid, otherwise false.
 */
function is_image_ext_invalid($fileActualExt, $allowed): bool {
    if (!in_array($fileActualExt, $allowed)){
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the image upload has errors.
 *
 * @param int $imageError Error code from image upload.
 * @return bool Returns true if there are image upload errors, otherwise false.
 */
function image_has_errors($imageError): bool {
    if (!($imageError === 0)){
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the image size is too small.
 *
 * @param int $imageSize Image size in bytes.
 * @return bool Returns true if the image size is too small, otherwise false.
 */
function is_image_too_small($imageSize): bool {
    if ($imageSize < 50000){
        return true;
    }
    else {
        return false;
    }
}



/**
 * Checks if the image size is too big.
 *
 * @param int $imageSize Image size in bytes.
 * @return bool Returns true if the image size is too big, otherwise false.
 */
function is_image_too_big($imageSize): bool {
    if ($imageSize > 5000000){
        return true;
    }
    else {
        return false;
    }
}



/**
 * Stores image upload errors in the session and redirects to the upload page.
 *
 * @param array $errors Associative array of errors.
 */
function handleUploadErrors($errors): void {
    $_SESSION["errors_upload"] = $errors;
    header("Location: /~plokhart/upload");
    die();
}



/**
 * Inserts recipe details into the database.
 *
 * @param object $pdo              PDO database connection.
 * @param int    $user_id           User ID.
 * @param string $recipe_title      Recipe title.
 * @param int    $portionValue      Portion value.
 * @param string $portionType       Portion type.
 * @param int    $prepTimeHoursValue Hours in preparation time.
 * @param int    $prepTimeMinsValue  Minutes in preparation time.
 * @return int Last inserted recipe ID.
 */
function insertRecipeDetails($pdo, $user_id, $recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue): int {
    $query = "INSERT INTO recipes (user_id, recipe_title, portionValue, portionType, prepTimeHoursValue, prepTimeMinsValue) VALUES (:user_id, :recipe_title, :portionValue, :portionType, :prepTimeHoursValue, :prepTimeMinsValue)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':recipe_title', $recipe_title, PDO::PARAM_STR);
    $statement->bindParam(':portionValue', $portionValue, PDO::PARAM_INT);
    $statement->bindParam(':portionType', $portionType, PDO::PARAM_STR);
    $statement->bindParam(':prepTimeHoursValue', $prepTimeHoursValue, PDO::PARAM_INT);
    $statement->bindParam(':prepTimeMinsValue', $prepTimeMinsValue, PDO::PARAM_INT);
    $statement->execute();

    return $pdo->lastInsertId();
}



/**
 * Inserts ingredients into the database.
 *
 * @param object $pdo       PDO database connection.
 * @param int    $recipeId   Recipe ID.
 * @param array  $ingredients Array of ingredients with details.
 */
function insertIngredients($pdo, $recipeId, $ingredients): void {
    foreach ($ingredients as $ingredient) {
        $query = "INSERT INTO ingredients (recipe_id, amountIntegerValue, amountFractionValue, amountUnitValue, ingredientNameValue) VALUES (:recipe_id, :amountInteger, :amountFraction, :amountUnit, :ingredientName)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
        $statement->bindParam(':amountInteger', $ingredient['amountInteger'], PDO::PARAM_INT);
        $statement->bindParam(':amountFraction', $ingredient['amountFraction'], PDO::PARAM_STR);
        $statement->bindParam(':amountUnit', $ingredient['amountUnit'], PDO::PARAM_STR);
        $statement->bindParam(':ingredientName', $ingredient['ingredientName'], PDO::PARAM_STR);
        $statement->execute();
    }
}



/**
 * Inserts cooking steps into the database.
 *
 * @param object $pdo     PDO database connection.
 * @param int    $recipeId Recipe ID.
 * @param array  $steps    Array of cooking steps.
 */
function insertCookingSteps($pdo, $recipeId, $steps): void {
    foreach ($steps as $step) {
        $query = "INSERT INTO cooking_steps (recipe_id, step_description) VALUES (:recipe_id, :step_description)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);
        $statement->bindParam(':step_description', $step, PDO::PARAM_STR);
        $statement->execute();
    }
}

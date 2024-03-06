<?php
require("../functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $recipe_id = $_POST["recipe_id"];
    $recipe_title = $_POST["recipe_title"];
    $portionValue = $_POST["portionValue"];
    $portionType = $_POST["portionType"];
    $prepTimeHoursValue = $_POST["prepTimeHoursValue"];
    $prepTimeMinsValue = $_POST["prepTimeMinsValue"];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['step_description'];
    $image = $_FILES['image'];


if (!($image['error'] == UPLOAD_ERR_NO_FILE)) {
    
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageSize = $_FILES['image']['size'];
    $imageError = $_FILES['image']['error'];
    $imageType = $_FILES['image']['type'];
    
    $fileExt = explode('.', $imageName);
    $fileActualExt = strtolower(end($fileExt));
    $imageNameNew = uniqid('', true) . "." . $fileActualExt;
    
    
    $imageDestination = SITE_ROOT.'/uploads/recipePhotoes/' . $imageNameNew;
    
    $allowed = array('jpg', 'jpeg');
}


    // Establish database connection
    try {
        require("dbh.inc.php");
        require("../models/upload.php");
        require("../models/edit.php");
        require_once("../config.php");

        // Check if the user has permission to edit the recipe
        if (!hasPermissionToEditRecipe($pdo, $recipe_id)) {
            redirectToHome();
        }



        // Validate form data
        $errors = validateEditData($recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue, $ingredients);

        if (!($image['error'] == UPLOAD_ERR_NO_FILE)) {
            if (is_image_ext_invalid($fileActualExt, $allowed)) {
                $errors["invalid_image_ext"] = "Invalid image extension";
            }
    
            if (image_has_errors($imageError)) {
                $errors["image_errors"] = "Your image has errors";
            }
    
            if (is_image_too_small($imageSize)) {
                $errors["image_small"] = "Your image is too small";
            }
    
            if (is_image_too_big($imageSize)) {
                $errors["image_big"] = "Your image is too big";
            }
        }
        // Handle errors
        if ($errors) {
            handleEditErrors($errors, $recipe_id);
        }

        // Image Upload
        if (!($image['error'] == UPLOAD_ERR_NO_FILE))  {
            move_uploaded_file($imageTmpName, $imageDestination);            
        }


        // Update recipe details
        updateRecipeDetails($pdo, $recipe_id, $recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue);

        // Delete existing ingredients and insert new ones
        handleIngredients($pdo, $recipe_id, $ingredients);

        // Delete existing cooking steps and insert new ones
        handleCookingSteps($pdo, $recipe_id, $steps);

        
        // Update recipe image ID if an image was provided
        if (!($image['error'] == UPLOAD_ERR_NO_FILE)) {
            $query = "UPDATE recipes SET image_id = :image_id WHERE recipe_id = :recipe_id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);        
            $statement->bindParam(':image_id', $imageNameNew, PDO::PARAM_STR);        
            $statement->execute();
        }

        // Redirect to the recipe page
        redirectToRecipe($recipe_id);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    // Redirect to home if the request method is not POST
    redirectToHome();
}








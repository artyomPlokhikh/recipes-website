<?php
require("../functions.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $recipe_title = trim($_POST["recipe_title"]);
    $portionValue = $_POST["portionValue"];
    $portionType = $_POST["portionType"];
    $prepTimeHoursValue = $_POST["prepTimeHoursValue"];
    $prepTimeMinsValue = $_POST["prepTimeMinsValue"];

    if (isset($_POST['ingredients'])){
        $ingredients = $_POST['ingredients'];
    } else{
        $ingredients=[];
    }
    
    $steps = $_POST['step_description'];
    $image = $_FILES['image'];


    // IMAGE VALIDATION
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
    
    try {
        require("dbh.inc.php");
        require("../models/upload.php");
        require_once("../config.php");
        
        // ERROR HANDLER 
        $errors = validateFormData($recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue, $ingredients, $steps);


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



        if ($errors) {
            handleUploadErrors($errors);
        }



        $user_id = $_SESSION['user_id'];

        if (!($image['error'] == UPLOAD_ERR_NO_FILE))  {
            move_uploaded_file($imageTmpName, $imageDestination);            
        }


        // Insert recipe details into the database
        $recipeId = insertRecipeDetails($pdo, $user_id, $recipe_title, $portionValue, $portionType, $prepTimeHoursValue, $prepTimeMinsValue);

        // Insert ingredients into the database
        insertIngredients($pdo, $recipeId, $ingredients);

        // Insert cooking steps into the database
        insertCookingSteps($pdo, $recipeId, $steps);


        // Insert image link into the database
        if (!($image['error'] == UPLOAD_ERR_NO_FILE)) {
            $query = "UPDATE recipes SET image_id = :image_id WHERE recipe_id = :recipe_id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':recipe_id', $recipeId, PDO::PARAM_INT);        
            $statement->bindParam(':image_id', $imageNameNew, PDO::PARAM_STR);        
            $statement->execute();
        }


        redirectToHome();
        
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else{
    redirectToHome();
}
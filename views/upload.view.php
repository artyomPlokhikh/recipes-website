<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add your recipe</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/recipe.css">
    <link rel="stylesheet" href="styles/upload.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
</head>
<body>



<?php require "partials/header.php"; ?>


<main>
    <form action="includes/upload.inc.php" method="POST" id="upload-recipe" enctype="multipart/form-data">
        <div class="recipe-name">
            <div class="upload-recipe-label-input">
                <label for="recipe_title">name your recipe<span class="accentSpan">*</span> </label>
            </div>
            <input type="text" placeholder="E.g. Grandma's apple pie" id="upload-recipe-name-input" name="recipe_title">
            <?php check_upload_errors("empty_recipeName") ?>
        </div>

        <div class="container-picture-upload">
            <div class="upload-recipe-label-input">
                <label for="">add a photo</label>
            </div>
            <div class="picture-upload">
                <label for="" id="picture-upload-label">
                    <input type="file" name="image" id="picture-upload-input" accept="image/*">
                    <div class="picture-upload-spaceholder" id="preview">
                        <i class="fa-solid fa-camera"></i>
                        <p>Upload a photo of your dish now or add it later</p>
                    </div>
                </label>
                <p class="picture-upload-actions">
                    <label for="picture-upload-input">Upload a photo</label>
                    <span class="picture-upload-actions-description">
                        Images must be original personal photos, in jpg/jpeg/png format, with a minimum size of 1000x1000 pixels.
                    </span>
                </p>
            </div>
            <?php check_upload_errors_image() ?>
            
        </div>


        <div class="container-recipe-selections">
            <div class="upload-recipe-label-input">
                <label for="">portion type<span class="accentSpan">*</span></label>
                <p>Choose between servings (a filling portion for one person) or pieces (e.g. slice of cake).</p>
            </div>
            <div class="upload-recipe-selections">
                <div class="upload-recipe-selections-wrapper">
                    <select name="portionValue" class="upload-recipe-selections-select" id="portionValue">
                        <?php
                            for ($i = 1; $i < 100; $i++) 
                            {
                                echo "<option value=\"$i\">$i</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="upload-recipe-selections-wrapper">
                    <select name="portionType" class="upload-recipe-selections-select" id="portionType">
                        <option value="servings">servings</option>
                        <option value="pieces">pieces</option>
                    </select>
                </div>
            </div>
            <?php check_upload_errors("invalid_portionValue") ?>
            <?php check_upload_errors("invalid_portionType") ?>
            
        </div>

        <div class="container-recipe-selections">
            <div class="upload-recipe-label-input">
                <label for="">Cooking time<span class="accentSpan">*</span></label>
                <p>How much time do you actively spend making the dish, including cooking time on the stove?</p>
            </div>
            <div class="upload-recipe-selections">
                <div class="upload-recipe-selections-wrapper">
                    <select name="prepTimeHoursValue" class="upload-recipe-selections-select" id="prepTimeHoursValue">
                        <?php
                            for ($i = 0; $i < 100; $i++) 
                            {
                                echo "<option value=\"$i\">$i</option>";
                            }
                        ?>

                    </select>
                </div>
                <label for="prepTimeHoursValue">hours</label>

                <div class="upload-recipe-selections-wrapper">
                    <select name="prepTimeMinsValue" class="upload-recipe-selections-select" id="prepTimeMinsValue">
                        <?php
                            for ($i = 0; $i < 60; $i++) 
                            {
                                echo "<option value=\"$i\">$i</option>";
                            }
                        ?>
                    </select>
                </div>
                <label for="prepTimeMinsValue">minutes</label>
            </div>
            <?php check_upload_errors("invalid_preptime") ?>
            <?php check_upload_errors("empty_preptime") ?>
            
        </div>



        <section id="container-recipe-guide__ingredients">
               
            <div class="recipe-guide" id="ingredients">
                <h1>ADD AN INGREDIENT<span class="accentSpan">*</span></h1>

                        <div class="container-upload-recipe-ingredient">
                            <div>
                                <div>
                                    <label for="amountIntegerValue" class="upload-recipe-ingredient-label">amount</label>
                                </div>
                                <div class="container-upload-recipe-selections-wrapper">
                                    <div class="upload-recipe-selections-wrapper">
                                        <select name="amountIntegerValue" class="upload-recipe-selections-select" id="amountIntegerValue">
                                            <?php
                                                for ($i = 0; $i < 100; $i++) 
                                                {
                                                    echo "<option value=\"$i\">$i</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="upload-recipe-selections-wrapper">
                                        <select name="amountFractionValue" class="upload-recipe-selections-select" id="amountFractionValue">
                                            <option value="0">0</option>
                                            <option value="half">½</option>
                                            <option value="third">⅓</option>
                                            <option value="quarter">¼</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="amountUnitValue" class="upload-recipe-ingredient-label">unit</label>
                                </div>
                                <div class="upload-recipe-selections-wrapper">
                                    <select name="amountUnitValue" class="upload-recipe-selections-select" id="amountUnitValue" tabindex="1">
                                        <?php
                                            foreach ($units as $unit) {
                                                echo "<option value=\"$unit\">$unit</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="ingredientNameValue" class="upload-recipe-ingredient-label">ingredient</label>
                                </div>
                                <div class="recipe-name" id="recipe-name-ingredient">
                                    <input type="text" list="wordSuggestions" name="ingredientNameValue" id="ingredientNameValue" placeholder="Add ingredient, e.g. flour">
                                    <datalist id="wordSuggestions">
                                        <!-- <option value=""></option> -->
                                    </datalist>

                                </div>
                            </div>

                            <div id="upload-recipe-ingredient-icon">
                                <div class="upload-recipe-ingredient-label">
                                    <label for="">Add</label>
                                </div>
                                <div class="upload-recipe-ingredient-add-btn" id="addIngredientBtn">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </div>
            </div>

            <div>
                <h2>INGREDIENT LIST</h2>
                <div>
                    <ul class="recipe-creation-ingredients-list__list" id="ingredientList">
    
                    </ul>
                </div>
            </div>
        
            <?php check_upload_errors_ingredients() ?>

        </section>

        <section id="container-recipe-guide__steps">
            <div class="recipe-guide" id="step">
                <h1>ADD A STEP<span class="accentSpan">*</span></h1>
                <div class="container-upload-recipe-step">
                    <div>
                        <p>Each recipe step should be helpful, easy to understand, and focus on clear actions related to the recipe. </p>
                    </div>
                    <textarea name="step_description" id="uploadRecipeStepTextarea" rows="6" maxlength="500" placeholder="What needs to be done in this step?"></textarea>
                    <div class="recipe-creation-add-steps__actions">
                        <div>
                            <span id="addStepBtn">Add a step</span>
                        </div>

                    </div>
                </div>

            <div>
                <h2>STEPS</h2>
                <div id="container-recipe-creation-ingredients-list__list">
                    <ul class="recipe-creation-ingredients-list__list" id="stepList">
                    </ul>
                </div>
            </div>
            <?php check_upload_errors("no_steps") ?>

        </section>

        <div class="container-edit-btn">
            <button type="submit" class="upload-submit-btn" id="upload-submit-btn">Submit</button>
        </div>
    </form>
</main>





<script src="scripts/upload.js"></script>
<script src="scripts/wordSuggestion.js"></script>
</body>
</html>
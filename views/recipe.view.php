<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($selected_recipe["recipe_title"]) ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/recipe.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
</head>
<body>

<?php require "partials/header.php"; ?>


<main>
    <div class="recipe-name-recipe">
        <h1>
            <?= htmlspecialchars($selected_recipe["recipe_title"]) ?>
        </h1>

        <?php 
            if ((isset($_SESSION["user_id"]) && $selected_author["id"] == $_SESSION["user_id"]) 
            || 
            (isset($_SESSION["role"]) && $_SESSION["role"] == 'admin')) { 
        ?>
        <div>
            <div class="recipe-edit-btn">
                <a href="/~plokhart/edit?id=<?=  $selected_recipe['recipe_id'] ?>">
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </a>
            </div>
        </div>
        <?php 
            }
        ?>

    </div>



    <div class="layout-items-recipe-author-description">
        <div class="recipe-author">
            <div class="recipe-author-avatar">
                <a href="profile?id=<?= $selected_recipe["user_id"] ?>">
                    <img src="uploads/pfps/<?= $selected_author["pfp"] ?> " alt="<?= htmlspecialchars($selected_author["username"]) ?>" >
                </a>
            </div>
            <div class="recipe-author-name">
                Submitted by
                <a href="profile?id=<?= $selected_recipe["user_id"] ?>">
                    <?= htmlspecialchars($selected_author["username"]) ?>
                </a>
            </div>
        </div>
    </div>

    <div class="recipe-image">
        <img src="uploads/recipePhotoes/<?= $selected_recipe["image_id"] ?>" alt="<?= htmlspecialchars($selected_recipe["recipe_title"])?> " onerror="this.src='uploads/recipePhotoes/recipe-placeholder.jpg'">
    </div>


    <div class="recipe-info">
        <div>
            <i class="fa-solid fa-clock"></i>

            <span>Hours:</span>
            <p><?= $selected_recipe["prepTimeHoursValue"] ?></p>
        </div>               
        <div>
            <i class="fa-regular fa-clock"></i>
            <span>Minutes:</span>
            <p><?= $selected_recipe["prepTimeMinsValue"] ?></p>
        </div>
        <div>
            <i class="fa-solid fa-person"></i>
            <span><?= ucfirst($selected_recipe["portionType"]) ?>:</span>
            <p><?= $selected_recipe["portionValue"] ?></p>
        </div>
    </div>



    <section id="container-recipe-guide">
        <div class="recipe-guide" id="directions">
            <h2>DIRECTIONS</h2>
            <ul>
                <?php 
                    $counter = 1;
                    foreach ($selected_steps as $step) : 
                ?>
                    <li>
                        <small><?= $counter ?>.</small>    
                        <?= htmlspecialchars($step["step_description"])?>
                    </li>
                <?php 
                    $counter++;
                    endforeach; 
                ?>
            </ul>

        </div>

        <div class="recipe-guide" id="ingredients">
            <h2>INGREDIENTS</h2>
            <ul>
                <?php 
                        foreach ($selected_ingredients as $ingredient) : 
                    ?>
                        <li>

                            <?= $ingredient["amountIntegerValue"] ?>
                            <?= $ingredient["amountFractionValue"] ?>
                            <?= $ingredient["amountUnitValue"] ?>
                            
                            <b>
                                <?= htmlspecialchars($ingredient["ingredientNameValue"]) ?>
                            </b>
                        </li>
                    <?php 
                        endforeach; 
                    ?>
            </ul>
        </div>
    </section>
</main>


    <?php require "partials/footer.php"; ?>

<script src="scripts/script.js"></script>
</body>
</html>
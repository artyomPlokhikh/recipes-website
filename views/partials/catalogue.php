<?php require(__DIR__ . '/../../controllers/catalogue.php') ?>
<div class="recipe-container">
    <?php foreach ($all_recipes as $row) : ?>
        <div class="recipe">
            <a href="recipe?id=<?= $row["recipe_id"]?>">
                <div class="recipe-image">
                    <img src="uploads/recipePhotoes/<?= $row["image_id"] ?>" alt="<?= htmlspecialchars($row["recipe_title"]) ?>" onerror="this.src='uploads/recipePhotoes/recipe-placeholder.jpg'">
                </div>
                <h2><?= htmlspecialchars($row["recipe_title"]) ?></h2>
            </a>
            <div class="recipe-info">
                <div>
                    <i class="fa-solid fa-clock"></i>
                    <p><?= $row["prepTimeHoursValue"] ?>h</p>
                </div>
                <div>
                    <i class="fa-regular fa-clock"></i>
                    <p><?= $row["prepTimeMinsValue"] ?>m</p>
                </div>
                <div>
                    <i class="fa-solid fa-person"></i>
                    <p> <?= $row["portionValue"] ?> </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php if ($uri == "/~plokhart/") { ?>

    <div class="page-info">
        <?php 
            if(!isset($_GET["page-nr"])){
                $page = 1;
            } else{
                $page = $_GET["page-nr"];
            }
        ?>
        Showing <?= $page ?> of <?= $pages ?> pages
    </div>

    <div class="pagination">

        <a href="/~plokhart/?page-nr=1">First</a>

        <?php if(isset($_GET["page-nr"]) && $_GET["page-nr"] > 1){ ?>
            <a href="/~plokhart/?page-nr=<?= $_GET["page-nr"] - 1 ?>">Previous</a>
        <?php } else {?>
            <a>Previous</a>
        <?php } ?>

        <div class="page-numbers">
            <?php
                for ($counter = 1; $counter <= $pages; $counter ++){
                    ?>
                    <a href="/~plokhart/?page-nr=<?= $counter ?>"><?= $counter ?> </a>
            <?php
                }
            ?>
        </div>
        <?php if(!isset($_GET["page-nr"])){ ?>
            <a href="">Next</a>
        <?php }else{ 
                if($_GET["page-nr"] >= $pages){ ?>
                    <a>Next</a>
            <?php }else{ ?>
                <a href="/~plokhart/?page-nr=<?= $_GET["page-nr"] + 1 ?>">Next</a>
            <?php } } ?> 

        <a href="/~plokhart/?page-nr=<?= $pages?>">Last</a>
    </div>

<?php } ?>
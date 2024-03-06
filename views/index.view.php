<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/style.css" media="all">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
</head>
<body>

<?php require "partials/header.php";?>

<?php if ($queryString == NULL || $queryString == 'page-nr=1') { ?>
    
    <div class="hero">
            <h1>Discover <br> Delicious Recipes</h1>
        </div>

<?php } ?>

<section class="catalogue" id="catalogueSection">
<h2>Catalogue</h2>     
<?php require "partials/catalogue.php"; ?>
</section>


<?php require "partials/footer.php"; ?>
    



<script src="scripts/script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/recipe.css">
    <link rel="stylesheet" href="styles/upload.css">
    <link rel="stylesheet" href="styles/profile.css">
    <link rel="stylesheet" href="styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php require ("partials/header.php"); ?>


    <main>

    <?php require ("partials/profileInfo.php"); ?>


        <section class="catalogue" id="profile-catalogue">
            <?php require ("partials/catalogue.php"); ?>
        </section>
    </main>


    <?php require ("partials/footer.php"); ?> 
</body>
</html>
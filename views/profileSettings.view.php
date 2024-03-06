<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/recipe.css">
    <link rel="stylesheet" href="../styles/upload.css">
    <link rel="stylesheet" href="../styles/profile.css">
    <link rel="stylesheet" href="../styles/settings.css">
    <link rel="stylesheet" href="../styles/print.css" media="print">
    <script src="https://kit.fontawesome.com/806ba4a05e.js" crossorigin="anonymous"></script>
</head>
<body>
<?php require "partials/header.php"; ?>
    
    <main>  
        <?php check_settings_errors() ?>
    <section class="profile-profile-info">
        
        <form action="../includes/settings.inc.php" id="profile-settings" method="post">
            <div class="recipe-name">
                <div class="upload-recipe-label-input">
                    <label for="username">Name</label>
                </div>
                <input type="text" name="username" placeholder="Your name" value="<?= htmlspecialchars($_SESSION["user_username"]) ?>">
            </div>

            <div class="recipe-name">
                <div class="upload-recipe-label-input">
                    <label for="email">Email</label>
                </div>
                <input type="email" name="email" placeholder="yourname@example.com" value="<?= htmlspecialchars($_SESSION["user_email"]) ?>">
            </div>

            <div class="container-container-settings-password">
                <h2>Change password</h2>
                <span class="explain-text">Your password should have at least 8 characters.</span>
                <div class="container-settings-password">
                    <div class="settings-password">
                        <label for="">new password</label>
                        <div class="recipe-name">
                            <input type="password" class="settings-password" name="pwd" id="password">
                            <span class="password-icon">
                                <i class="fa-solid fa-lock" id="locked"></i>
                                <i class="fa-solid fa-lock-open" id="unlocked"></i>
                            </span>
                        </div>
                    </div>
                    <div class="settings-password">
                        <label for="pwdConfirm">confirm password</label>
                        <div class="recipe-name">
                            <input type="password" class="settings-password" name="pwdConfirm" id="confirmPassword">
                            <span class="password-icon">
                                <i class="fa-solid fa-lock" id="lockedConfirm"></i>
                                <i class="fa-solid fa-lock-open" id="unlockedConfirm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-settings-btn">
                <button type="submit" class="settings-submit-btn">Save Changes</button>
            </div>
        </form>
    </section>

    
    <form action="../includes/logout.inc.php" id="settings-logout">
        <div class="container-settings-btn">
            <button type="submit" class="settings-submit-btn" id="btn-logout">Logout</button>
        </div>
    </form>
    </main>


    
    <?php require "partials/footer.php"; ?>
    <script src="../scripts/settings.js"></script>
</body>
</html>
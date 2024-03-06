<section class="profile-profile-info">
            <div class="profile-profile-main">
                <div class="recipe-author-avatar">
                    <a href="profile?id=<?= $selected_author["id"]?>">
                        <img src="uploads/pfps/<?= $selected_author["pfp"] ?>">
                    </a>
                </div>
                <h1>
                    <?= htmlspecialchars($selected_author["username"]) ?>
                </h1>
            </div>

            <?php 
            if (isset($_SESSION["user_id"]) && $selected_author["id"] == $_SESSION["user_id"]) 
                { 
                    echo('
                        <div class="profile-settings-btn">
                            <a href="/~plokhart/profile/settings">
                                <i class="fa-solid fa-gear"></i>
                                Settings
                            </a>
                        </div>
                        ');

                } 
            ?>

        </section>


        <nav class="profile-navbar">
            <a href="profile?id=<?=$selected_author["id"]?>">
            <i class="fa-solid fa-book"></i>
                recipes
            </a>

        </nav>
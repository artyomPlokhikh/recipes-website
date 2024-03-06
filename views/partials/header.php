<header>
    <nav class="navbar" >
            <div class="icon" id="forDesktop">Recipes Website</div>
            <div class="icon" id="forMobile">RW</div>


            <input type="checkbox" id="check">
            <ul class="nav-links">
                <li><a href="/~plokhart/">Home</a></li>


            <?php 
            if (!isset($_SESSION["user_id"])) { ?>
                <li><a href="/~plokhart/authenticate">Log in</a></li>

            <?php } 
            else { ?>
                <li>
                    <a href="/~plokhart/upload">Upload</a>
                </li>

                <li>
                    <a href="/~plokhart/profile?id=<?= $_SESSION["user_id"]?>">
                        <?= htmlspecialchars($_SESSION["user_username"]) ?> 
                        
                    </a>
                </li>
            <?php } ?>
            </ul>
                <label for="check" class="menu-toggle">
                    <i class="fa-solid fa-bars"></i>
                </label>
    </nav>  
</header>
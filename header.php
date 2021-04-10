<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="container-fluid">
            <h1 class="title"> <a href="<?php echo site_url("/"); ?>">Gamer Revolution</a></h1>

                <nav role="navigation" class="nav-menu"> 
                <div id="menuToggle">
                
                <ul class="nav__items" id="menu">
                    <li <?php if(is_page('playstation-5')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/playstation-5"); ?>">PS5</a></li>
                    <li <?php if(is_page('playstation-4')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/playstation-4"); ?>">PS4</a></li>
                    <li <?php if(is_page('xbox-series-xs')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/xbox-series-xs"); ?>">Xbox Series X/S</a></li>
                    <li <?php if(is_page('xbox-one')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/xbox-one"); ?>">Xbox One</a></li>
                    <li <?php if(is_page('nintendo-switch')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/nintendo-switch"); ?>">Nintendo Switch</a></li>
                    <li <?php if(is_page('pc')) echo 'class="current_menu_item"' ?>><a href="<?php echo site_url("/pc"); ?>">PC</a></li>
                </ul>
                 
                </div> 
    
            <input type="search" name="search" class="searchGame" placeholder="Search for a game..." aria-label="Search through site content">
        
            <section class="hamburgerIcons">
                    <div></div>
                    <div></div>
                    <div></div>
            </section>
            </nav>
        </header>

        <table class="searchResults table table-responsive">
            <tbody class="searchResults__head">
            </tbody>
        </table>
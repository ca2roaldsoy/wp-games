<?php get_header(); ?>

<main role="main" class="logo__images">
    <div class="container content">
    <h1 class="contentTitle">CHOOSE A PLATFORM</h1>
        <div class="row">
            <section class="logo col-lg-4">
                <div class="logo__inner">
                <a title="Playstation 5" href="<?php echo site_url("/playstation-5"); ?>">
                    <img class="logo__inner--img ps5" alt="PS5 logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/PS5_logo.png/512px-PS5_logo.png">
                </a>
                </div>
            </section>

            <section class="logo col-lg-4">
            <div class="logo__inner">
                <a title="Playstation 4" href="<?php echo site_url("/playstation-4"); ?>">
                    <img class="logo__inner--img ps4" alt="PS4 logo" src="https://upload.wikimedia.org/wikipedia/commons/7/7e/PS4_logo.png">
                </a>
                </div>
            </section>

            <section class="logo col-lg-4">
            <div class="logo__inner">
                <a title="Xbox One" href="<?php echo site_url("/xbox-one"); ?>">
                    <img class="logo__inner--img xone" alt="Xbox One logo wordmark" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Xbox_One_logo_wordmark.svg/512px-Xbox_One_logo_wordmark.svg.png">
                    </div>
                </section>

            <section class="logo col-lg-4">
            <div class="logo__inner">
                <a title="PC" href="<?php echo site_url("/pc"); ?>">
                    <img class="logo__inner--img pc" alt="PC logo" src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Windows_Logo_2012.png">
                </a>
                </div>
            </section>

            <section class="logo col-lg-4">
            <div class="logo__inner">
                <a title="Nintendo Switch" href="<?php echo site_url("/nintendo-switch"); ?>">
                    <img class="logo__inner--img switch" alt="Nintendo Switch" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Nintendo_Switch_logo%2C_horizontal.png/640px-Nintendo_Switch_logo%2C_horizontal.png">
                </a>
                </div>
            </section>

            <section class="logo col-lg-4">
            <div class="logo__inner">
                <a title="Xbox Series X/S" href="<?php echo site_url("/xbox-xs"); ?>">
                    <img alt="Xbox Series X/S" class="logo__inner--img xseries" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Xbox_Series_X_S_black.svg/512px-Xbox_Series_X_S_black.svg.png">
                </a>
                </div>
            </section>
        </div>
        </div>
</main>

<?php get_footer(); ?>
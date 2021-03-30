<?php get_header(); ?>

<main role="main" class="logo__images">
    <section class="logo">
        <a title="Playstation 5" href="<?php echo site_url("/playstation-5"); ?>">
            <img class="logo__img" alt="PS5 logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/PS5_logo.png/512px-PS5_logo.png">
        </a>
    </section>

    <section class="logo">
        <a title="Playstation 4" href="#">
            <img class="logo__img" alt="PS4 logo" src="https://upload.wikimedia.org/wikipedia/commons/7/7e/PS4_logo.png">
        </a>
    </section>

    <section class="logo">
        <a title="Xbox Series X/S" href="#">
            <img alt="Xbox Series X/S" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Xbox_Series_X_S_black.svg/512px-Xbox_Series_X_S_black.svg.png">
        </a>
    </section>

    <section class="logo">
        <a title="Xbox One" href="#">
            <img class="logo__img" alt="Xbox One logo wordmark" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Xbox_One_logo_wordmark.svg/512px-Xbox_One_logo_wordmark.svg.png">
        </a>
    </section>

    <section class="logo">
        <a title="Nintendo Switch" href="#">
            <img class="logo__img" alt="Nintendo Switch" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Nintendo_Switch_logo%2C_horizontal.png/640px-Nintendo_Switch_logo%2C_horizontal.png">
        </a>
    </section>

    <section class="logo">
        <a title="PC" href="#">
            <img class="logo__img" alt="PC logo" src="<?php echo get_theme_file_uri('images/microsoft-logo.png'); ?>">
        </a>
    </section>
</main>

<?php get_footer(); ?>
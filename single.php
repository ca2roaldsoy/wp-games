<?php

get_header(); 

$results = wp_remote_retrieve_body(wp_remote_get("https://api.rawg.io/api/games/" . get_field('id')));
$results = json_decode($results);

?>

<main role="main" class="gameDetails container-fluid" style="background-image: url('<?php the_field('background_image'); ?>')">
<?php  while (have_posts()) :
            the_post();

    $clipArr = json_decode(json_encode(get_field_object('clip')), true);
    $platformsArr = json_decode(json_encode(get_field_object('platforms')), true);
    $genresArr = json_decode(json_encode(get_field_object('genres')), true);
    $screenshotsArr = json_decode(json_encode(get_field_object('short_screenshots')), true);
    $platforms = $platformsArr['value'];
    $genres = $genresArr['value'];
    $screenshots = $screenshotsArr['value'];

    ?>

    <article role="article" class="gameDetails__content row">

            <section class="top_content col-lg-12">
                <section class='videoclip col-lg-6'>
                    <?php
                    $clip = $clipArr['value']['clip'];
                    ?>
                    <video controls class='videoplayer' width="720">
                        <source src='<?php echo $clip ?>' type='video/mp4'>
                        <!--Browser does not support <video> tag -->
                    </video>
                </section>

                <section class="col-lg-6 top_content__info">
                    <h1 class='gameTitle'><?php the_field('name'); ?></h1>
                    <?php
                        $rating = get_field('rating');
                        for($i=1; $i <= ceil($rating); $i++) {
                            if($i == ceil($rating)) {
                                echo str_repeat("<i class='bi bi-star-fill col top_content__info--stars'></i>", $i);
                            } 
                        }
                    ?>

                    <section class='gameInfoDetail__released'>
                        <h2>Released</h2>
                        <p><?php the_field('released') ?></p>
                   </section>
               
                </section>
            </section>

            <hr />
            <section class='gameInfoDetail__description col-lg-12'>
                <h2>DESCRIPTION</h2>
                <?php echo "<p>" . $results->description_raw . "</p>"; ?>
            </section>
            
            <hr />
            <section class='gameInfoDetail__screenshots col-lg-12'>
                <h2>SCREENSHOTS</h2>
                <div class="row">
                    <?php foreach($screenshots as $screenshot) {?>
                        <figure class="col-md-4 col-lg-3">
                            <?php
                                echo "<a href='" . $screenshot['image'] . "'>"; 
                                echo "<img role='img' class='img-fluid' src='" . $screenshot['image'] . "' target='_blank' alt='" . get_field('slug') . "'>";
                                echo "</a>";
                            ?>
                        </figure>
                    <?php } ?>
                </div>    
            </section>


            <hr />
            <section class="col-lg-12 gameInfoDetail__platforms">
                <h2>PLATFORMS</h2>
                <?php
                foreach($platforms as $platform) {
                    echo "<li>" . $platform['platform']['name'] . "</li>";
                } ?>
            </section>

            <hr />
            <section class="col-lg-12 gameInfoDetail__genres">
                <h2>GENRES</h2>
                <?php
                foreach($genres as $genre) {
                    echo "<li>" . $genre['name'] . "</li>";
                } ?>
            </section>
    </article>

<?php endwhile; ?>

</main>

<?php get_footer(); ?>
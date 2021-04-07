<?php

get_header(); 

$results = wp_remote_retrieve_body(wp_remote_get("https://api.rawg.io/api/games/" . get_field('id')));
$results = json_decode($results);

?>

<main role="main" class="gameDetails container-fluid" style="background-image: url('<?php the_field('background_image'); ?>')">
<?php  while (have_posts()) :
            the_post();

    $clipArr = json_decode(json_encode(get_field_object('clip')), true);
    $platformsArr = json_decode(json_encode(get_field_object('platform')), true);
    $genresArr = json_decode(json_encode(get_field_object('genres')), true);
    $screenshotsArr = json_decode(json_encode(get_field_object('short_screenshots')), true);
    $platforms = $platformsArr['value'];
    $genres = $genresArr['value'];
    $screenshots = $screenshotsArr['value'];

    ?>

    <?php
    echo "<h1 class='gameTitle'>" . the_field('name') . "</h1>";
    echo "<p class='description'>" . $results->description_raw . "</p>";
    ?>


    <section class='videoclip col-md-12'>
    <figure class='col-md-6'>
    <?php
    foreach($screenshots as $screenshot) {
        echo "<img role='img' class='image__gallery col-md-4 col-lg-3' src='" . $screenshot['image'] . "'>";
    } 
    ?>
    </figure>
    </section>

    <section class='videoclip col-md-12'>
        <?php
        $clip = $clipArr['value']['clip'];
        ?>
        <video controls class='videoplayer' width="720">
            <source src='<?php echo $clip ?>' type='video/mp4'>
            <!--Browser does not support <video> tag -->
        </video>
    </section>


    <section class='gameInfo col-lg-12'>
<?php
    echo "<ul>";
    echo "<li class='gameInfoDetail col-lg-6'> " . the_field('released') . "</li>";
    echo "</ul>";
    ?> 
    </div>
    </section>

    <div class='col-lg-12'>
    <?php
    foreach($platforms as $platform) {
        echo "<li class='gameInfoDetail col-md-4 col-lg-3'>" . $platform['platform']['name'] . "</li>";
    } ?>
    </div>

    <div class='col-lg-12'>
    <?php
    foreach($genres as $genre) {
        echo "<li class='gameInfoDetail col-md-4 col-lg-3'>" . $genre['name'] . "</li>";
    } ?>
    </div>


    <div class='col-lg-12'>
    <ul>Rating:</ul>
        <?php
        $rating = get_field('rating');

        for($i=1; $i <= ceil($rating); $i++) {

            if($i == ceil($rating)) {
                echo str_repeat("<span><i class='bi bi-star-fill'></i></span>", $i);
            } 
        }
        
        ?>
    </div>

<?php endwhile; ?>

</main>

<?php get_footer(); ?>
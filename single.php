<?php

/**
 * Template Name: Home Page
 */

get_header(); 

?>


<?php  while (have_posts()) :
            the_post();

$clipArr = json_decode(json_encode(get_field_object('clip')), true);
$platformsArr = json_decode(json_encode(get_field_object('platform')), true);
$platforms = $platformsArr['value'];

foreach($platforms as $platform) {
    echo $platform['platform']['name'];
}

$clip = $clipArr['value']['clip'];

echo $clip;
echo the_field('name');
echo the_field('rating');
echo the_field('background_image');



endwhile; ?>


<?php get_footer(); ?>
<?php

$obj_id = get_queried_object_id();
//$current_url = get_permalink( $obj_id );
$paged = get_query_var('page') ? get_query_var('page') : 1;

$gameQuery = new WP_Query( array(
    'posts_per_page' => -1,
    'post_type' => 'game',
    'page' => $paged

));

echo get_field('name');

?>
    <h1><?php the_title() ?></h1>
    <?php 

        while ($gameQuery->have_posts()) {
            $gameQuery->the_post();

            $platformsArr = json_decode(json_encode(get_field_object('platform')), true);
            $gamePlatform = $platformsArr['value'];

            foreach ($gamePlatform as $value) {
                $platformID = $value['platform']['id'];

                    // Playstation 5
                    if ($platformID == 187 && $obj_id == 5) {
                        echo "<li><a href=" . get_the_permalink() . ">" . get_field('name') . "</a></li>";
                    }

                    // Playstation 4
                    if ($platformID == 18 && $obj_id == 8) {
                        echo "<li><a href=" . get_the_permalink() . ">" . get_field('name') . "</a></li>";
                      
                    }
                }

            ?>
<?php }
    wp_reset_postdata();

?>
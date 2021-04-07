<?php

get_header();


function gameQuery($platform) {
    $paged = get_query_var('paged') ? get_query_var('paged') : 0;

    $gameQuery = new WP_Query(array(
        'posts_per_page' => 16,
        'post_type' => 'game',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'platform',
                'compare' => 'LIKE',
                'value' => $platform,
            )
        )
    ))

    ?>
    <h1 class='platformTitle'><?php the_title(); ?></h1>
    <article role="article" class="container-fluid">
        <div class="row">
            <?php
            while ($gameQuery->have_posts()) {
                $gameQuery->the_post(); ?>
                <section class="card-deck col-lg-3">
                    <a href='<?php the_permalink() ?>' class="card-game-link">
                        <div class="card">
                            <img class="card-img-top" src='<?php the_field("background_image") ?>' alt='<?php the_field('name') ?>'>
                            <div class="card-body">
                                <h5><?php the_field('name'); ?></h5>
                                <p> 
                                    <?php
                                    $rating = get_field('rating');
                                    for($i=1; $i <= ceil($rating); $i++) {
                                        if($i == ceil($rating)) {
                                            echo str_repeat("<span><i class='bi bi-star-fill'></i></span>", $i);
                                        }   
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </section>

            <?php } ?>
        </div>
    </article>
    <hr />

    <?php
    // Pagination
    $total_pages = $gameQuery->max_num_pages;
    if($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));


        echo "<section class='pagination'>";
        echo paginate_links( array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => ('« prev'),
            'next_text'    => ('next »'),
            'add_args'  => array()
        ));
        echo "</section>";
        
    }
    get_footer();
}

$url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
$pageID = url_to_postid( $url );

switch ($pageID) {
    case 5: return gameQuery('playstation 5'); 
    break;
    case 8: return gameQuery('playstation 4');
    break;
    case 10: return gameQuery('xbox series s');
    break;
    case 12: return gameQuery('xbox one');
    break;
    case 14: return gameQuery('nintendo switch');
    break;
    case 16: return gameQuery('pc');
    break;
    default: return null;
}

wp_reset_postdata();


?>
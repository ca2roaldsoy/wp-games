<?php

get_header();

function gameQuery($platform) {
    $paged = get_query_var('paged') ? get_query_var('paged') : 0;

    $gamesQuery = new WP_Query(array(
        'posts_per_page' => 16,
        'post_type' => 'game',
        'paged' => $paged,
        'meta_query' => array(
            array(
                'key' => 'platforms',
                'compare' => 'LIKE',
                'value' => $platform,
            )
        )
    ))

    ?>
    <article role="article" class="container-fluid gamePage">
    <h1 class='platformTitle'><?php the_title(); ?></h1>
        <div class="card-deck">
            <div class="card-row row">
                <?php
                while ($gamesQuery->have_posts()) {
                    $gamesQuery->the_post();?>
                    <section class="col-sm-12 col-md-6 col-lg-4 col-xl-3 outer-card">
                        <div class="card">
                        <a href='<?php the_permalink() ?>' class="card-game-link">
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
                            </a>
                        </div>
                        
                    </section>
                <?php } ?>
            </div>
        </div>
    </article>

    <?php
    // Pagination
    $total_pages = $gamesQuery->max_num_pages;
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
    case 37: return gameQuery('playstation 5'); 
    break;
    case 39: return gameQuery('playstation 4');
    break;
    case 41: return gameQuery('xbox series s');
    break;
    case 43: return gameQuery('xbox one');
    break;
    case 45: return gameQuery('nintendo switch');
    break;
    case 47: return gameQuery('pc');
    break;
    default: return null;
}

wp_reset_postdata();


?>
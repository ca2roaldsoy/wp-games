<?php

get_header();


function gameQuery($platform) {
    $paged = get_query_var('paged') ? get_query_var('paged') : 0;

    $gameQuery = new WP_Query(array(
    'posts_per_page' => 5,
    'post_type' => 'game',
    'paged' => $paged,
    'meta_query' => array(
        array(
            'key' => 'platform',
            'compare' => 'LIKE',
            'value' => $platform,
        )
    )
)); 

    while ($gameQuery->have_posts()) {
        $gameQuery->the_post(); ?>
        
        <li><a href="<?php the_permalink(); ?>"> <?php the_field('name') ?></a></li>;
    <?php } 

    // Pagination
    $total_pages = $gameQuery->max_num_pages;
    if($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        echo paginate_links( array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => ('« prev'),
            'next_text'    => ('next »'),
            'add_args'  => array()
        ));
    }
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

get_footer();

?>
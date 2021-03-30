<?php

function gameRegisterSearch() {
    register_rest_route('game/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'gameSearchResults'
    ));
}

function gameSearchResults($data) {
    $games = new WP_Query(array(
        'post_type' => 'game',
        's' => sanitize_text_field($data['value'])
    ));

    $gameResults = [];

    while($games->have_posts()) {
        $games->the_post();
        array_push($gameResults, array(
            'title' => get_the_title(),
            'link' => get_the_permalink()
        ));
    } 

    return $gameResults;
}

add_action( 'rest_api_init', 'gameRegisterSearch' );


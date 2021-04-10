<?php

require get_theme_file_path('/inc/game-search.php');

function gamerRevolutionFiles() {
    wp_enqueue_style("bootstrapIcons", "//cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css"); // Bootstrap Icons
    wp_enqueue_style("bootstrap", "//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"); // Bootstrap
    wp_enqueue_style('gamer-revolution-css', get_template_directory_uri() . '/sass/style.css');
    wp_enqueue_script( 'bootstrap_js', '//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', NULL, 1.0, true );
    wp_enqueue_script( 'gamer-revolution-js', get_theme_file_uri('/js/scripts.js'), NULL, 1.0, true);
    //wp_enqueue_script('gamer-revolution-script', get_theme_file_uri('js/scripts.js'), NULL, '3.0', true);
    
    /*if(strstr($_SERVER['SERVER_NAME'], 'gamerrevolution.local')) {
        wp_enqueue_script("gamer-revolution-js", 'http://localhost:3000/bundled.js', null, 1.0, true); // JavaScript
    
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/undefined'), NULL, '1.0', true);
        wp_enqueue_script('gamer-revolution-js', get_theme_file_uri('/bundled-assets/scripts.1946d90fd9edcddd3e42.js'), NULL, '1.0', true);
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/undefined'));
    }*/

    wp_localize_script('gamer-revolution-js', 'revolutionData', array(
        'root_url' => get_site_url()
    ));
}

add_action("wp_enqueue_scripts", "gamerRevolutionFiles");

function gamerRevolutionTitle() {
    add_theme_support("title-tag");
}

add_action("after_setup_theme", "gamerRevolutionTitle");

// Register Custom Field => Game, to wp-admin
function registerGamerRevolution() {
    register_post_type( "game", [
        "label" => "Games",
        "public" => true,
        "capability_type" => "post",
        "show_in_rest" => true,
        "has_archive" => true
    ] );
}

add_action( "init", "registerGamerRevolution" );

// update games weekly
if(!wp_next_scheduled("update_game_list")) {
    wp_schedule_event( time(), "weekly", "registerGamerRevolution" );
}

add_action( "wp_ajax_nopriv_get_games_from_api", "get_games_from_api" );
add_action( "wp_ajax_get_games_from_api", "get_games_from_api" );

function get_games_from_api() {
    $currentPage = (!empty ($_POST ["currentPage"])) ? $_POST["currentPage"] : 2;
    $games = [];

    $args = array(
        'headers' => array(
            "method" => "GET",
            "Content-Type" => 'application/json',
            "key" => '295030e777c1407fbef066e162f946c3'
        )
    );

    $results = wp_remote_retrieve_body(wp_remote_get("https://api.rawg.io/api/games?page=" . $currentPage), $args);
    $results = json_decode($results);
    $results = $results->results;

    if(!is_array($results) || empty($results)) {
        return false;
    }

    $games[] = $results;

    // loop through the games
    foreach($games[0] as $game) {
        $gameSlug = $game->slug;

         // add games to custom field -> game
        $currentGame = get_page_by_path( $gameSlug, "OBJECT", "game" );
        
        if ($currentGame === null) {
                $insertedGame = wp_insert_post([
                    "post_name" => $gameSlug,
                    "post_title" => $gameSlug,
                    "post_type" => "game",
                    "post_status" => "publish"
                ]);

            if (is_wp_error($insertedGame)) {
                continue;
            }

            $fieldKeys = [
                "field_606e0057121c3" => "name",
                "field_606e00d9121c5" => "id",
                "field_606e0117121c9" => "platforms",
                "field_606e010d121c8" => "rating",
                "field_606e00f2121c7" => "background_image",
                "field_606e0155121cb" => "clip",
                "field_606e00ce121c4" => "slug",
                "field_606e01bd7da19" => "updated",
                "field_606e00e2121c6" => "released",
                "field_606e014d121ca" => "genres",
                "field_606e016b121cc" => "short_screenshots"
            ];

            foreach ($fieldKeys as $key => $name) {
                update_field($key, $game->$name, $insertedGame);
            }

        } else {
            $currentGame_ID = $currentGame->ID;
            $currentGame_timestamp = get_field("updated", $currentGame_ID);

            if($game->updated >= $currentGame_timestamp) {
                // update games if updated 
              
                $fieldKeys = [
                    "field_606e0057121c3" => "name",
                    "field_606e00d9121c5" => "id",
                    "field_606e0117121c9" => "platforms",
                    "field_606e010d121c8" => "rating",
                    "field_606e00f2121c7" => "background_image",
                    "field_606e0155121cb" => "clip",
                    "field_606e00ce121c4" => "slug",
                    "field_606e01bd7da19" => "updated",
                    "field_606e00e2121c6" => "released",
                    "field_606e014d121ca" => "genres",
                    "field_606e016b121cc" => "short_screenshots"
                ];
        
                foreach ($fieldKeys as $key => $name) {
                    update_field($key, $game->$name, $currentGame_ID);
                }
            }
        }
    }

    $currentPage = $currentPage++;
    wp_remote_post(admin_url("admin-ajax.php?action=get_games_from_api"), [
        "blocking" => false,
        "sslverify" => false,
        "body" => [
            "currentPage" => $currentPage
        ]
    ]);

}
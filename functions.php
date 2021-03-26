<?php

function gamerRevolutionFiles () {
    //wp_enqueue_script("gamer_revolution_script", get_theme_file_uri("/js/script.js"), NULL, 1.0, true); // JavaScript
    wp_enqueue_style("bootstrap", "//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"); // Bootstrap
    wp_enqueue_style("gamer_revolution_styles", get_stylesheet_uri()); // CSS
    wp_localize_script("gamer_revolution_script", "gamerRevData", array(
        "siteID" => get_the_ID()
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
        "capability_type" => "post"
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

    // add games to admin custom filed -> game
    $games[] = $results;

    foreach($games[0] as $game) {
        $gameSlug = $game->slug;

        // update game in case of changes
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
                "field_6058f938a62ca" => "name",
                "field_6058f966a62cb" => "id",
                "field_6058f98aa62cc" => "platforms",
                "field_6058f9a3a62cd" => "rating",
                "field_6058f9b3a62ce" => "background_image",
                "field_6058f9dba62cf" => "clip",
                "field_6058fa0aa62d0" => "slug",
                "field_605902eb1741a" => "updated",
                "field_605d0bbad0c93" => "released",
                "field_605d0bf9d0c94" => "genres",
                "field_605d0c12d0c95" => "short_screenshots"
            ];

            foreach ($fieldKeys as $key => $name) {
                update_field($key, $game->$name, $insertedGame);
            }

        } else {
            $currentGame_ID = $currentGame->ID;
            $currentGame_timestamp = get_field("updated", $currentGame_ID);

            if($game->updated >= $currentGame_timestamp) {
                // update post 
                $fieldKeys = [
                    "field_6058f938a62ca" => "name",
                    "field_6058f966a62cb" => "id",
                    "field_6058f98aa62cc" => "platforms",
                    "field_6058f9a3a62cd" => "rating",
                    "field_6058f9b3a62ce" => "background_image",
                    "field_6058f9dba62cf" => "clip",
                    "field_6058fa0aa62d0" => "slug",
                    "field_605902eb1741a" => "updated",
                    "field_605d0bbad0c93" => "released",
                    "field_605d0bf9d0c94" => "genres",
                    "field_605d0c12d0c95" => "short_screenshots"
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
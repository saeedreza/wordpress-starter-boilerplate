<?php

// Disables Pesky Emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


/// Disables Embeds
function cb_disable_peskies_disable_embeds_rewrites( $rules ) {
    foreach ( $rules as $rule => $rewrite ) {
        if ( false !== strpos( $rewrite, 'embed=true' ) ) {
            unset( $rules[ $rule ] );
        }
    }
    return $rules;
}

function cb_disable_peskies_disable_embeds_tiny_mce_plugin( $plugins ) {
    return array_diff( $plugins, array( 'wpembed' ) );
}

function cb_disable_peskies_disable_embeds_remove_rewrite_rules() {
    add_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );
    flush_rewrite_rules();
}

function cb_disable_peskies_disable_embeds_flush_rewrite_rules() {
    remove_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );
    flush_rewrite_rules();
}


function cb_disable_peskies_disable_embeds()
{

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Turn off oEmbed auto discovery.
    add_filter( 'embed_oembed_discover', '__return_false' );

    // Don't filter oEmbed results.
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed discovery links.
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

    add_filter( 'tiny_mce_plugins', 'cb_disable_peskies_disable_embeds_tiny_mce_plugin' );

    // Remove all embeds rewrite rules.
    add_filter( 'rewrite_rules_array', 'cb_disable_peskies_disable_embeds_rewrites' );


}

add_action( 'init', 'cb_disable_peskies_disable_embeds', 99 );
register_activation_hook( __FILE__, 'cb_disable_peskies_disable_embeds_remove_rewrite_rules' );
register_deactivation_hook( __FILE__, 'cb_disable_peskies_disable_embeds_flush_rewrite_rules' );


/// Disable dashicons
add_action( 'wp_print_styles',     'my_deregister_styles', 100 );
function my_deregister_styles()    {
   wp_deregister_style( 'amethyst-dashicons-style' );
   wp_deregister_style( 'dashicons' );
}

wp_enqueue_script("jquery");

?>
<?php
/**
 * Collection of clean up tasks for the theme:
 * - Remove unnecessary feed links
 * - Remove RSD, WLW, and Adjacent Posts links
 * - Remove WP Emoji Scripts and Styles
 * - Remove WP Generator Meta Data
 * - Remove WP Shortlink
 * - Remove WP OEmbed Links and JS
 * - Remove REST API Links
 * - Disable default gallery styles
 */
add_action(
    'init',
    function (): void {
        // Remove unnecessary <link>'s.
        remove_action( 'wp_head', 'feed_links_extra', 3 ); // Extra feeds (e.g., category feeds).
        remove_action( 'wp_head', 'rsd_link' ); // Really Simple Discovery.
        remove_action( 'wp_head', 'wlwmanifest_link' ); // Windows Live Writer.
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); // Prev/next post links.
        remove_action( 'wp_head', 'wp_generator' ); // WordPress version.
        remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 ); // Shortlink.

        // Remove the main comment feed link using output buffering.
        add_action( 'wp_head', 'ob_start', 1, 0 );
        add_action(
            'wp_head',
            function (): void {
                $pattern = '/.' . preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' ) . '.[\r\n]+/';
                echo preg_replace( $pattern, '', ob_get_clean() );
            },
            3,
            0
        );

        // Remove WP Emoji scripts and styles.
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter( 'emoji_svg_url', '__return_false' ); // Prevent emoji CDN query.

        // Remove OEmbed discovery links and host JS.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );

        // Remove REST API links.
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'template_redirect', 'rest_output_link_header', 11 );

        // Remove default gallery styles.
        add_filter( 'use_default_gallery_style', '__return_false' );
    }
);
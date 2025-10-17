<?php
/**
 * Collection of the following clean up tasks in the HTML head element:
 * - Remove unnecessary extra feed links
 * - Remove RSD link
 * - Remove WLW link
 * - Remove Adjacent Posts link
 * - Remove WP Emoji Scripts and Styles
 * - Remove WP Generator Meta Data
 * - Remove WP Shortlink
 * - Remove WP OEmbed Links and JS
 * - Remove REST Output Link
 * - Disable WP hard-coded CSS
 * - Only display media in style tags if it makes sense
 * - Remove type='text/javascript' from script tags and replace single quotes with double quotes
 */

/*
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS and JS from WP emoji support
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag
 *
 */
add_action(
	'init',
	function (): void {
		// Originally from http://wpengineer.com/1438/wordpress-header/.
		remove_action( 'wp_head', 'feed_links_extra', 3 );
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
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'use_default_gallery_style', '__return_false' );
		add_filter( 'emoji_svg_url', '__return_false' );
	}
);


// Remove unnecessary WordPress block editor scripts from frontend
function remove_block_library_css_js() {
    if (!is_admin()) {
        // Remove block editor CSS
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('global-styles');
        
        // Remove block editor JS
        wp_dequeue_script('wp-block-library');
        wp_deregister_script('wp-block-library');
    }
}
add_action('wp_enqueue_scripts', 'remove_block_library_css_js', 100);

// Remove inline scripts that depend on wp.date, wp.preferences, etc.
function remove_wp_inline_scripts() {
    if (!is_admin()) {
        wp_deregister_script('wp-date');
        wp_deregister_script('wp-preferences');
        wp_deregister_script('wp-preferences-persistence');
    }
}
add_action('wp_enqueue_scripts', 'remove_wp_inline_scripts', 100);
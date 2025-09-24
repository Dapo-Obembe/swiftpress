<?php
/**
 * Theme scripts and styles declarations.
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.swiftpress.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme assets version.
define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );

/**
 * This function enqueues the swiftpress assets.
 */
function swiftpress_enqueue_assets() {
	$dist_path = get_template_directory() . '/dist';
	$dist_uri  = get_template_directory_uri() . '/dist';

	// Load compiled CSS.
	$css_file = $dist_path . '/style.css';
	if ( file_exists( $css_file ) ) {
		wp_enqueue_style(
			'swiftpress-style',
			$dist_uri . '/style.css',
			array(),
			filemtime( $css_file )
		);
	}

	// Load compiled JS (if available).
	$js_file = $dist_path . '/app.js';
	if ( file_exists( $js_file ) ) {
		wp_enqueue_script(
			'swiftpress-scripts',
			$dist_uri . '/app.js',
			array(),
			filemtime( $js_file ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'swiftpress_enqueue_assets' );
add_action( 'enqueue_block_editor_assets', 'swiftpress_enqueue_assets' );

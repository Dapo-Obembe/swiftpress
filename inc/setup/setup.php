<?php
/**
 * Theme setup files.
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'swiftpress_setup' ) ) :

	/**
	 * Adds theme supports.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function swiftpress_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

		// Remove core patterns.
		remove_theme_support( 'core-block-patterns' );

		$css_file = 'dist/style.css';
		add_editor_style( $css_file );
	}

endif;
add_action( 'after_setup_theme', 'swiftpress_setup' );

<?php
/**
 * Functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AlphaWebConsult
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function include_inc_files() {
	$files = array(
		'./inc/block-styles/', // Register Core Block Styles..
		'./inc/custom-functions/', // Custom functions that act independently of the theme templates.
		'./inc/shortcodes/', // Shortcodes used in the theme.
		'./inc/filters/', // All filtering actions.
		'./inc/setup/', // Theme setup files.
		'./inc/template-tags/', // Template tags.
	);

	foreach ( $files as $include ) {
		$include = trailingslashit( get_template_directory() ) . $include;

		// Allows inclusion of individual files or all .php files in a directory.
		if ( is_dir( $include ) ) {
			foreach ( glob( $include . '*.php' ) as $file ) {
				require_once $file;
			}
		} else {
			require_once $include;
		}
	}
}

include_inc_files();

/**
 * NOTE: Developer, do not add any custom functions in this file.
 * Find the relevant file to add your custom functions in the inc/ folder.
 * Or add them like inc/custom-functions/your-function-name.
 *
 * Happy coding!!!
 */

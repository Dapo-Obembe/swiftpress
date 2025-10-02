<?php
/**
 * Include block sections.
 *
 * Useful for blocks that are used as a full page.
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ACF BLOCKS global helper function to include files in the sections/
 * of your acf blocks in case you want to modularize a block or build fullpage block.
 */
function swiftpress_include_block_section( $block_name, $section_slug ) {
	$path = get_theme_file_path( "acf-blocks/{$block_name}/sections/{$section_slug}.php" );
	if ( file_exists( $path ) ) {
		include $path;
	}
}

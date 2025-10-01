<?php
/**
 * Add css class names to the header and footer template parts.
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom CSS classes to template part wrappers.
 *
 * Filters the rendered output of template parts to add custom class names
 * to the automatically generated wrapper elements. This allows for easier
 * styling and targeting of header and footer template parts.
 *
 * @since 1.0.0
 *
 * @param string $block_content The block content about to be rendered.
 * @param array  $block         The full block, including name and attributes.
 *
 * @return string Modified block content with additional CSS classes.
 */
function swiftpress_add_template_part_class( $block_content, $block ) {
	if ( isset( $block['attrs']['slug'] ) ) {
		if ( 'header' === $block['attrs']['slug'] ) {
			$block_content = str_replace( 'wp-block-template-part', 'wp-block-template-part site-header', $block_content );
		}
		if ( 'footer' === $block['attrs']['slug'] ) {
			$block_content = str_replace( 'wp-block-template-part', 'wp-block-template-part site-footer', $block_content );
		}
	}
	return $block_content;
}
add_filter( 'render_block_core/template-part', 'swiftpress_add_template_part_class', 10, 2 );

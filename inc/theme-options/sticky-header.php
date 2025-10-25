<?php
/**
 * Make the header sticky on scroll.
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

/**
 * Add body class if sticky header is enabled and styled via css.
 *
 * @param string $classes The class name added.
 */
function swiftpress_body_classes( $classes ) {
	if ( get_option( 'swiftpress_enable_sticky_header' ) ) {
		$classes[] = 'swiftpress-sticky-header';
	}
	return $classes;
}
add_filter( 'body_class', 'swiftpress_body_classes' );

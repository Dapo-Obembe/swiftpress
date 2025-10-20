<?php
/**
 * Add cache-control headers for WordPress uploads
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

/**
 * Add resource hints for better performance.
 */
function add_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href'        => 'https://secure.gravatar.com',
			'crossorigin' => 'anonymous',
		);
	}

	if ( 'dns-prefetch' === $relation_type ) {
		$hints[] = 'https://secure.gravatar.com';
	}

	return $hints;
}
add_filter( 'wp_resource_hints', 'add_resource_hints', 10, 2 );

/**
 * Enable output buffering for better caching
 */
function start_output_buffering() {
	if ( ! is_admin() ) {
		ob_start();
	}
}
add_action( 'init', 'start_output_buffering' );

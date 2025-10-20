<?php
/**
 * Filters
 *
 * @package SwiftPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Show '(No title)' if a post has no title.
 *
 * @since 1.0.0
 */
add_filter(
	'the_title',
	function ( $title ) {
		if ( ! is_admin() && empty( $title ) ) {
			$title = _x( '(No title)', 'Used if posts or pages has no title', 'swiftpress' );
		}

		return $title;
	}
);

/**
 * Replace the default [...] excerpt more with an elipsis.
 *
 * @since 1.0.0
*/
add_filter(
	'excerpt_more',
	function ( $more ) {
		return '&hellip;';
	}
);

// Remove remote/core patterns.
add_filter( 'should_load_remote_block_patterns', '__return_false' );


/**
 * Modify the comment form cookies message.
 * Works for the Block Editor.
 *
 * @return $block_content Return the modified cookies message.
 */
function modify_comment_form_block( $block_content, $block ) {
	// Check if this is the Post Comments Form block.
	if ( $block['blockName'] === 'core/post-comments-form' ) {
		// Modify the cookies message directly in the rendered block content.
		$block_content = str_replace(
			'<p class="comment-form-cookies-consent">',
			'<p class="comment-form-cookies-consent has-small-font-size" style="display:flex;align-items:center;">',
			$block_content
		);
		$block_content = str_replace(
			'Save my name, email, and website in this browser for the next time I comment.',
			'Save my name and email for future comments on this site.',
			$block_content
		);
	}

	return $block_content;
}
add_filter( 'render_block', 'modify_comment_form_block', 10, 2 );

/**
 * Remove the comment form website URL field.
 */
function remove_comment_form_website_field( $fields ) {
	if ( isset( $fields['url'] ) ) {
		unset( $fields['url'] );
	}
	return $fields;
}
add_filter( 'comment_form_default_fields', 'remove_comment_form_website_field' );

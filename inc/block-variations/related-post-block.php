<?php
/**
 * Related Posts Query Loop Block Variation
 *
 * @package SwiftPress
 * @subpackage Inc
 * @since 1.0.0
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

/**
 * Register the Related Posts block variation for Query Loop
 */
function swiftpress_register_related_posts_variation() {
	$js_file = get_template_directory() . '/assets/js/components/related-posts-variation.js';
	
	wp_enqueue_script(
		'swiftpress-related-posts-variation',
		get_template_directory_uri() . '/assets/js/components/related-posts-variation.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-element', 'wp-components', 'wp-block-editor', 'wp-compose', 'wp-hooks', 'wp-i18n' ),
		filemtime( $js_file ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'swiftpress_register_related_posts_variation' );

/**
 * Modify Query Loop query to show related posts.
 * 
 * @param array $query The original query arguments.
 * @param WP_Block $block The block instance.
 */
function swiftpress_modify_related_posts_query( $query, $block ) {
	
	// Check if we have query context
	if ( empty( $block->context['query'] ) ) {
		error_log( 'No query context found' );
		return $query;
	}

	$block_query = $block->context['query'];

	// Check for our custom flag.
	if ( empty( $block_query['relatedPosts'] ) ) {
		error_log( 'relatedPosts flag not set or false' );
		return $query;
	}

	// Get the current post ID from the template context
	$current_post_id = null;
	
	// On frontend single views
	if ( is_singular() ) {
		$current_post_id = get_queried_object_id();
		error_log( 'is_singular() - Post ID: ' . $current_post_id );
	}
	
	// In block editor, get from postId context
	if ( ! $current_post_id && ! empty( $block->context['postId'] ) ) {
		$current_post_id = $block->context['postId'];
	}
	
	// Fallback for editor preview - get a sample post.
	if ( ! $current_post_id && is_admin() ) {
		$post_type = $block_query['postType'] ?? 'post';
		error_log( 'Admin context - getting sample post of type: ' . $post_type );
		$sample_posts = get_posts( array(
			'post_type'      => $post_type,
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );
		if ( ! empty( $sample_posts ) ) {
			$current_post_id = $sample_posts[0]->ID;
			error_log( 'Sample post ID: ' . $current_post_id );
		}
	}

	// If still no post ID, return original query.
	if ( ! $current_post_id ) {
		error_log( 'ERROR: Could not determine current post ID' );
		return $query;
	}

	// Exclude current post.
	if ( ! isset( $query['post__not_in'] ) ) {
		$query['post__not_in'] = array();
	}
	$query['post__not_in'][] = $current_post_id;

	// Get relationship type from block context.
	$relationship_type = $block_query['relatedPostsBy'] ?? 'category_or_tag';
	error_log( 'Relationship type: ' . $relationship_type );
	
	// Get categories or tags based on relationship type
	if ( 'category' === $relationship_type ) {
		$categories = get_the_category( $current_post_id );
		$cat_ids    = ! empty( $categories ) ? wp_list_pluck( $categories, 'term_id' ) : array();
		error_log( 'Category IDs: ' . print_r( $cat_ids, true ) );
		
		if ( ! empty( $cat_ids ) ) {
			$query['category__in'] = $cat_ids;
		}
	} elseif ( 'tag' === $relationship_type ) {
		$tags = get_the_tags( $current_post_id );
		$tag_ids = $tags ? wp_list_pluck( $tags, 'term_id' ) : array();
		error_log( 'Tag IDs: ' . print_r( $tag_ids, true ) );
		if ( $tags ) {
			$query['tag__in'] = wp_list_pluck( $tags, 'term_id' );
		}
	} elseif ( 'category_or_tag' === $relationship_type ) {
		// Try categories first.
		$categories = get_the_category( $current_post_id );
		$cat_ids    = ! empty( $categories ) ? wp_list_pluck( $categories, 'term_id' ) : array();
		
		if ( ! empty( $cat_ids ) ) {
			$query['category__in'] = $cat_ids;
			error_log( 'Using categories: ' . print_r( $cat_ids, true ) );
		} else {
			// Fallback to tags.
			$tags = get_the_tags( $current_post_id );
			if ( $tags ) {
				$query['tag__in'] = wp_list_pluck( $tags, 'term_id' );
				error_log( 'Using tags: ' . print_r( wp_list_pluck( $tags, 'term_id' ), true ) );
			} else {
				error_log( 'No categories or tags found for this post' );
			}
		}
	}

	// Random order for related posts.
	$query['orderby'] = 'rand';

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'swiftpress_modify_related_posts_query', 10, 2 );
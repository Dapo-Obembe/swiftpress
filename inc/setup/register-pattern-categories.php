<?php
/**
 * Register Block Patterns Categories
 *
 * @package SwiftPress
 *
 * @since 1.0.0
 */

// Registers pattern categories.
if ( ! function_exists( 'swiftpress_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since swiftpress 1.0.0
	 *
	 * @return void
	 */
	function swiftpress_pattern_categories() {

		register_block_pattern_category(
			'swiftpress_hero',
			array(
				'label'       => __( 'Hero Patterns', 'swiftpress' ),
				'description' => __( 'A collection of patterns for hero sections.', 'swiftpress' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'swiftpress_pattern_categories' );

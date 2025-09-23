<?php
/**
 * Theme setup files.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Adds theme support for post formats.
if ( ! function_exists( 'awc_tw_plate_setup' ) ) :

	/*
	Add theme support for title tag
	*/
	add_theme_support( 'title-tag' );
	/**
	 * Adds theme support for post formats.
	 *
	 * @since AWC TW Plate 1.0
	 *
	 * @return void
	 */
	function awc_tw_plate_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Custom logo support.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 500,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

endif;
add_action( 'after_setup_theme', 'awc_tw_plate_setup' );

// Registers custom block styles.
if ( ! function_exists( 'swiftpress_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function swiftpress_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'swiftpress' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'swiftpress_block_styles' );

// Remove core patterns.
remove_theme_support( 'core-block-patterns' );

$css_file = 'dist/style.css';
add_editor_style( $css_file );


// Registers pattern categories.
if ( ! function_exists( 'swiftpress_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since swiftpress 1.0
	 *
	 * @return void
	 */
	function swiftpress_pattern_categories() {

		register_block_pattern_category(
			'awc_hero',
			array(
				'label'       => __( 'Hero Patterns', 'swiftpress' ),
				'description' => __( 'A collection of patterns for hero sections.', 'swiftpress' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'swiftpress_pattern_categories' );


add_filter( 'should_load_remote_block_patterns', '__return_false' );

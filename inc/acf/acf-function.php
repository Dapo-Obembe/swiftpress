<?php
/**
 * ACF functions and definitions
 *
 * Sets up the Advanced Custom Fields (ACF) plugin related functions.
 * This includes setting up options pages, defining custom fields and related features.
 *
 * NOTE: You can either SCF plugin or ACF. SCF is a forked version of ACF.
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Add the ACF options page.
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title'  => 'Theme SCF Settings', // Title displayed on the options page.
			'menu_title'  => 'Theme SCF Settings', // Title displayed in the WordPress admin menu.
			'parent_slug' => 'swiftpress-settings', // Put it inside the Theme settings menu.
			'capability'  => 'manage_options', // Capability required to access the page.
			'redirect'    => false,            // Keep the user on the same page after saving.
			'position'    => 60,
		)
	);
}

/**
 * Save ACF JSON directly into the acf-json/ folder.
 */
add_filter(
	'acf/settings/save_json',
	function ( $path ) {
		// Save ACF JSON files in the specified directory.
		$path = get_stylesheet_directory() . '/acf-json';
		return $path;
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		// Load ACF JSON files from the specified directory.
		$paths[] = get_stylesheet_directory() . '/acf-json';
		return $paths;
	}
);

/**
 * Conditionally hide the ACF admin menu in the production environment.
 *
 * This function ensures that on a live site, the ACF menu item ("Custom Fields")
 * is hidden from all users except for an administrator with a specific email address.
 * This prevents accidental edits by other admins while maintaining access for a super admin.
 *
 * @return bool True to show the ACF menu, false to hide it.
 *
 * TO DO: Change the email inside this unction if you are building a theme for a client and you're
 * going to be managing the site.
 */
function swiftpress_conditional_show_acf_admin() {
	if ( wp_get_environment_type() !== 'production' ) {
		return true;
	}

	// Define the one email address that is allowed to see the ACF menu.
	$allowed_admin_email = 'your-email@gmail.com'; // change to your email or the anyone who should have access to SCF/ACF menu.

	// Get the current logged-in user's data.
	$current_user = wp_get_current_user();

	// If there's no user or the user doesn't have an ID, hide the menu.
	if ( ! $current_user || ! $current_user->ID ) {
		return false;
	}

	// Check if the user is an administrator AND their email matches the allowed email.
	// 'manage_options' is a capability exclusive to administrators.
	if ( user_can( $current_user, 'manage_options' ) && $current_user->user_email === $allowed_admin_email ) {
		// If both conditions are met, show the ACF admin menu.
		return true;
	}

	// For all other users in production (including other admins), hide the menu.
	return false;
}
add_filter( 'acf/settings/show_admin', 'swiftpress_conditional_show_acf_admin' );

/**
 * Adding a new (custom) block category.
 *
 * @param array $block_categories Array of categories for block types.
 * @return array Modified block categories.
 */
function add_new_block_category( $block_categories ) {

	return array_merge(
		array(
			array(
				'slug'  => 'swiftpress-scf-blocks',
				'title' => esc_html__( 'SwiftPress SCF Blocks', 'swiftpress' ),
				'icon'  => null,
			),
		),
		$block_categories
	);
}
add_filter( 'block_categories_all', 'add_new_block_category' );

/**
 * SWIFTPRESS Blocks registration.
 */
function swiftpress_block_registration() {
	$blocks_dir    = get_stylesheet_directory() . '/acf-blocks/';
	$block_folders = glob( $blocks_dir . '*', GLOB_ONLYDIR );

	foreach ( $block_folders as $block_path ) {
		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}
add_action( 'init', 'swiftpress_block_registration' );

/**
 * Register the Blocks Style and Script
 *
 * NOTE: Register the script and Style here and use them in the
 * block.json of the each block. Check the example block.
 */
function register_script_for_block() {

	// Register Swiper so any block can declare them as a dependency.
	// NOTE: You can register any JS library this way or use npm to get rid of this format.
	wp_register_style( 'swiper-style', get_template_directory_uri() . '/assets/swiperjs/swiper-bundle.min.css', array(), '11.2.6' );
	wp_register_script( 'swiper-script', get_template_directory_uri() . '/assets/swiperjs/swiper-bundle.min.js', array(), '11.2.6', true );

	// Check if we are local environment.
	$is_local = wp_get_environment_type() === 'local';

	// Register Tailwind style.
	$path = get_template_directory() . 'dist/style.css';
	$uri  = get_template_directory_uri() . 'dist/style.css';

	if ( file_exists( $path ) ) {
		wp_register_style(
			'swiftpress-tailwind-style',
			$uri,
			array(),
			filemtime( $path ),
			'all'
		);

	}

	$blocks_dir = get_template_directory() . '/acf-blocks/';
	$blocks_uri = get_template_directory_uri() . '/acf-blocks/';

	// Find all subdirectories inside swiftpress-blocks/.
	$block_folders = glob( $blocks_dir . '*', GLOB_ONLYDIR );

	foreach ( $block_folders as $block_path ) {
		$block_name = basename( $block_path );

		$script_path = $blocks_dir . "{$block_name}/script.js";
		$script_uri  = $blocks_uri . "{$block_name}/script.js";

		if ( file_exists( $script_path ) ) {
			$script_handle = $block_name . '-script';

			wp_register_script(
				$script_handle,
				$script_uri,
				array(),
				filemtime( $script_path ),
				true
			);

			// Make block scripts modules.
			add_filter(
				'script_loader_tag',
				function ( $tag, $handle, $src ) use ( $script_handle ) {
					if ( $handle === $script_handle ) {
						return str_replace( '<script', '<script type="module"', $tag );
					}
					return $tag;
				},
				10,
				3
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'register_script_for_block' );
add_action( 'enqueue_block_editor_assets', 'register_script_for_block' );

add_action(
	'enqueue_block_editor_assets',
	function () {
		wp_enqueue_style(
			'swiftpress-tailwind-editor-style',
			get_template_directory_uri() . '/dist/style.css',
			array(),
			filemtime( get_template_directory() . '/dist/style.css' )
		);
	}
);

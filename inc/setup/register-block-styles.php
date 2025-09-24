<?php
/**
 * Main Block Styles Registration
 *
 * @package SwiftPress
 *
 * @version 1.0.0
 */

if ( ! function_exists( 'swiftpress_register_block_styles' ) ) {
	/**
	 * THis function registers the core block styles and reduce the need to manually
	 * register them.
	 */
	function swiftpress_register_block_styles() {
		$block_styles_dir = get_stylesheet_directory() . '/inc/block-styles/';
		$css_dir          = get_stylesheet_directory() . '/dist/blocks/';
		$css_uri          = get_stylesheet_directory_uri() . '/dist/blocks/';

		// Check if the block styles directory exists.
		if ( ! is_dir( $block_styles_dir ) ) {
			return;
		}

		// Get all PHP files in the block styles directory.
		$style_files = glob( $block_styles_dir . '*-styles.php' );

		foreach ( $style_files as $file ) {
			$filename = basename( $file, '.php' ); // e.g. "core-button-styles".

			// Extract block type from filename (core-button-styles → core/button).
			if ( preg_match( '/^(.+)-styles$/', $filename, $matches ) ) {
				$block_identifier = $matches[1]; // e.g. "core-button".

				// Convert filename to block name.
				if ( str_starts_with( $block_identifier, 'core-' ) ) {
					$block_name = str_replace( 'core-', 'core/', $block_identifier ); // core-button → core/button.
				} elseif ( str_starts_with( $block_identifier, 'acf-' ) ) {
					$block_name = str_replace( '-', '/', $block_identifier ); // acf-hero → acf/hero.
				} else {
					// For other block types, assume namespace/block format.
					$block_name = str_replace( '-', '/', $block_identifier, 1 ); // Replace first hyphen only.
				}

				// Corresponding CSS file.
				$css_file = $css_dir . $block_identifier . '.css';

				// Check if CSS file exists.
				if ( ! file_exists( $css_file ) ) {
					continue;
				}

				// Include the PHP file to get block style configurations.
				$block_styles = include $file;

				// Ensure we have an array of styles.
				if ( ! is_array( $block_styles ) ) {
					continue;
				}

				// Register CSS handle.
				$css_handle = 'swiftpress-' . $block_identifier . '-styles';

				// Register and enqueue the block styles.
				foreach ( $block_styles as $style_config ) {
					// Merge with defaults.
					$style_config = wp_parse_args(
						$style_config,
						array(
							'name'         => '',
							'label'        => '',
							'is_default'   => false,
							'style_handle' => $css_handle,
						)
					);

					// Skip if name is empty.
					if ( empty( $style_config['name'] ) ) {
						continue;
					}

					// Register the block style.
					register_block_style( $block_name, $style_config );
				}

				// Enqueue the CSS file.
				wp_enqueue_block_style(
					$block_name,
					array(
						'handle' => $css_handle,
						'src'    => $css_uri . $block_identifier . '.css',
						'ver'    => filemtime( $css_file ),
						'path'   => $css_file,
					)
				);
			}
		}
	}
	add_action( 'init', 'swiftpress_register_block_styles' );
}

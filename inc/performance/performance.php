<?php
/**
 * Theme Performance Enhancements
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dequeue unneeded styles.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_dequeue_style( 'classic-theme-styles' );
	},
	20
);

/**
 * Inline critical global-styles CSS.
 */
add_filter(
	'style_loader_tag',
	function ( $html, $handle ) {
		if ( 'global-styles' === $handle ) {
			// Get the global styles CSS.
			$css = wp_get_global_stylesheet();

			if ( $css ) {
				// Return inline style instead of link tag.
				return '<style id="global-styles-inline-css">' . $css . '</style>';
			}
		}
		return $html;
	},
	10,
	2
);

/**
 * Optimize block asset loading
 */
add_action(
	'after_setup_theme',
	function () {
		// Load block styles individually (per block used on page).
		add_filter( 'should_load_separate_core_block_assets', '__return_true' );

		// Only disable editor scripts if you're sure you don't need them.
		if ( ! is_admin() && ! is_user_logged_in() ) {
			add_filter( 'wp_should_load_block_editor_scripts_and_styles', '__return_false' );
		}
	}
);



/**
 * Smart Lazy Load — skip above-the-fold images.
 */
add_filter(
	'the_content',
	function ( $content ) {
		// Skip if AMP or admin.
		if ( is_admin() || defined( 'AMP_QUERY_VAR' ) ) {
			return $content;
		}

		// Load DOM.
		$dom = new DOMDocument();
		libxml_use_internal_errors( true );
		$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $content );
		libxml_clear_errors();

		$imgs  = $dom->getElementsByTagName( 'img' );
		$count = 0;

		foreach ( $imgs as $img ) {
			$count++;
			$loading = $img->getAttribute( 'loading' );

			// Don't touch existing lazy attrs.
			if ( $loading ) {
				continue;
			}

			// Skip first 2–3 images (usually above-the-fold).
			if ( $count > 3 ) {
				$img->setAttribute( 'loading', 'lazy' );
				$img->setAttribute( 'decoding', 'async' );
			} else {
				$img->setAttribute( 'fetchpriority', 'high' );
			}
		}

		return preg_replace(
			'/^.*?<body>(.*)<\/body>.*$/is',
			'$1',
			$dom->saveHTML()
		);
	}
);


/**
 * Preload first image (likely hero image) on singular posts, but not pages.
 */
add_action(
	'wp_head',
	function () {
		// Only run on singular views (posts, CPTs) but exclude pages.
		// Pages are mostimes structured differently and may not have hero images.
		if ( ! is_singular() || is_page() ) {
			return;
		}

		global $post;
		// Make sure $post object is valid.
		if ( ! $post ) {
			return;
		}

		if ( has_post_thumbnail( $post->ID ) ) {
			$hero = get_the_post_thumbnail_url( $post->ID, 'full' );

			// Only output if we actually got a URL.
			if ( $hero ) {
				echo '<link rel="preload" href="' . esc_url( $hero ) . '" as="image" fetchpriority="high">';
			}
		}
	}
);



/**
 * Defer only specific safe scripts.
 */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle, $src ) {
		if ( is_admin() ) {
			return $tag;
		}

		// Only defer these specific scripts.
		$defer_handles = array(
			'comment-reply',
		);

		// Only defer if in the safe list.
		if ( in_array( $handle, $defer_handles, true ) ) {
			if ( strpos( $tag, ' defer' ) === false ) {
				$tag = str_replace( '<script ', '<script defer ', $tag );
			}
		}

		return $tag;
	},
	10,
	3
);

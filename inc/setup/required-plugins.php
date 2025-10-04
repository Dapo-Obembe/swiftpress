<?php
/**
 * Show the required plugins for this theme to work perfectly.
 *
 * @package SwiftPress
 */

/**
 * Recommend SCF when ACF block method is chosen
 */
function swiftpress_recommend_scf_notice() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	$method = get_option( 'swiftpress_block_method', 'scf' );

	// If using ACF but SCF is missing.
	if ( 'scf' === $method && ! is_plugin_active( 'secure-custom-fields/secure-custom-fields.php' ) ) {

		$install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=secure-custom-fields' ),
			'install-plugin_secure-custom-fields'
		);

		$activate_url = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=secure-custom-fields/secure-custom-fields.php' ),
			'activate-plugin_secure-custom-fields/secure-custom-fields.php'
		);

		// If plugin folder exists but is inactive → show Activate.
		if ( file_exists( WP_PLUGIN_DIR . '/secure-custom-fields/secure-custom-fields.php' ) ) {
			$button = '<a href="' . esc_url( $activate_url ) . '" class="button button-primary">Activate SCF</a>';
		} else {
			$button = '<a href="' . esc_url( $install_url ) . '" class="button button-primary">Install SCF</a>';
		}

		echo '<div class="notice notice-warning is-dismissible">
			<p><strong>SwiftPress:</strong> You selected <em>SCF/ACF Blocks</em> as the method of creating or using custom blocks with SwiftPress, but <em>Secure Custom Fields</em> is not active. When installed and activated, Theme SCF Settings will be created inside the SwiftPress menu.</p>
			<p>' . $button . '</p>
		</div>';
	}
}
add_action( 'admin_notices', 'swiftpress_recommend_scf_notice' );



/**
 * Recommend Swift FSE Blocks when chosen
 */
function swiftpress_recommend_fse_notice() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return;
	}

	$method = get_option( 'swiftpress_block_method', 'scf' );

	if ( 'fse' === $method && ! is_plugin_active( 'swift-fse-blocks/swift-fse-blocks.php' ) ) {

		$install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=swift-fse-blocks' ),
			'install-plugin_swift-fse-blocks'
		);

		$activate_url = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=swift-fse-blocks/swift-fse-blocks.php' ),
			'activate-plugin_swift-fse-blocks/swift-fse-blocks.php'
		);

		if ( file_exists( WP_PLUGIN_DIR . '/swift-fse-blocks/swift-fse-blocks.php' ) ) {
			$button = '<a href="' . esc_url( $activate_url ) . '" class="button button-primary">Activate Swift FSE Blocks</a>';
		} else {
			$button = '<a href="' . esc_url( $install_url ) . '" class="button button-primary">Install Swift FSE Blocks</a>';
		}

		echo '<div class="notice notice-info is-dismissible">
			<p><strong>SwiftPress:</strong> You selected <em>FSE Blocks</em>, but the plugin is not active. Still working on this.</p>
			<p>' . $button . '</p>
		</div>';
	}
}
add_action( 'admin_notices', 'swiftpress_recommend_fse_notice' );

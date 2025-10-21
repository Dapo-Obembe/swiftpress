<?php
/**
 * SwiftPress Settings Page
 *
 * @package SwiftPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add custom admin menu page for theme
 */
function swiftpress_add_admin_menu_page() {
	add_menu_page(
		__( 'SwiftPress Settings', 'swiftpress' ),
		__( 'SwiftPress', 'swiftpress' ),
		'manage_options',
		'swiftpress-settings',
		'swiftpress_render_settings_page',
		'dashicons-admin-generic',
		3
	);
}
add_action( 'admin_menu', 'swiftpress_add_admin_menu_page' );

/**
 * Render the settings page with tabs
 */
function swiftpress_render_settings_page() {
	$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'SwiftPress Settings', 'swiftpress' ); ?></h1>
		<p><?php esc_html_e( 'Welcome to your SwiftPress\'s settings page!', 'swiftpress' ); ?></p> 
		<p><?php esc_html_e( 'Configure your SwiftPress theme options below.', 'swiftpress' ); ?></p>

		<h2 class="nav-tab-wrapper">
			<a href="?page=swiftpress-settings&tab=general" class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'General', 'swiftpress' ); ?>
			</a>
			<a href="?page=swiftpress-settings&tab=blocks" class="nav-tab <?php echo 'blocks' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Blocks', 'swiftpress' ); ?>
			</a>
			<a href="?page=swiftpress-settings&tab=recommended_plugins" class="nav-tab <?php echo 'recommended_plugins' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Recommended Plugins', 'swiftpress' ); ?>
			</a>
		</h2>

		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			if ( 'general' === $active_tab ) {
				settings_fields( 'swiftpress_options_general' );
				do_settings_sections( 'swiftpress-settings-general' );
			} elseif ( 'blocks' === $active_tab ) {
				settings_fields( 'swiftpress_options_blocks' );
				do_settings_sections( 'swiftpress-settings-blocks' );
			} elseif ( 'recommended_plugins' === $active_tab ) {
				settings_fields( 'swiftpress_options_recommended_plugins' );
				do_settings_sections( 'swiftpress-settings-recommended-plugins' );
			}
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Register SwiftPress settings
 */
function swiftpress_register_settings() {
	// === General tab settings ===
	register_setting( 'swiftpress_options_general', 'swiftpress_enable_sticky_header' );

	add_settings_section(
		'swiftpress_general_section',
		__( 'General Settings', 'swiftpress' ),
		'__return_false',
		'swiftpress-settings-general'
	);

	add_settings_field(
		'swiftpress_enable_sticky_header',
		__( 'Enable Sticky Header', 'swiftpress' ),
		'swiftpress_sticky_header_callback',
		'swiftpress-settings-general',
		'swiftpress_general_section'
	);

	// === Blocks tab ===
	register_setting( 'swiftpress_options_blocks', 'swiftpress_block_method' );

	add_settings_section(
		'swiftpress_blocks_section',
		__( 'Block Usage Settings', 'swiftpress' ),
		'__return_false',
		'swiftpress-settings-blocks'
	);

	add_settings_field(
		'swiftpress_block_method',
		__( 'Block Usage/Creation Method', 'swiftpress' ),
		'swiftpress_block_method_callback',
		'swiftpress-settings-blocks',
		'swiftpress_blocks_section'
	);

	// === Recommended plugins tab ===
	register_setting( 'swiftpress_options_recommended_plugins', 'swiftpress_recommended_plugins' );

	add_settings_section(
		'swiftpress_recommended_plugins_section',
		__( 'Recommended Plugins Settings', 'swiftpress' ),
		'__return_false',
		'swiftpress-settings-recommended-plugins'
	);

	add_settings_field(
		'swiftpress_recommended_plugins',
		__( 'Recommended Plugins', 'swiftpress' ),
		'swiftpress_recommended_plugins_callback',
		'swiftpress-settings-recommended-plugins',
		'swiftpress_recommended_plugins_section'
	);
}
add_action( 'admin_init', 'swiftpress_register_settings' );


/**
 * Field Callbacks
 */
function swiftpress_sticky_header_callback() {
	$value = get_option( 'swiftpress_enable_sticky_header', 0 );
	?>
	<label>
		<input type="checkbox" name="swiftpress_enable_sticky_header" value="1" <?php checked( 1, $value ); ?> />
		<?php esc_html_e( 'Enable sticky header across the site.', 'swiftpress' ); ?>
	</label>
	<?php
}

/**
 * Handles how blocks will be used or created.
 */
function swiftpress_block_method_callback() {
	$value = get_option( 'swiftpress_block_method', 'scf' );
	?>
	<select name="swiftpress_block_method">
		<option value="scf" <?php selected( $value, 'scf' ); ?>><?php esc_html_e( 'SCF Blocks (recommended for developer)', 'swiftpress' ); ?></option>
		<option value="fse" <?php selected( $value, 'fse' ); ?>><?php esc_html_e( 'Swift FSE Blocks Plugin', 'swiftpress' ); ?></option>
	</select>
	<p class="description"><?php esc_html_e( 'Choose how blocks are used/created in SwiftPress.', 'swiftpress' ); ?></p>
	<?php
}

/**
 * Display recommended plugins list.
 */
function swiftpress_recommended_plugins_callback() {
    $plugins = array(
        array(
            'name'        => 'Swift Block Animation',
            'slug'        => 'swift-block-animation',
            'description' => 'Add entrance animations to your blocks with stagger effect.',
            'source'      => 'custom',
            'download_url' => 'https://www.dapoobembe.com/downloads/swift-block-animation.zip',
        ),
        array(
            'name'        => 'Yoast SEO',
            'slug'        => 'wordpress-seo',
            'description' => 'Improve your WordPress SEO rankings and visibility.',
            'source'      => 'wordpress',
        ),
    );
    ?>
    <p class="description"><?php esc_html_e( 'Below are plugins we recommend for use with SwiftPress theme. Install only those you need.', 'swiftpress' ); ?></p>
    <table class="wp-list-table widefat fixed striped" style="max-width: 900px; margin-top: 15px; padding:1rem;">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Plugin Name', 'swiftpress' ); ?></th>
                <th><?php esc_html_e( 'Description', 'swiftpress' ); ?></th>
                <th><?php esc_html_e( 'Status', 'swiftpress' ); ?></th>
                <th><?php esc_html_e( 'Action', 'swiftpress' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $plugins as $plugin ) : ?>
                <?php
                $plugin_file  = $plugin['slug'] . '/' . $plugin['slug'] . '.php';
                $is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin_file );
                $is_active    = is_plugin_active( $plugin_file );
                $source       = isset( $plugin['source'] ) ? $plugin['source'] : 'wordpress';
                ?>
                <tr>
                    <td><strong><?php echo esc_html( $plugin['name'] ); ?></strong></td>
                    <td><?php echo esc_html( $plugin['description'] ); ?></td>
                    <td>
                        <?php if ( $is_active ) : ?>
                            <span style="color: #46b450;">● <?php esc_html_e( 'Active', 'swiftpress' ); ?></span>
                        <?php elseif ( $is_installed ) : ?>
                            <span style="color: #ffb900;">● <?php esc_html_e( 'Installed', 'swiftpress' ); ?></span>
                        <?php else : ?>
                            <span style="color: #dc3232;">● <?php esc_html_e( 'Not Installed', 'swiftpress' ); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ( $is_active ) : ?>
                            <span style="color: #888;"><?php esc_html_e( 'Active', 'swiftpress' ); ?></span>
                        <?php elseif ( $is_installed ) : ?>
                            <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=' . $plugin_file ), 'activate-plugin_' . $plugin_file ) ); ?>" class="button button-primary button-small">
                                <?php esc_html_e( 'Activate', 'swiftpress' ); ?>
                            </a>
                        <?php else : ?>
                            <?php if ( $source === 'custom' && isset( $plugin['download_url'] ) ) : ?>
                                <a href="<?php echo esc_url( $plugin['download_url'] ); ?>" class="button button-secondary button-small" download>
                                    <?php esc_html_e( 'Download', 'swiftpress' ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=' . urlencode( $plugin['slug'] ) . '&tab=search&type=term' ) ); ?>" class="button button-secondary button-small">
                                    <?php esc_html_e( 'Install', 'swiftpress' ); ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p style="margin-top: 15px;">
        <a href="<?php echo esc_url( admin_url( 'plugin-install.php' ) ); ?>" class="button button-secondary">
            <?php esc_html_e( 'Browse Plugins', 'swiftpress' ); ?>
        </a>
    </p>
    <?php
}
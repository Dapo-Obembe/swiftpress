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
		<p><?php esc_html_e( 'Welcome to your SwiftPress’s settings page!', 'swiftpress' ); ?></p> 
		<p><?php esc_html_e( 'Configure your SwiftPress theme options below.', 'swiftpress' ); ?></p>

		<h2 class="nav-tab-wrapper">
			<a href="?page=swiftpress-settings&tab=general" class="nav-tab <?php echo 'general' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'General', 'swiftpress' ); ?>
			</a>
			<a href="?page=swiftpress-settings&tab=blocks" class="nav-tab <?php echo 'blocks' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Blocks', 'swiftpress' ); ?>
			</a>
			<a href="?page=swiftpress-settings&tab=layout" class="nav-tab <?php echo 'layout' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<?php esc_html_e( 'Layout', 'swiftpress' ); ?>
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
			} elseif ( 'layout' === $active_tab ) {
				settings_fields( 'swiftpress_options_layout' );
				do_settings_sections( 'swiftpress-settings-layout' );
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

	// === Layout tab ===
	register_setting( 'swiftpress_options_layout', 'swiftpress_container_width' );

	add_settings_section(
		'swiftpress_layout_section',
		__( 'Layout Settings', 'swiftpress' ),
		'__return_false',
		'swiftpress-settings-layout'
	);

	add_settings_field(
		'swiftpress_container_width',
		__( 'Container Width (px)', 'swiftpress' ),
		'swiftpress_container_width_callback',
		'swiftpress-settings-layout',
		'swiftpress_layout_section'
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
 * Set the container width.
 */
function swiftpress_container_width_callback() {
	$value = get_option( 'swiftpress_container_width', '1200' );
	?>
	<input type="number" name="swiftpress_container_width" value="<?php echo esc_attr( $value ); ?>" class="small-text" />
	<p class="description"><?php esc_html_e( 'Set the maximum container width in pixels.', 'swiftpress' ); ?></p>
	<?php
}

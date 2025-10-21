<?php
/**
 * Handles theme updates from a Author's server
 *
 * @package SwiftPress
 *
 * @author Dapo Obembe <https://www.dapoobembe.com>
 *
 * NOTE: DO not remove if you did not clone this theme.
 */

if ( is_admin() ) {
	require_once get_template_directory() . '/class-custom-theme-updater.php';
	new CustomThemeUpdater(
		'https://www.dapoobembe.com/wp-admin/admin-ajax.php?action=check_theme_update',
		get_option( 'my_theme_license_key', '' )
	);
}

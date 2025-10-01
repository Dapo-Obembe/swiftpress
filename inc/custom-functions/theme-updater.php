<?php
/**
 * Handles theme updates from a custom server
 */

if (is_admin()) {
    require_once get_template_directory() . '/class-custom-theme-updater.php';
    new CustomThemeUpdater(
        'https://www.dapoobembe.com/wp-admin/admin-ajax.php?action=check_theme_update',
        get_option('my_theme_license_key', '') // Optional
    );
}


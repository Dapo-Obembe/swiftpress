<?php
/**
 * Show the required plugins for this theme to work perfectly.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

function awc_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'Yoast SEO', // The name of the plugin
            'slug'     => 'wordpress-seo', // The slug of the plugin (from the WordPress.org repository)
            'required' => false,          // If false, the plugin is only recommended
        ),
        array(
            'name'     => 'AWC Block Kit', // The name of the plugin
            'slug'     => 'alpha-web-block-kit', // The slug of the plugin (from the WordPress.org repository)
            'required' => true,          // If false, the plugin is only recommended
            'source'   => 'https://www.alphawebconsult.com/plugins/awc-block-kit.zip', // or GitHub release ZIP
            'external_url' => 'https://github.com/Dapo-Obembe/awc-block-kit', // optional
        ),
    );

    $config = array(
        'id'           => 'swiftpress',                 // Unique ID for hashing notices
        'default_path' => '',                         // Default absolute path to bundled plugins
        'menu'         => 'tgmpa-install-plugins',    // Menu slug
        'has_notices'  => true,                       // Show admin notices
        'dismissable'  => false,                       // Dismissable messages
        'is_automatic' => true,                      // Automatically activate plugins after install
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'awc_register_required_plugins');

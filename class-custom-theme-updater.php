<?php
/**
 * Handles theme updates from a custom server
 */
class CustomThemeUpdater {
    private $server_url;
    private $theme_slug;
    private $version;
    private $license_key;

    public function __construct($server_url, $license_key = '') {
        $this->server_url = $server_url;
        $this->license_key = $license_key;

        // Current theme info
        $theme = wp_get_theme();
        $this->theme_slug = $theme->get_stylesheet();
        $this->version = $theme->get('Version');

        add_filter('pre_set_site_transient_update_themes', array($this, 'check_for_update'));
    }

    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $request = wp_remote_post($this->server_url, array(
            'timeout' => 20,
            'body' => array(
                'slug' => $this->theme_slug,
                'version' => $this->version,
                'site_url' => home_url(),
                'license_key' => $this->license_key
            )
        ));

        if (!is_wp_error($request) && wp_remote_retrieve_response_code($request) == 200) {
            $response = json_decode(wp_remote_retrieve_body($request));

            if (!empty($response->success) && empty($response->data->up_to_date)) {
                $transient->response[$this->theme_slug] = array(
                    'theme' => $this->theme_slug,
                    'new_version' => $response->data->new_version,
                    'url' => $response->data->url,
                    'package' => $response->data->package
                );
            }
        }

        return $transient;
    }
}
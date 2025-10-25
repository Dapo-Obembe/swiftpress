<?php
/**
 * Add Preloader options
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if( !defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_body_open', 'swiftpress_output_preloader' );
function swiftpress_output_preloader() {
    $preloader = get_option( 'swiftpress_preloader_option', 'none' );
    $bg_color  = get_option( 'swiftpress_preloader_bg_color', '#ffffff' );
    $direction = get_option( 'swiftpress_page_transition_direction', 'fade' );

    if ( 'none' === $preloader ) {
        return;
    }

    $style = sprintf( 'style="background-color: %s;"', esc_attr( $bg_color ) );

    echo '<div id="swiftpress-preloader" class="swiftpress-preloader" data-direction="' . esc_attr( $direction ) . '" ' . $style . '>';

    if ( 'plain' === $preloader ) {
        echo '<div class="swiftpress-preloader-spinner"></div>';
    } elseif ( 'logo' === $preloader ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = $custom_logo_id ? wp_get_attachment_image( $custom_logo_id, 'full' ) : get_bloginfo( 'name' );
        echo '<div class="swiftpress-preloader-logo">' . $logo . '</div>';
    }

    echo '</div>';
}



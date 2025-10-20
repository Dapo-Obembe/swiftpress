<?php
/**
 * Load the recaptcha for CF7 only on the contact page.
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */

if(!defined('ABSPATH')) exit;

/**
 * Remove reCAPTCHA scripts and styles except on pages with forms.
 */
function remove_recaptcha_except_contact_page() {
        if ( is_admin() ) {
            return;
        }

        global $post;
        
        $has_form = false;

        // Only check for shortcodes/blocks on singular pages/posts.
        if ( is_singular() && $post ) {
            $content = $post->post_content;

            // Check for any form shortcodes or blocks.
            if (
                has_shortcode( $content, 'contact-form-7' ) ||
                has_shortcode( $content, 'wpforms' ) ||
                has_shortcode( $content, 'gravityform' ) ||
                has_block( 'contact-form-7/contact-form-selector', $post ) ||
                has_block( 'wpforms/form-selector', $post ) ||
                has_block( 'gravityforms/form', $post )
            ) {
                $has_form = true;
            }
        }

        // Remove if no form found.
        if ( ! $has_form ) {
            // Generic handle.
            wp_dequeue_script( 'google-recaptcha' );
            wp_deregister_script( 'google-recaptcha' );

            // Contact Form 7.
            wp_dequeue_script( 'wpcf7-recaptcha' );
            wp_deregister_script( 'wpcf7-recaptcha' );
            wp_dequeue_style( 'wpcf7-recaptcha' );
            wp_deregister_style( 'wpcf7-recaptcha' );

            // Gravity Forms.
            wp_dequeue_script( 'gform_recaptcha' );
            wp_deregister_script( 'gform_recaptcha' );

            // WPForms.
            wp_dequeue_script( 'wpforms-recaptcha' );
            wp_deregister_script( 'wpforms-recaptcha' );
            wp_dequeue_script( 'grecaptcha-v3' );
            wp_deregister_script( 'grecaptcha-v3' );
        }

}
add_action( 'wp_enqueue_scripts', 'remove_recaptcha_except_contact_page', 100 );

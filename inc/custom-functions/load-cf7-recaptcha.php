<?php
/**
 * Load the recaptcha for CF7 only on the contact page.
 */
if(!defined('ABSPATH')) exit;

add_action('wp_print_scripts', 'remove_recaptcha_except_contact_page', 100);

function remove_recaptcha_except_contact_page() {
    
    if (!is_page('contact')) { 
        // Remove the reCAPTCHA scripts
        wp_dequeue_script('google-recaptcha');
        wp_deregister_script('google-recaptcha');
        
        // Remove Contact Form 7 reCAPTCHA scripts
        wp_dequeue_script('wpcf7-recaptcha');
        wp_deregister_script('wpcf7-recaptcha');
        
        // Remove related CSS if needed
        wp_dequeue_style('wpcf7-recaptcha');
        wp_deregister_style('wpcf7-recaptcha');
    }
}

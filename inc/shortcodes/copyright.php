<?php
/**
 * Shortcode to show the copyright notice.
 *
 * @package AlphaWebConsult
 * @since 1.0.0
 */
if(!defined('ABSPATH')) exit;

function copyright_year_shortcode( $atts ) {
    // Extract attributes and set default values
    $atts = shortcode_atts( array(
        'starting_year' => date('Y'), // Default to current year if not provided
        'separator'     => ' - ',     // Default separator
    ), $atts, 'copyright_year' );

    $starting_year = $atts['starting_year'];
    $current_year  = date('Y');
    $separator     = $atts['separator'];

    // If the current year is the same as the starting year, return only the starting year
    if ( $current_year == $starting_year ) {
        return $starting_year;
    }

    // Otherwise, return the range of years
    return $starting_year . $separator . $current_year;
}
add_shortcode( 'copyright_year', 'copyright_year_shortcode' );
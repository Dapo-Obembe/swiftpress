<?php
/**
 * Preload the best available font (.woff2, .woff, .ttf, .eot) found in theme.json.
 *
 * This is designed for Block Themes that define fonts locally and
 * respects the priority of modern font formats.
 * 
 * @package SwiftPress
 * 
 * @author Dapo Obembe <https://www.dapoobembe.com>
 */
add_action(
    'wp_head',
    function () {
        if ( is_admin() ) {
            return;
        }

        // Get the merged settings from theme.json (core, theme, user).
        $settings = wp_get_global_settings();

        // Check if fontFamilies are defined.
        if ( empty( $settings['typography']['fontFamilies'] ) ) {
            return;
        }

        $font_url_to_preload  = '';
        $font_type_to_preload = '';

        // Define font formats in order of preference (best first)
        $font_preference = [
            'woff2' => 'font/woff2',
            'woff'  => 'font/woff',
            'ttf'   => 'font/ttf',
            'eot'   => 'application/vnd.ms-fontobject',
        ];

        // Loop through all registered font families.
        foreach ( $settings['typography']['fontFamilies'] as $family ) {
            if ( empty( $family['fontFace'] ) ) {
                continue;
            }

            // Loop through all the font faces (e.g., bold, normal, italic).
            foreach ( $family['fontFace'] as $face ) {
                if ( empty( $face['src'] ) ) {
                    continue;
                }

                // Standardize 'src' to always be an array for easier looping.
                $src_files = (array) $face['src'];
                
                $found_font_path = '';
                $found_font_type = '';

                // Check for the best format first by looping through our preference array.
                foreach ( $font_preference as $ext => $mime_type ) {
                    // Now loop through the src files listed for this font face.
                    foreach ( $src_files as $src_path ) {
                        $font_file_relative = str_replace( 'file:./', '', $src_path );
                        
                        // Check if the file extension matches our current preferred format.
                        if ( pathinfo( $font_file_relative, PATHINFO_EXTENSION ) === $ext ) {
                            // Found it!
                            $found_font_path = $font_file_relative;
                            $found_font_type = $mime_type;
                            
                            // We found the best possible format for this face, stop checking src files.
                            break;
                        }
                    }
                    
                    if ( ! empty( $found_font_path ) ) {
                         // We found a match for this preference, stop checking other formats.
                        break;
                    }
                }

                // If we found a suitable font for *this* face, store it.
                if ( ! empty( $found_font_path ) ) {
                    $font_url_to_preload  = get_template_directory_uri() . '/' . $found_font_path;
                    $font_type_to_preload = $found_font_type;
                    
                    // We found the first font face with a valid file, stop looking at other faces.
                    break;
                }
            }

            if ( ! empty( $font_url_to_preload ) ) {
                // We found our font, so we can stop looping through families.
                break;
            }
        }

        // If we found a font and its type, print the preload tag
        if ( ! empty( $font_url_to_preload ) && ! empty( $font_type_to_preload ) ) {
            echo '<link rel="preload" href="' . esc_url( $font_url_to_preload ) . '" as="font" type="' . esc_attr( $font_type_to_preload ) . '" crossorigin>';
        }
    }
);
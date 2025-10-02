<?php
/**
 * Block: Home Page Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   int|string $post_id The post ID this block is saved to.
 * @package SwiftPress
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'homepage-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class = 'homepage';
if ( ! empty( $block['className'] ) ) {
	$block_class .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$block_class .= ' align' . $block['align'];
}

?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class ); ?>">

	<?php echo esc_html( swiftpress_include_block_section( 'homepage', 'hero' ) ); ?>
	<!-- Include other sections like so.-->
  
</div>


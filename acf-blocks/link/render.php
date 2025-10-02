<?php
/**
 * Block: LinkWrapper Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   int|string $post_id The post ID this block is saved to.
 * @package SwiftPress
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'linkwrapper-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class = 'linkwrapper';
if ( ! empty( $block['className'] ) ) {
	$block_class .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$block_class .= ' align' . $block['align'];
}

// SCF DATA.
$wrapper_link        = get_field( 'wrapper_link' );
$onsite_wrapper_link = get_field( 'onsite_wrapper_link' );

// Selected or active field.
$selected_link = $onsite_wrapper_link ?? $wrapper_link;
?>

<?php if ( ! is_admin() && $selected_link ) : ?>
	<a id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class ); ?>" href="<?php echo esc_url( $selected_link ); ?>">
	<?php endif; ?>
		<div class="is-linkwrapper-block">
			<InnerBlocks />
		</div>
	<?php if ( ! is_admin() && $selected_link ) : ?>
	</a>
<?php endif; ?>

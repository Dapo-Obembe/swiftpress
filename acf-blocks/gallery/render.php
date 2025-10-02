<?php
/**
 * Block: Gallery Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   int|string $post_id The post ID this block is saved to.
 * @package SwiftPress
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'swiftpress-gallery-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class = 'swiftpress-gallery-block';

if ( ! empty( $block['className'] ) ) {
	$block_class .= ' ' . $block['className'];
}

if ( ! empty( $block['align'] ) ) {
	$block_class .= ' align' . $block['align'];
}


if ( have_rows( 'swiftpress_gallery' ) ) :
	?>
	<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class ); ?>">
		<div class="gallery-swiper swiper">
			<div class="swiper-wrapper">
				<?php
				while ( have_rows( 'swiftpress_gallery' ) ) :
					the_row();
					$single_image = get_sub_field( 'single_image' );

					?>
					<?php
					if ( ! empty( $single_image ) ) :
						?>
						<?php
						echo wp_get_attachment_image(
							$single_image['ID'],
							'full',
							false,
							array(
								'class'   => 'swiper-slide',
								'alt'     => $single_image['alt'],
								'loading' => 'lazy',
							)
						);
						?>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</section>
	<?php
endif;
?>
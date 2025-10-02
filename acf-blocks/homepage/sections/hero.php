<?php
/**
 * HOME PAGE - Hero Section
 *
 * @package SwiftPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ACF DATA.
$hero_title       = get_field( 'hero_title' ) ?? 'Enter main title';
$hero_description = get_field( 'hero_description' ) ?? 'Enter hero description';
$hero_image       = get_field( 'hero_image' );

?>
<section class="homepage__hero flex items-center">
	<div class="container text-center">
		<?php if ( ! empty( $hero_title ) ) : ?>
			<h1 class="title page-title mb-[24px]">
				<?php echo wp_kses_post( $hero_title ); ?>
			</h1>
		<?php endif; ?>

		<?php if ( ! empty( $hero_description ) ) : ?>
			<p data-animate="fadeInUp" data-delay="50ms" class="description section-description"><?php echo wp_kses_post( $hero_description ); ?></p>
		<?php endif; ?>

		<?php
		if ( ! empty( $hero_image ) ) :

			echo wp_get_attachment_image(
				$hero_image['ID'],
				'full',
				false,
				array(
					'class'        => 'h-[280px] lg:h-[620px] object-cover object-top mt-[76px] rounded-[12.56px] lg:rounded-[48px]',
					'loading'      => 'eager',
					'alt'          => $hero_image['alt'],
					'data-animate' => 'fadeInUp',
					'data-delay'   => '250ms',
				)
			);

		endif;
		?>
		
	</div>
</section>

<?php
/**
 * Displays numeric pagination on archive pages.
 *
 * @package AlphaWebConsult
 */
if(!defined('ABSPATH')) exit;

/**
 * Displays numeric pagination on archive pages.
 *
 * @param array    $args  Array of params to customize output.
 * @param WP_Query $query The Query object; only passed if a custom WP_Query is used.
 */
function print_numeric_pagination( $args = array(), $query = null ) {
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Make the pagination work on custom query loops.
	$total_pages = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;

	// Set defaults.
	$defaults = array(
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'mid_size'  => 4,
		'total'     => $total_pages,
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	if ( null === paginate_links( $args ) ) {
		return;
	}
	?>

	<nav class="pagination-container mt-8 flex flex-nowrap gap-4 justify-center items-center has-[a]:text-2xl has-[a]:font-bold  [&_.current]:text-primary" aria-label="<?php esc_attr_e( 'numeric pagination', 'alphawebplate-tw' ); ?>">
		<?php echo paginate_links( $args ); // phpcs:ignore ?>
	</nav>

	<?php
}

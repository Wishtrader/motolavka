<?php
/**
 * Pagination for catalog pages.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$links = paginate_links(
	apply_filters(
		'woocommerce_pagination_args',
		array(
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_next' => false,
			'type'      => 'array',
			'end_size'  => 1,
			'mid_size'  => 1,
		)
	)
);

if ( empty( $links ) ) {
	return;
}
?>
<nav class="woocommerce-pagination flex flex-wrap justify-center gap-2 mt-10 md:mt-12" aria-label="<?php esc_attr_e( 'Навигация по страницам', 'motorcycle-shop' ); ?>">
	<?php foreach ( $links as $link ) : ?>
		<?php
		$is_current = false !== strpos( $link, 'current' );
		$is_dots    = false !== strpos( $link, 'dots' );
		$classes    = 'inline-flex min-w-[44px] h-[44px] items-center justify-center rounded-[2px] text-sm font-semibold transition-colors ';

		if ( $is_dots ) {
			$classes .= 'text-[#B8C0CC] bg-transparent pointer-events-none';
		} elseif ( $is_current ) {
			$classes .= 'bg-[#FF6B00] text-white';
		} else {
			$classes .= 'bg-[#5C3A1E] text-white hover:bg-[#FF6B00]';
		}

		$link = preg_replace( '/class="[^"]*"/', 'class="' . esc_attr( $classes ) . '"', $link );
		if ( $is_current ) {
			$link = str_replace( '<span', '<span aria-current="page"', $link );
		}
		echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	<?php endforeach; ?>
</nav>

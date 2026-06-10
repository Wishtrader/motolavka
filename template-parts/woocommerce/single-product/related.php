<?php
/**
 * Related products section.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

global $product;

$related_ids = wc_get_related_products( $product->get_id(), 3 );

if ( empty( $related_ids ) ) {
	// Fallback: other products from the same category.
	$primary = motorcycle_shop_get_primary_product_category( $product->get_id() );
	if ( $primary ) {
		$query = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 3,
				'post__not_in'   => array( $product->get_id() ),
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => array( $primary->term_id ),
					),
				),
			)
		);
		$related_ids = wp_list_pluck( $query->posts, 'ID' );
	}
}

if ( empty( $related_ids ) ) {
	return;
}
?>

<section class="w-full fluid-section-py fluid-px border-t border-[#2A3038]">
	<div class="max-w-[1200px] mx-auto">
		<h2 class="text-white fluid-h2-sm font-bold mb-8 md:mb-10">Рекомендуем также</h2>

		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
			<?php
			foreach ( $related_ids as $related_id ) :
				$related_product = wc_get_product( $related_id );
				if ( ! $related_product || ! $related_product->is_visible() ) {
					continue;
				}
				$GLOBALS['product'] = $related_product;
				wc_get_template_part( 'content', 'product' );
			endforeach;
			$GLOBALS['product'] = $product;
			?>
		</div>
	</div>
</section>

<?php
/**
 * Product category / shop archive content (loaded via woocommerce.php).
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_product_category() ) {
	get_template_part( 'template-parts/woocommerce/archive', 'hero' );
}
?>

<section id="product-archive" class="w-full py-10 md:py-12 px-[10px] md:px-0">
	<div class="max-w-[1200px] mx-auto">
		<?php if ( woocommerce_product_loop() ) : ?>

			<?php do_action( 'woocommerce_before_shop_loop' ); ?>

			<?php
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else : ?>
			<?php do_action( 'woocommerce_no_products_found' ); ?>
		<?php endif; ?>
	</div>
</section>

<?php
if ( is_product_category() ) {
	get_template_part( 'template-parts/woocommerce/archive', 'seo' );
	get_template_part( 'template-parts/home/form', 'form' );
}

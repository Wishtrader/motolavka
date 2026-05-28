<?php
/**
 * Single product content.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

do_action( 'woocommerce_before_single_product' );
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<?php get_template_part( 'template-parts/woocommerce/single-product/breadcrumbs' ); ?>

	<?php if ( function_exists( 'wc_print_notices' ) ) : ?>
		<div class="max-w-[1200px] mx-auto px-[10px] md:px-0 mb-4 woocommerce-notices-wrapper">
			<?php wc_print_notices(); ?>
		</div>
	<?php endif; ?>

	<section class="w-full px-[10px] md:px-0 pb-10 md:pb-14">
		<div class="max-w-[1200px] mx-auto">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
				<?php get_template_part( 'template-parts/woocommerce/single-product/gallery' ); ?>
				<?php get_template_part( 'template-parts/woocommerce/single-product/summary' ); ?>
			</div>
		</div>
	</section>

	<section class="w-full px-[10px] md:px-0 pb-12 md:pb-16">
		<div class="max-w-[1200px] mx-auto">
			<div class="flex flex-col md:flex-row gap-8 md:gap-[16px]">
				<?php get_template_part( 'template-parts/woocommerce/single-product/details' ); ?>
				<?php get_template_part( 'template-parts/woocommerce/single-product/sidebar-cards' ); ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/woocommerce/single-product/related' ); ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

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
		<div class="max-w-[1200px] mx-auto fluid-px mb-4 woocommerce-notices-wrapper">
			<?php wc_print_notices(); ?>
		</div>
	<?php endif; ?>

	<?php
	// Product background image (absolute, blurred, max-height 300px)
	$image_id = $product->get_image_id();
	$has_bg_image = false;
	$bg_image_url = '';

	if ( $image_id ) {
		$bg_image_url = wp_get_attachment_image_url( $image_id, 'large' );
		$has_bg_image = true;
	}

	if ( ! $has_bg_image ) {
		// Try featured image from post
		$image_id = get_post_thumbnail_id( get_the_ID() );
		if ( $image_id ) {
			$bg_image_url = wp_get_attachment_image_url( $image_id, 'large' );
			$has_bg_image = true;
		}
	}

	if ( $has_bg_image ) :
	?>
	<div class="product-hero-bg absolute top-0 left-0 w-full h-[250px] overflow-hidden pointer-events-none z-0">
		<div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo esc_url( $bg_image_url ); ?>'); filter: blur(8px); transform: scale(1.1);"></div>
		<div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/80"></div>
	</div>
	<?php endif; ?>

	<section class="w-full fluid-px pb-10 md:pb-14 relative z-10">
		<div class="max-w-[1200px] mx-auto">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-6 lg:pt-[72px]">
				<?php get_template_part( 'template-parts/woocommerce/single-product/gallery' ); ?>
				<?php get_template_part( 'template-parts/woocommerce/single-product/summary' ); ?>
			</div>
		</div>
	</section>

	<section class="w-full fluid-px pb-12 md:pb-16 lg:mt-14 relative z-10">
		<div class="max-w-[1200px] mx-auto">
			<div class="flex flex-col lg:flex-row gap-4">
				<?php get_template_part( 'template-parts/woocommerce/single-product/details' ); ?>
				<?php get_template_part( 'template-parts/woocommerce/single-product/sidebar-cards' ); ?>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/woocommerce/single-product/related' ); ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>


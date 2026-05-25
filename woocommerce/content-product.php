<?php
/**
 * Product card in catalog loop.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$specs        = motorcycle_shop_get_product_specs( $product );
$price_parts  = motorcycle_shop_get_product_price_parts( $product );
$image_id     = $product->get_image_id();
$image_url    = $image_id
	? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' )
	: get_template_directory_uri() . '/img/moto.png';
$product_link = get_permalink( $product->get_id() );
?>

<article <?php wc_product_class( 'bg-[#2A3038] overflow-hidden rounded-[2px] flex flex-col', $product ); ?>>
	<a href="<?php echo esc_url( $product_link ); ?>" class="block overflow-hidden">
		<img
			src="<?php echo esc_url( $image_url ); ?>"
			alt="<?php echo esc_attr( $product->get_name() ); ?>"
			class="w-full aspect-[4/3] object-cover transition-transform duration-300 hover:scale-105"
			loading="lazy"
		/>
	</a>

	<div class="flex flex-col flex-1 p-5">
		<h2 class="text-white text-xl md:text-2xl font-bold leading-snug">
			<a href="<?php echo esc_url( $product_link ); ?>" class="hover:text-[#FB8A3C] transition-colors">
				<?php echo esc_html( $product->get_name() ); ?>
			</a>
		</h2>

		<?php if ( ! empty( $specs ) ) : ?>
			<div class="flex flex-wrap gap-[10px] mt-[10px] mb-[30px]">
				<?php foreach ( $specs as $spec ) : ?>
					<span class="px-2 py-0.5 text-[#B8C0CC] text-[13px] bg-[#1F242B] rounded-[2px]">
						<?php echo esc_html( $spec ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="mb-[30px]"></div>
		<?php endif; ?>

		<div class="flex flex-col md:flex-row w-full items-stretch md:items-center justify-between gap-4 md:gap-[30px] mt-auto">
			<p class="text-white text-xl md:text-2xl font-semibold whitespace-nowrap">
				<?php echo esc_html( $price_parts['amount'] ); ?>
				<?php if ( $price_parts['currency'] ) : ?>
					<span class="text-base text-[#B8C0CC] font-normal"><?php echo esc_html( $price_parts['currency'] ); ?></span>
				<?php endif; ?>
			</p>

			<a
				href="<?php echo esc_url( $product_link ); ?>"
				class="flex w-full md:flex-1 md:max-w-[210px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-4 text-base font-semibold hover:bg-[#E55A00] transition-colors"
			>
				Подробнее
			</a>
		</div>
	</div>
</article>

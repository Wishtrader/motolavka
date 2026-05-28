<?php
/**
 * Product summary — title, price, highlights, add to cart.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

global $product;

$price_parts = motorcycle_shop_get_product_price_parts( $product );
$highlights  = motorcycle_shop_get_product_highlight_specs( $product );
$intro_text = $product->get_description();
$credit_url = home_url( '/#credit' );
?>

<div class="flex flex-col text-white gap-[16px]">
	<h1 class="text-[28px] md:text-[36px] lg:text-[40px] font-bold leading-tight mb-4">
		<?php echo esc_html( $product->get_name() ); ?>
	</h1>

	<p class="text-[#FF6B00] text-[32px] font-semibold leading-none mb-2">
		<?php echo esc_html( $price_parts['amount'] ); ?>
		<?php if ( $price_parts['currency'] ) : ?>
			<span class="text-base text-white"><?php echo esc_html( $price_parts['currency'] ); ?></span>
		<?php endif; ?>
	</p>

	<a href="<?php echo esc_url( $credit_url ); ?>" class="text-[#FF6B00] text-sm md:text-lg hover:text-[#FB8A3C] transition-colors mb-[10px] inline-block">
		Возможна покупка в кредит
	</a>

	<?php if ( $intro_text ) : ?>
		<div class="text-white font-semibold text-[16px] leading-[1.5] mb-8 [&_p]:mb-3 [&_p:last-child]:mb-0">
			<?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
		</div>
	<?php endif; ?>

	<p class="text-white font-semibold text-lg leading-[1.5] mb-4">Ключевые характеристики:</p>

	<?php if ( ! empty( $highlights ) ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
			<?php foreach ( $highlights as $item ) : ?>
				<div class="flex items-center gap-3">
					<div class="min-w-0 flex justify-between w-full md:min-w-[212px]">
						<p class="text-[#B8C0CC] font-semibold text-sm leading-snug mr-2"><?php echo esc_html( $item['label'] ); ?></p>
						<p class="text-white text-sm text-end flex justify-end font-semibold leading-snug"><?php echo esc_html( $item['value'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="mt-auto">
		<?php woocommerce_template_single_add_to_cart(); ?>
	</div>
</div>

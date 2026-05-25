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
// Под ценой — полное описание (ранее было в блоке «Описание»).
$intro_text = $product->get_description();
$credit_url = home_url( '/#credit' );
?>

<div class="flex flex-col text-white">
	<h1 class="text-[28px] md:text-[36px] lg:text-[40px] font-bold leading-tight mb-4">
		<?php echo esc_html( $product->get_name() ); ?>
	</h1>

	<p class="text-[#FF6B00] text-[32px] md:text-[40px] font-bold leading-none mb-2">
		<?php echo esc_html( $price_parts['amount'] ); ?>
		<?php if ( $price_parts['currency'] ) : ?>
			<span class="text-[22px] md:text-[28px]"><?php echo esc_html( $price_parts['currency'] ); ?></span>
		<?php endif; ?>
	</p>

	<a href="<?php echo esc_url( $credit_url ); ?>" class="text-[#FF6B00] text-sm md:text-base underline underline-offset-4 hover:text-[#FB8A3C] transition-colors mb-6 inline-block">
		Возможна покупка в кредит
	</a>

	<?php if ( $intro_text ) : ?>
		<div class="text-[#B8C0CC] text-[15px] md:text-base leading-relaxed mb-8 [&_p]:mb-3 [&_p:last-child]:mb-0">
			<?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $highlights ) ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
			<?php foreach ( $highlights as $item ) : ?>
				<div class="flex items-center gap-3 bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] px-4 py-3 min-h-[72px]">
					<img src="<?php echo esc_url( $item['icon'] ); ?>" alt="" class="w-8 h-8 shrink-0 opacity-90" width="32" height="32" />
					<div class="min-w-0">
						<p class="text-[#B8C0CC] text-xs leading-snug"><?php echo esc_html( $item['label'] ); ?></p>
						<p class="text-white text-sm font-semibold leading-snug"><?php echo esc_html( $item['value'] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="mt-auto">
		<?php woocommerce_template_single_add_to_cart(); ?>
	</div>
</div>

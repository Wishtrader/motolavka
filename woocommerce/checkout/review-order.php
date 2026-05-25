<?php
/**
 * Checkout order review sidebar.
 *
 * @package motorcycle-shop
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

$cart_count = WC()->cart->get_cart_contents_count();
?>

<div class="shop_table woocommerce-checkout-review-order-table">

	<h2 class="text-white text-xl md:text-2xl font-bold mb-4">Итого</h2>
	<div class="h-[2px] w-full bg-[#FF6B00] mb-6"></div>

	<div class="flex items-center justify-between gap-4 text-[#B8C0CC] text-sm md:text-base mb-4">
		<span><?php printf( esc_html__( 'Товары ( %d )', 'motorcycle-shop' ), (int) $cart_count ); ?></span>
		<span class="text-white font-medium"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

	<div class="flex flex-col divide-y divide-[#434C58]/60 mb-6">
		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				continue;
			}

			$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			$line_price   = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
			?>
			<div class="py-4 first:pt-0 last:pb-0 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<div class="flex items-start justify-between gap-4">
					<div class="min-w-0">
						<p class="text-white text-base font-semibold leading-snug"><?php echo wp_kses_post( $product_name ); ?></p>
						<p class="text-[#B8C0CC] text-sm mt-1"><?php echo esc_html( $cart_item['quantity'] ); ?> шт</p>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="text-white text-base font-semibold shrink-0 product-total">
						<?php echo wp_kses_post( $line_price ); ?>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>

	<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="flex items-center justify-between gap-4 text-sm mb-2 text-[#B8C0CC] coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
			<span class="text-white"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
		<div class="mb-4 text-sm text-[#B8C0CC] shipping-totals">
			<?php wc_cart_totals_shipping_html(); ?>
		</div>
		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<div class="flex items-baseline justify-between gap-4 mb-8 pt-4 border-t border-[#434C58]/60">
		<span class="text-white text-base md:text-lg font-semibold">Сумма заказа:</span>
		<span class="text-white text-xl md:text-2xl font-bold order-total-value"><?php wc_cart_totals_order_total_html(); ?></span>
	</div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>

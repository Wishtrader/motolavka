<?php
/**
 * Cart totals sidebar.
 *
 * @package motorcycle-shop
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$cart_count = WC()->cart->get_cart_contents_count();
?>

<div class="cart_totals bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-6 <?php echo WC()->customer->has_calculated_shipping() ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2 class="text-white text-xl md:text-2xl font-bold mb-4">Итого</h2>
	<div class="h-[2px] w-full bg-[#FF6B00] mb-6"></div>

	<div class="flex items-center justify-between gap-4 text-[#B8C0CC] text-sm md:text-base mb-4">
		<span><?php printf( esc_html__( 'Товары ( %d )', 'motorcycle-shop' ), (int) $cart_count ); ?></span>
		<span class="text-white font-medium"><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="flex items-center justify-between gap-4 text-sm mb-2 text-[#B8C0CC] coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
			<span class="text-white"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
		<div class="mb-4 text-sm text-[#B8C0CC] shipping-totals">
			<?php wc_cart_totals_shipping_html(); ?>
		</div>
		<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

	<div class="flex items-baseline justify-between gap-4 mb-8 pt-4 border-t border-[#D95F0E]">
		<span class="text-[#B8C0CC] text-base md:text-[24px] font-normal">Сумма заказа:</span>
		<span class="text-white text-xl md:text-2xl font-normal order-total-value"><?php wc_cart_totals_order_total_html(); ?></span>
	</div>

	<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	<div class="wc-proceed-to-checkout flex flex-col gap-3 mb-6">
		<a
			href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
			class="flex w-full h-[52px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold hover:bg-[#E55A00] transition-colors checkout-button"
		>
			Оформить заказ
		</a>
		<?php
		motorcycle_shop_lead_modal_trigger(
			array(
				'source' => 'cart',
				'class'  => 'flex w-full min-h-[52px] items-center justify-center rounded-[2px] bg-transparent text-white text-base font-semibold border border-[#434C58] hover:bg-[#1F242B] transition-colors',
			)
		);
		?>
	</div>

	<p class="text-[#B8C0CC] text-xs md:text-[12px] text-center leading-relaxed">
		После отправки заказа мы свяжемся с вами для подтверждения наличия и деталей получения. Оплата производится после подтверждения.
	</p>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>

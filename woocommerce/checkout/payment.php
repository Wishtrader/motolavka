<?php
/**
 * Checkout payment / submit section.
 *
 * @package motorcycle-shop
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}

?>

<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart && WC()->cart->needs_payment() && ! empty( $available_gateways ) ) : ?>
		<ul class="wc_payment_methods payment_methods methods">
			<?php
			foreach ( $available_gateways as $gateway ) {
				wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
			}
			?>
		</ul>
	<?php else : ?>
		<input type="hidden" name="payment_method" value="motorcycle_confirm" />
	<?php endif; ?>

	<div class="form-row place-order flex flex-col gap-4 mt-2">
		<noscript>
			<button type="submit" class="hidden" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
		</noscript>

		<?php wc_get_template( 'checkout/terms.php' ); ?>

		<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

		<?php
		echo apply_filters(
			'woocommerce_order_button_html',
			'<button type="submit" class="button alt flex w-full min-h-[52px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold hover:bg-[#E55A00] transition-colors" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>'
		); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		<?php
		motorcycle_shop_lead_modal_trigger(
			array(
				'text'   => 'Получить консультацию',
				'source' => 'checkout',
				'class'  => 'flex w-full min-h-[52px] items-center justify-center rounded-[2px] bg-transparent text-white text-base font-semibold border border-[#434C58] hover:bg-[#1F242B] transition-colors',
			)
		);
		?>

		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

		<p class="text-white/90 text-xs md:text-[12px] leading-relaxed text-center">
			После отправки заказа мы свяжемся с вами для подтверждения наличия и деталей получения. Оплата производится после подтверждения.
		</p>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
	</div>
</div>

<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}

<?php
/**
 * Checkout billing / contact fields.
 *
 * @package motorcycle-shop
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

$billing_fields = $checkout->get_checkout_fields( 'billing' );
$order_fields   = $checkout->get_checkout_fields( 'order' );
$comment_field  = isset( $order_fields['order_comments'] ) ? $order_fields['order_comments'] : null;

if ( $comment_field ) {
	unset( $order_fields['order_comments'] );
}
?>

<section class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8">
	<div class="flex items-center gap-3 mb-6">
		<span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FF6B00] text-white text-sm font-bold shrink-0" aria-hidden="true">1</span>
		<h2 class="text-white text-lg md:text-xl font-bold">Контактные данные</h2>
	</div>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields">
		<div class="woocommerce-billing-fields__field-wrapper grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
			<?php
			$skip_fields = array( 'billing_city', 'billing_address_1' );

			foreach ( $billing_fields as $key => $field ) {
				if ( in_array( $key, $skip_fields, true ) ) {
					continue;
				}

				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}

			if ( $comment_field ) {
				woocommerce_form_field( 'order_comments', $comment_field, $checkout->get_value( 'order_comments' ) );
			}
			?>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>

	<input type="hidden" name="billing_country" value="BY" />
	<input type="hidden" name="billing_postcode" value="000000" />
	<input type="hidden" name="billing_last_name" id="billing_last_name" value="" />
</section>

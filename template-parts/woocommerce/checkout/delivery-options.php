<?php
/**
 * Delivery method cards.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

$chosen_methods = WC()->session ? WC()->session->get( 'chosen_shipping_methods', array() ) : array();
$packages       = WC()->shipping()->get_packages();
$has_wc_rates   = false;
$rates          = array();

if ( ! empty( $packages ) ) {
	foreach ( $packages as $package ) {
		if ( ! empty( $package['rates'] ) ) {
			$has_wc_rates = true;
			$rates        = $package['rates'];
			break;
		}
	}
}

$default_type = 'pickup';
if ( ! empty( $chosen_methods[0] ) && ! empty( $rates[ $chosen_methods[0] ] ) ) {
	$method_label = $rates[ $chosen_methods[0] ]->get_label();
	if ( false !== stripos( $method_label, 'достав' ) ) {
		$default_type = 'delivery';
	}
}

$options = array(
	'pickup'   => array(
		'title'       => 'Самовывоз из салона',
		'description' => 'Бесплатно. Минск, ул.Руссиянова, 3',
	),
	'delivery' => array(
		'title'       => 'Доставка по Беларуси',
		'description' => 'Стоимость и сроки рассчитываются индивидуально',
	),
);
?>

<section class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8" data-checkout-delivery>
	<div class="flex items-center gap-3 mb-6">
		<span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FF6B00] text-white text-sm font-bold shrink-0" aria-hidden="true">2</span>
		<h2 class="text-white text-lg md:text-xl font-bold">Получение заказа</h2>
	</div>

	<input type="hidden" name="motorcycle_delivery_type" value="<?php echo esc_attr( $default_type ); ?>" data-delivery-type-input />

	<div class="grid grid-cols-1 sm:grid-cols-2 gap-4" role="radiogroup" aria-label="<?php esc_attr_e( 'Способ получения заказа', 'motorcycle-shop' ); ?>">
		<?php foreach ( $options as $type => $option ) : ?>
			<?php
			$is_active = $type === $default_type;
			$card_class = $is_active
				? 'border-[#FF6B00] bg-[#1F242B]'
				: 'border-transparent bg-[#1A1A1A] hover:border-[#434C58]';
			$radio_class = $is_active ? 'border-[#FF6B00]' : 'border-[#434C58]';
			$dot_class   = $is_active ? 'bg-[#FF6B00] scale-100' : 'bg-transparent scale-0';
			?>
			<button
				type="button"
				class="delivery-option relative flex flex-col items-start text-left w-full p-5 md:p-6 rounded-[2px] border-2 transition-colors <?php echo esc_attr( $card_class ); ?>"
				data-delivery-option="<?php echo esc_attr( $type ); ?>"
				role="radio"
				aria-checked="<?php echo $is_active ? 'true' : 'false'; ?>"
			>
				<span class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 flex items-center justify-center <?php echo esc_attr( $radio_class ); ?>" aria-hidden="true">
					<span class="w-2.5 h-2.5 rounded-full transition-transform <?php echo esc_attr( $dot_class ); ?>"></span>
				</span>
				<span class="text-white text-base md:text-lg font-semibold pr-8 leading-snug"><?php echo esc_html( $option['title'] ); ?></span>
				<span class="text-[#B8C0CC] text-sm mt-2 leading-relaxed"><?php echo esc_html( $option['description'] ); ?></span>
			</button>
		<?php endforeach; ?>
	</div>

	<?php
	$checkout       = WC()->checkout();
	$billing_fields = $checkout->get_checkout_fields( 'billing' );
	$city_field     = isset( $billing_fields['billing_city'] ) ? $billing_fields['billing_city'] : null;
	$address_field  = isset( $billing_fields['billing_address_1'] ) ? $billing_fields['billing_address_1'] : null;
	$show_delivery  = 'delivery' === $default_type;

	if ( ! $show_delivery ) {
		if ( $city_field ) {
			$city_field['custom_attributes']['disabled'] = 'disabled';
		}
		if ( $address_field ) {
			$address_field['custom_attributes']['disabled'] = 'disabled';
		}
	}
	?>

	<div
		class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5 mt-4 <?php echo $show_delivery ? '' : 'hidden'; ?>"
		data-delivery-address-fields
	>
		<?php
		if ( $city_field ) {
			woocommerce_form_field( 'billing_city', $city_field, $checkout->get_value( 'billing_city' ) );
		}

		if ( $address_field ) {
			woocommerce_form_field( 'billing_address_1', $address_field, $checkout->get_value( 'billing_address_1' ) );
		}
		?>
	</div>

	<div data-pickup-address-fields class="<?php echo $show_delivery ? 'hidden' : ''; ?>">
		<input type="hidden" name="billing_city" value="Минск" data-pickup-city <?php disabled( $show_delivery ); ?> />
		<input type="hidden" name="billing_address_1" value="Самовывоз: ул.Руссиянова, 3" data-pickup-address <?php disabled( $show_delivery ); ?> />
	</div>

	<?php if ( $has_wc_rates ) : ?>
		<div class="sr-only" aria-hidden="true">
			<?php wc_cart_totals_shipping_html(); ?>
		</div>
	<?php endif; ?>
</section>

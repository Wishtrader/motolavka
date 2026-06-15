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
		'field_key'   => 'billing_city',
	),
	'delivery' => array(
		'title'       => 'Доставка по Беларуси',
		'description' => 'Стоимость и сроки рассчитываются индивидуально',
		'field_key'   => 'billing_address_1',
	),
);

$checkout       = WC()->checkout();
$billing_fields = $checkout->get_checkout_fields( 'billing' );
$show_delivery  = 'delivery' === $default_type;
?>

<section class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8" data-checkout-delivery>
	<div class="flex items-center gap-3 mb-6">
		<span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#FF6B00] text-white text-sm font-bold shrink-0" aria-hidden="true">2</span>
		<h2 class="text-white text-lg md:text-xl font-bold">Получение заказа</h2>
	</div>

	<input type="hidden" name="motorcycle_delivery_type" value="<?php echo esc_attr( $default_type ); ?>" data-delivery-type-input />

	<div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch" role="radiogroup" aria-label="<?php esc_attr_e( 'Способ получения заказа', 'motorcycle-shop' ); ?>">
		<?php foreach ( $options as $type => $option ) : ?>
			<?php
			$is_active   = $type === $default_type;
			$card_class  = $is_active
				? 'border-[#FF6B00] bg-[#1F242B]'
				: 'border-transparent bg-[#1A1A1A] hover:border-[#434C58]';
			$radio_class = $is_active ? 'border-[#FF6B00]' : 'border-[#434C58]';
			$dot_class   = $is_active ? 'bg-[#FF6B00] scale-100' : 'bg-transparent scale-0';
			$field_key   = $option['field_key'];
			$field       = isset( $billing_fields[ $field_key ] ) ? $billing_fields[ $field_key ] : null;

			if ( $field && ! $show_delivery ) {
				$field['custom_attributes']['disabled'] = 'disabled';
			}
			?>
			<div class="flex flex-col gap-4 min-w-0 w-full <?php echo $type === 'delivery' ? 'order-2' : ''; ?>" data-delivery-column="<?php echo esc_attr( $type ); ?>">
				<button
					type="button"
					class="delivery-option relative flex flex-col items-start text-left w-full flex-1 min-h-[108px] p-5 md:p-6 rounded-[2px] border-2 transition-colors <?php echo esc_attr( $card_class ); ?> <?php echo $type === 'pickup' ? 'order-1' : ''; ?>"
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

				<?php if ( $field ) : ?>
					<div
						class="w-full min-w-0 shrink-0 <?php echo $show_delivery ? '' : 'hidden'; ?> <?php echo $type === 'pickup' ? 'order-3' : ''; ?>"
						data-delivery-field="<?php echo esc_attr( $type ); ?>"
					>
						<?php woocommerce_form_field( $field_key, $field, $checkout->get_value( $field_key ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
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

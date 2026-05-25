<?php
/**
 * Checkout page customization.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Checkout page: ensure [woocommerce_checkout] shortcode loads theme templates.
 *
 * @param string $content Page content.
 * @return string
 */
function motorcycle_shop_checkout_page_content( $content ) {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return $content;
	}

	if ( ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( has_shortcode( $content, 'woocommerce_checkout' ) ) {
		return $content;
	}

	return do_shortcode( '[woocommerce_checkout]' );
}
add_filter( 'the_content', 'motorcycle_shop_checkout_page_content', 5 );

/**
 * Remove login/coupon forms from checkout (not in design).
 */
function motorcycle_shop_checkout_remove_extras() {
	if ( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}
add_action( 'wp', 'motorcycle_shop_checkout_remove_extras' );

/**
 * Simplify checkout fields to match the design.
 *
 * @param array $fields Checkout fields.
 * @return array
 */
function motorcycle_shop_checkout_fields( $fields ) {
	$input_row = array( 'form-row-wide' );

	$fields['billing']['billing_first_name'] = array(
		'label'       => 'Ваше имя',
		'placeholder' => 'Иван Иванов',
		'required'    => true,
		'class'       => $input_row,
		'priority'    => 10,
		'autocomplete' => 'given-name',
	);

	if ( isset( $fields['billing']['billing_last_name'] ) ) {
		unset( $fields['billing']['billing_last_name'] );
	}

	$fields['billing']['billing_phone'] = array(
		'label'       => 'Телефон',
		'placeholder' => '+375 XX XXX-XX-XX',
		'required'    => true,
		'class'       => $input_row,
		'priority'    => 20,
		'type'        => 'tel',
		'autocomplete' => 'tel',
	);

	$fields['billing']['billing_email'] = array(
		'label'       => 'E-mail',
		'placeholder' => 'example@mail.com',
		'required'    => true,
		'class'       => $input_row,
		'priority'    => 30,
		'autocomplete' => 'email',
	);

	foreach ( array( 'billing_company', 'billing_country', 'billing_address_2', 'billing_state', 'billing_postcode' ) as $remove_key ) {
		if ( isset( $fields['billing'][ $remove_key ] ) ) {
			unset( $fields['billing'][ $remove_key ] );
		}
	}

	$fields['billing']['billing_city'] = array(
		'label'       => 'Город',
		'placeholder' => 'Минск',
		'required'    => false,
		'class'       => $input_row,
		'priority'    => 50,
		'autocomplete' => 'address-level2',
	);

	$fields['billing']['billing_address_1'] = array(
		'label'       => 'Адрес',
		'placeholder' => 'пр-т Независимости 1',
		'required'    => false,
		'class'       => $input_row,
		'priority'    => 60,
		'autocomplete' => 'street-address',
	);

	if ( isset( $fields['shipping'] ) ) {
		unset( $fields['shipping'] );
	}

	if ( isset( $fields['order']['order_comments'] ) ) {
		$fields['order']['order_comments'] = array(
			'type'        => 'textarea',
			'label'       => 'Комментарий (не обязательно)',
			'placeholder' => 'Дополнительная информация',
			'required'    => false,
			'class'       => $input_row,
			'priority'    => 40,
		);
	}

	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'motorcycle_shop_checkout_fields' );

/**
 * Tailwind classes for checkout form fields.
 *
 * @param array  $args  Field args.
 * @param string $key   Field key.
 * @param mixed  $value Field value.
 * @return array
 */
function motorcycle_shop_checkout_form_field_args( $args, $key, $value ) {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return $args;
	}

	$input_class = 'w-full px-4 py-3 rounded-[2px] bg-white text-[#171A1F] text-sm placeholder:text-[#9CA3AF] border-0 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]';
	$delivery_input_class = 'w-full px-4 py-3 rounded-[2px] bg-[#F0F2F5] text-[#171A1F] text-sm placeholder:text-[#9CA3AF] border-0 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]';
	$label_class = 'text-[#B8C0CC] text-xs mb-1.5 block font-normal';

	if ( in_array( $args['type'], array( 'text', 'tel', 'email', 'textarea' ), true ) ) {
		if ( in_array( $key, array( 'billing_city', 'billing_address_1' ), true ) ) {
			$args['input_class'] = array( $delivery_input_class );
		} else {
			$args['input_class'] = array( $input_class );
		}
		$args['label_class'] = array( $label_class );
	}

	if ( 'textarea' === $args['type'] ) {
		$args['custom_attributes']['rows'] = 3;
	}

	$args['class'] = array( 'form-row', 'w-full' );

	return $args;
}
add_filter( 'woocommerce_form_field_args', 'motorcycle_shop_checkout_form_field_args', 10, 3 );

/**
 * Default billing country for hidden validation.
 *
 * @param string $country Country code.
 * @return string
 */
function motorcycle_shop_checkout_default_country( $country ) {
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) && '' === $country ) {
		return 'BY';
	}

	return $country;
}
add_filter( 'default_checkout_billing_country', 'motorcycle_shop_checkout_default_country' );

/**
 * Orders are confirmed by manager — no online payment step in UI.
 *
 * @param bool $needs_payment Whether cart needs payment.
 * @return bool
 */
function motorcycle_shop_checkout_needs_payment( $needs_payment ) {
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
		return false;
	}

	return $needs_payment;
}
add_filter( 'woocommerce_cart_needs_payment', 'motorcycle_shop_checkout_needs_payment' );

/**
 * Place order button label.
 *
 * @return string
 */
function motorcycle_shop_order_button_text() {
	return 'Оформить заказ';
}
add_filter( 'woocommerce_order_button_text', 'motorcycle_shop_order_button_text' );

/**
 * Privacy / terms checkbox label on checkout.
 *
 * @return string
 */
function motorcycle_shop_checkout_terms_text() {
	return 'Продолжая, вы соглашаетесь с политикой конфиденциальности';
}
add_filter( 'woocommerce_get_terms_and_conditions_checkbox_text', 'motorcycle_shop_checkout_terms_text' );

/**
 * Save custom delivery preference to order meta.
 *
 * @param int   $order_id Order ID.
 * @param array $data     Posted data.
 */
function motorcycle_shop_checkout_save_delivery_meta( $order_id, $data ) {
	if ( empty( $_POST['motorcycle_delivery_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return;
	}

	$type = sanitize_text_field( wp_unslash( $_POST['motorcycle_delivery_type'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
	$labels = array(
		'pickup'   => 'Самовывоз из салона',
		'delivery' => 'Доставка по Беларуси',
	);

	if ( isset( $labels[ $type ] ) ) {
		update_post_meta( $order_id, '_motorcycle_delivery_type', $type );
		$order = wc_get_order( $order_id );
		if ( $order ) {
			$order->add_order_note( 'Способ получения: ' . $labels[ $type ] );
		}
	}
}
add_action( 'woocommerce_checkout_update_order_meta', 'motorcycle_shop_checkout_save_delivery_meta', 10, 2 );

/**
 * Validate delivery address when delivery is selected.
 *
 * @param array    $data   Posted data.
 * @param WP_Error $errors Validation errors.
 */
function motorcycle_shop_checkout_validate_delivery_address( $data, $errors ) {
	$type = isset( $_POST['motorcycle_delivery_type'] ) ? sanitize_text_field( wp_unslash( $_POST['motorcycle_delivery_type'] ) ) : 'pickup'; // phpcs:ignore WordPress.Security.NonceVerification.Missing

	if ( 'delivery' !== $type ) {
		return;
	}

	if ( empty( $data['billing_city'] ) ) {
		$errors->add( 'billing_city', 'Укажите город доставки.' );
	}

	if ( empty( $data['billing_address_1'] ) ) {
		$errors->add( 'billing_address_1', 'Укажите адрес доставки.' );
	}
}
add_action( 'woocommerce_after_checkout_validation', 'motorcycle_shop_checkout_validate_delivery_address', 10, 2 );

/**
 * URL for consultation CTA on checkout.
 *
 * @return string
 */
function motorcycle_shop_checkout_consultation_url() {
	$contact = motorcycle_shop_get_page_url_by_template( 'contact.php' );
	return $contact ? $contact : home_url( '/contact/' );
}

/**
 * Enqueue checkout scripts.
 */
function motorcycle_shop_checkout_scripts() {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	wp_enqueue_script( 'wc-checkout' );

	$script_path = get_template_directory() . '/js/checkout.js';

	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'motorcycle-shop-checkout',
			get_template_directory_uri() . '/js/checkout.js',
			array( 'jquery', 'wc-checkout' ),
			(string) filemtime( $script_path ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_checkout_scripts', 30 );

/**
 * WooCommerce notices on checkout page.
 */
function motorcycle_shop_checkout_notice_styles() {
	if ( ! is_checkout() ) {
		return;
	}
	?>
	<style>
		.woocommerce-notices-wrapper .woocommerce-message,
		.woocommerce-notices-wrapper .woocommerce-info,
		.woocommerce-notices-wrapper .woocommerce-error {
			background: #2A3038;
			border: 1px solid #434C58;
			color: #F5F7FA;
			border-radius: 2px;
			padding: 12px 16px;
			margin-bottom: 16px;
			list-style: none;
		}
		.woocommerce-notices-wrapper .woocommerce-error {
			border-color: #FF6B00;
		}
		.checkout .woocommerce-shipping-fields,
		.checkout .woocommerce-additional-fields,
		.checkout #order_review_heading,
		.checkout .shop_table.woocommerce-checkout-review-order-table,
		.checkout .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text,
		.checkout #payment .wc_payment_methods {
			display: none !important;
		}
		.checkout .woocommerce-terms-and-conditions-wrapper {
			margin: 0;
			padding: 0;
			border: 0;
		}
		.checkout .woocommerce-terms-and-conditions-wrapper .form-row {
			margin: 0;
			padding: 0;
		}
		.checkout .woocommerce-terms-and-conditions-wrapper label {
			display: flex;
			align-items: flex-start;
			gap: 12px;
			cursor: pointer;
		}
		.checkout .woocommerce-terms-and-conditions-wrapper input[type="checkbox"] {
			position: absolute;
			width: 1px;
			height: 1px;
			padding: 0;
			margin: -1px;
			overflow: hidden;
			clip: rect(0, 0, 0, 0);
			white-space: nowrap;
			border: 0;
		}
		.checkout .woocommerce-billing-fields > h3,
		.checkout .woocommerce-shipping-fields > h3,
		.checkout .woocommerce-additional-fields > h3 {
			display: none;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'motorcycle_shop_checkout_notice_styles' );

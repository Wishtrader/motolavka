<?php
/**
 * Checkout page customization.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

require_once get_template_directory() . '/inc/class-wc-gateway-motorcycle-confirm.php';

/**
 * Register manager-confirmation payment gateway.
 *
 * @param array $gateways Payment gateways.
 * @return array
 */
function motorcycle_shop_register_confirm_gateway( $gateways ) {
	$gateways[] = 'WC_Gateway_Motorcycle_Confirm';
	return $gateways;
}
add_filter( 'woocommerce_payment_gateways', 'motorcycle_shop_register_confirm_gateway' );

/**
 * Enable gateway and select it by default on checkout.
 */
function motorcycle_shop_enable_confirm_gateway() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$settings = get_option( 'woocommerce_motorcycle_confirm_settings', array() );

	if ( empty( $settings['enabled'] ) || 'yes' !== $settings['enabled'] ) {
		$settings['enabled'] = 'yes';
		$settings['title']   = 'Подтверждение менеджером';
		update_option( 'woocommerce_motorcycle_confirm_settings', $settings );
	}
}
add_action( 'init', 'motorcycle_shop_enable_confirm_gateway', 20 );

/**
 * Use only manager-confirmation gateway on checkout.
 *
 * @param array $gateways Available gateways.
 * @return array
 */
function motorcycle_shop_checkout_payment_gateways( $gateways ) {
	if ( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return $gateways;
	}

	if ( isset( $gateways['motorcycle_confirm'] ) ) {
		return array( 'motorcycle_confirm' => $gateways['motorcycle_confirm'] );
	}

	// Do not strip all gateways if custom gateway is unavailable.
	return $gateways;
}
add_filter( 'woocommerce_available_payment_gateways', 'motorcycle_shop_checkout_payment_gateways' );

/**
 * Default selected payment method on checkout.
 *
 * @return string
 */
function motorcycle_shop_checkout_default_gateway() {
	return 'motorcycle_confirm';
}
add_filter( 'woocommerce_default_gateway', 'motorcycle_shop_checkout_default_gateway' );

/**
 * Pre-select manager-confirmation payment method in checkout session.
 */
function motorcycle_shop_checkout_set_payment_method() {
	if ( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) || ! WC()->session ) {
		return;
	}

	WC()->session->set( 'chosen_payment_method', 'motorcycle_confirm' );
}
add_action( 'woocommerce_before_checkout_form', 'motorcycle_shop_checkout_set_payment_method', 5 );

/**
 * Orders are confirmed by a manager — no online payment during checkout.
 *
 * @param bool $needs_payment Whether cart needs payment.
 * @return bool
 */
function motorcycle_shop_cart_needs_payment( $needs_payment ) {
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
		return false;
	}

	return $needs_payment;
}
add_filter( 'woocommerce_cart_needs_payment', 'motorcycle_shop_cart_needs_payment' );

/**
 * @param bool     $needs_payment Whether order needs payment.
 * @param WC_Order $order         Order.
 * @return bool
 */
function motorcycle_shop_order_needs_payment( $needs_payment, $order = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
	if ( is_admin() && ! wp_doing_ajax() ) {
		return $needs_payment;
	}

	return false;
}
add_filter( 'woocommerce_order_needs_payment', 'motorcycle_shop_order_needs_payment', 10, 2 );

/**
 * Fill required billing fields removed from the checkout UI.
 *
 * @param array $data Posted checkout data.
 * @return array
 */
function motorcycle_shop_checkout_posted_data( $data ) {
	if ( empty( $data['billing_last_name'] ) && ! empty( $data['billing_first_name'] ) ) {
		$data['billing_last_name'] = $data['billing_first_name'];
	}

	if ( empty( $data['billing_country'] ) ) {
		$data['billing_country'] = 'BY';
	}

	if ( empty( $data['billing_postcode'] ) ) {
		$data['billing_postcode'] = '000000';
	}

	if ( empty( $data['billing_state'] ) ) {
		$data['billing_state'] = '';
	}

	return $data;
}
add_filter( 'woocommerce_checkout_posted_data', 'motorcycle_shop_checkout_posted_data' );

/**
 * Thank-you page URL for a completed order.
 *
 * @param WC_Order|int|null $order Order object or ID.
 * @return string
 */
function motorcycle_shop_checkout_thank_you_url( $order = null ) {
	$url = function_exists( 'motorcycle_shop_thank_you_url' )
		? motorcycle_shop_thank_you_url()
		: home_url( '/thank-you/' );

	if ( ! $order ) {
		return $url;
	}

	if ( ! $order instanceof WC_Order ) {
		$order = wc_get_order( $order );
	}

	if ( ! $order ) {
		return $url;
	}

	return add_query_arg(
		array(
			'order_id' => $order->get_id(),
			'key'      => $order->get_order_key(),
		),
		$url
	);
}

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

	// Checkout block uses Store API and does not share the classic cart session.
	if ( function_exists( 'has_block' ) && has_block( 'woocommerce/checkout', $content ) ) {
		return do_shortcode( '[woocommerce_checkout]' );
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
		'label'             => 'Телефон',
		'placeholder'       => '+375-XX-XXX-XX-XX',
		'required'          => true,
		'class'             => $input_row,
		'priority'          => 20,
		'type'              => 'tel',
		'autocomplete'     => 'tel',
		'inputmode'        => 'tel',
		'custom_attributes' => array(
			'inputmode' => 'tel',
			'pattern'   => '^\\+375-[0-9]{2}-[0-9]{3}-[0-9]{2}-[0-9]{2}$',
			'maxlength' => '18',
		),
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
			'type'        => 'text',
			'label'       => 'Комментарий',
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
	$delivery_input_class = 'w-full px-4 py-3 rounded-[2px] bg-white text-[#171A1F] text-sm placeholder:text-[#9CA3AF] border-0 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]';
	$label_class          = 'text-[#B8C0CC] text-xs mb-1.5 block font-normal';
	$delivery_label_class = 'text-white text-xs mb-1.5 block font-normal';

	if ( in_array( $args['type'], array( 'text', 'tel', 'email', 'textarea' ), true ) ) {
		if ( in_array( $key, array( 'billing_city', 'billing_address_1' ), true ) ) {
			$args['input_class']  = array( $delivery_input_class );
			$args['label_class']  = array( $delivery_label_class );
		} else {
			$args['input_class'] = array( $input_class );
			$args['label_class'] = array( $label_class );
		}
	}

	if ( 'textarea' === $args['type'] ) {
		$args['custom_attributes']['rows'] = 3;
	}

	$args['class'] = array( 'form-row', 'w-full' );

	return $args;
}
add_filter( 'woocommerce_form_field_args', 'motorcycle_shop_checkout_form_field_args', 10, 3 );

/**
 * Remove "(optional)" suffix from checkout field labels.
 *
 * @return string
 */
function motorcycle_shop_checkout_optional_label() {
	return '';
}
add_filter( 'woocommerce_form_field_optional', 'motorcycle_shop_checkout_optional_label' );

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
 * Do not require WooCommerce shipping zones on checkout (delivery handled in theme).
 *
 * @param bool $needs_shipping Whether cart needs shipping.
 * @return bool
 */
function motorcycle_shop_checkout_needs_shipping( $needs_shipping ) {
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
		return false;
	}

	return $needs_shipping;
}
add_filter( 'woocommerce_cart_needs_shipping', 'motorcycle_shop_checkout_needs_shipping' );

/**
 * Redirect WooCommerce order-received endpoint to theme thank-you page.
 */
function motorcycle_shop_redirect_order_received_endpoint() {
	if ( ! function_exists( 'is_wc_endpoint_url' ) || ! is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	$order_id = absint( get_query_var( 'order-received' ) );

	if ( ! $order_id ) {
		return;
	}

	$order = wc_get_order( $order_id );

	if ( ! $order ) {
		return;
	}

	wp_safe_redirect( motorcycle_shop_checkout_thank_you_url( $order ) );
	exit;
}
add_action( 'template_redirect', 'motorcycle_shop_redirect_order_received_endpoint', 5 );

/**
 * Checkout requires a non-empty cart.
 */
function motorcycle_shop_checkout_require_cart() {
	if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
		return;
	}

	if ( ! WC()->cart || ! WC()->cart->is_empty() ) {
		return;
	}

	wp_safe_redirect( function_exists( 'motorcycle_shop_cart_page_url' ) ? motorcycle_shop_cart_page_url( '' ) : wc_get_cart_url() );
	exit;
}
add_action( 'template_redirect', 'motorcycle_shop_checkout_require_cart', 6 );

/**
 * Thank-you redirect after checkout without online payment.
 *
 * @param string   $url   Default redirect URL.
 * @param WC_Order $order Order.
 * @return string
 */
function motorcycle_shop_checkout_no_payment_redirect( $url, $order = null ) {
	return motorcycle_shop_checkout_thank_you_url( $order );
}
add_filter( 'woocommerce_checkout_no_payment_needed_redirect', 'motorcycle_shop_checkout_no_payment_redirect', 10, 2 );

/**
 * Clear cart and redirect after successful checkout (no payment gateway).
 *
 * @param int $order_id Order ID.
 */
function motorcycle_shop_checkout_order_created( $order_id ) {
	if ( ! $order_id || ! WC()->cart ) {
		return;
	}

	WC()->cart->empty_cart();
}
add_action( 'woocommerce_checkout_order_processed', 'motorcycle_shop_checkout_order_created', 5 );

/**
 * Thank-you redirect URL (AJAX checkout and gateways).
 *
 * @param string   $url   Default URL.
 * @param WC_Order $order Order.
 * @return string
 */
function motorcycle_shop_checkout_order_received_url( $url, $order ) {
	return motorcycle_shop_checkout_thank_you_url( $order );
}
add_filter( 'woocommerce_get_checkout_order_received_url', 'motorcycle_shop_checkout_order_received_url', 10, 2 );

/**
 * Privacy checkbox on checkout (when WC terms page is not configured).
 */
function motorcycle_shop_checkout_validate_privacy() {
	if ( ! empty( $_POST['terms'] ) || ! empty( $_POST['terms-field'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return;
	}

	wc_add_notice( 'Необходимо согласие с политикой конфиденциальности.', 'error' );
}
add_action( 'woocommerce_checkout_process', 'motorcycle_shop_checkout_validate_privacy' );

/**
 * Terms checkbox is decorative in UI — always treat as accepted when field is present.
 *
 * @param bool $is_checked Whether terms are checked.
 * @return bool
 */
function motorcycle_shop_checkout_terms_accepted( $is_checked ) {
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {
		return true;
	}

	return $is_checked;
}
add_filter( 'woocommerce_terms_is_checked', 'motorcycle_shop_checkout_terms_accepted' );

/**
 * Build plain-text order summary for emails.
 *
 * @param WC_Order $order Order.
 * @return string
 */
function motorcycle_shop_checkout_order_email_body( $order ) {
	if ( ! $order instanceof WC_Order ) {
		return '';
	}

	$delivery_type = get_post_meta( $order->get_id(), '_motorcycle_delivery_type', true );
	$delivery_map  = array(
		'pickup'   => 'Самовывоз из салона',
		'delivery' => 'Доставка по Беларуси',
	);
	$delivery_label = isset( $delivery_map[ $delivery_type ] ) ? $delivery_map[ $delivery_type ] : '—';

	$lines   = array();
	$lines[] = 'Номер заказа: #' . $order->get_order_number();
	$lines[] = 'Дата: ' . $order->get_date_created()->date_i18n( 'd.m.Y H:i' );
	$lines[] = '';
	$lines[] = 'Контакты:';
	$lines[] = 'Имя: ' . $order->get_billing_first_name();
	$lines[] = 'Телефон: ' . $order->get_billing_phone();
	$lines[] = 'E-mail: ' . $order->get_billing_email();
	$lines[] = '';
	$lines[] = 'Получение: ' . $delivery_label;
	$lines[] = 'Город: ' . $order->get_billing_city();
	$lines[] = 'Адрес: ' . $order->get_billing_address_1();

	if ( $order->get_customer_note() ) {
		$lines[] = 'Комментарий: ' . $order->get_customer_note();
	}

	$lines[] = '';
	$lines[] = 'Товары:';

	foreach ( $order->get_items() as $item ) {
		if ( ! is_callable( array( $item, 'get_name' ) ) ) {
			continue;
		}

		$item_total = wp_strip_all_tags(
			html_entity_decode(
				wc_price(
					(float) $item->get_total(),
					array( 'currency' => $order->get_currency() )
				),
				ENT_QUOTES,
				'UTF-8'
			)
		);

		$lines[] = sprintf(
			'- %s × %s — %s',
			$item->get_name(),
			$item->get_quantity(),
			$item_total
		);
	}

	$lines[] = '';
	$lines[] = 'Итого: ' . wp_strip_all_tags( html_entity_decode( $order->get_formatted_order_total(), ENT_QUOTES, 'UTF-8' ) );

	return implode( "\n", $lines );
}

/**
 * Send order notification emails after checkout.
 *
 * @param int      $order_id Order ID.
 * @param array    $posted   Posted data.
 * @param WC_Order $order    Order.
 */
function motorcycle_shop_checkout_send_order_emails( $order_id, $posted, $order ) {
	static $sent_for_orders = array();

	if ( isset( $sent_for_orders[ $order_id ] ) ) {
		return;
	}

	if ( ! $order instanceof WC_Order ) {
		$order = wc_get_order( $order_id );
	}

	if ( ! $order ) {
		return;
	}

	$sent_for_orders[ $order_id ] = true;

	$body = motorcycle_shop_checkout_order_email_body( $order );

	$admin_email = get_option( 'admin_email' );
	if ( $admin_email ) {
		wp_mail(
			$admin_email,
			sprintf( '[Мотолавка] Новый заказ #%s', $order->get_order_number() ),
			$body
		);
	}

	$customer_email = $order->get_billing_email();
	if ( $customer_email && is_email( $customer_email ) ) {
		wp_mail(
			$customer_email,
			sprintf( 'Ваш заказ #%s принят', $order->get_order_number() ),
			"Здравствуйте!\n\nСпасибо за заказ в Мотолавке. Мы получили вашу заявку и свяжемся с вами для подтверждения наличия и деталей получения.\n\n" . $body
		);
	}

}
add_action( 'woocommerce_checkout_order_processed', 'motorcycle_shop_checkout_send_order_emails', 20, 3 );

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
 * Terms checkbox checked by default (matches checkout design).
 *
 * @return bool
 */
function motorcycle_shop_checkout_terms_checked_default() {
	return true;
}
add_filter( 'woocommerce_terms_is_checked_default', 'motorcycle_shop_checkout_terms_checked_default' );

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
function motorcycle_shop_checkout_validate_phone_format( $data, $errors ) {
	if ( empty( $data['billing_phone'] ) ) {
		$errors->add( 'billing_phone', 'Укажите корректный номер телефона.' );
		return;
	}

	$phone = sanitize_text_field( wp_unslash( $data['billing_phone'] ) );

	if ( ! motorcycle_shop_is_valid_phone_by_format( $phone ) ) {
		$errors->add( 'billing_phone', 'Укажите номер телефона в формате +375-XX-XXX-XX-XX.' );
	}
}
add_action( 'woocommerce_after_checkout_validation', 'motorcycle_shop_checkout_validate_phone_format', 9, 2 );

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
		.checkout .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text,
		.checkout .woocommerce-checkout-payment .woocommerce-privacy-policy-text {
			display: none !important;
		}
		.checkout #payment.woocommerce-checkout-payment {
			background: transparent;
			border: 0;
			padding: 0;
			margin: 0;
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
		.checkout label .optional {
			display: none !important;
		}
		[data-checkout-delivery] [data-delivery-field] .form-row,
		[data-checkout-delivery] [data-delivery-field] .woocommerce-input-wrapper {
			width: 100%;
			margin: 0;
			padding: 0;
			float: none;
		}
		[data-checkout-delivery] [data-delivery-field] label {
			display: block;
		}
		[data-checkout-delivery] [data-delivery-field] input[type="text"] {
			width: 100%;
			box-sizing: border-box;
		}
		[data-checkout-delivery] [data-delivery-grid] {
			display: grid;
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
		[data-checkout-delivery] [data-delivery-column] {
			display: flex;
			flex-direction: column;
			min-width: 0;
		}
		[data-checkout-delivery] [data-delivery-grid] .delivery-option {
			flex: 1 1 auto;
			min-height: 108px;
		}
		@media (max-width: 767px) {
			[data-checkout-delivery] [data-delivery-column="pickup"] {
				display: contents !important;
			}
		}
	</style>
	<?php
}
add_action( 'wp_head', 'motorcycle_shop_checkout_notice_styles' );

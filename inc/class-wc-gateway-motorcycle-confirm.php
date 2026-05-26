<?php
/**
 * Offline payment: order confirmed by manager after checkout.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Manager confirmation payment gateway.
 */
class WC_Gateway_Motorcycle_Confirm extends WC_Payment_Gateway {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id                 = 'motorcycle_confirm';
		$this->icon               = '';
		$this->has_fields         = false;
		$this->method_title       = 'Подтверждение менеджером';
		$this->method_description = 'Оплата после подтверждения заказа менеджером.';
		$this->supports           = array( 'products' );

		$this->init_form_fields();
		$this->init_settings();

		$this->title       = $this->get_option( 'title', 'Подтверждение менеджером' );
		$this->description = $this->get_option( 'description', '' );
		$this->enabled     = $this->get_option( 'enabled', 'yes' );

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	/**
	 * Admin settings fields.
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
				'title'   => 'Включить',
				'type'    => 'checkbox',
				'label'   => 'Использовать способ оплаты',
				'default' => 'yes',
			),
			'title'   => array(
				'title'       => 'Название',
				'type'        => 'text',
				'description' => 'Название способа оплаты на странице оформления.',
				'default'     => 'Подтверждение менеджером',
				'desc_tip'    => true,
			),
		);
	}

	/**
	 * Process payment and redirect to thank-you page.
	 *
	 * @param int $order_id Order ID.
	 * @return array
	 */
	public function process_payment( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return array(
				'result'   => 'failure',
				'redirect' => '',
			);
		}

		$order->update_status( 'processing', 'Заказ оформлен на сайте. Ожидает подтверждения менеджером.' );
		$order->save();

		WC()->cart->empty_cart();

		return array(
			'result'   => 'success',
			'redirect' => motorcycle_shop_checkout_thank_you_url( $order ),
		);
	}
}

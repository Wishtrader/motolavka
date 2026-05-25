<?php
/**
 * Cart page, AJAX updates, header fragments.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cart page: use classic shortcode so theme template woocommerce/cart/cart.php loads.
 * Modern WC pages often contain the "Cart" block instead of [woocommerce_cart] text.
 *
 * @param string $content Page content.
 * @return string
 */
function motorcycle_shop_cart_page_content( $content ) {
	if ( ! function_exists( 'is_cart' ) || ! is_cart() ) {
		return $content;
	}

	if ( ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	if ( has_shortcode( $content, 'woocommerce_cart' ) ) {
		return $content;
	}

	return do_shortcode( '[woocommerce_cart]' );
}
add_filter( 'the_content', 'motorcycle_shop_cart_page_content', 5 );

/**
 * Enqueue WooCommerce cart scripts site-wide.
 */
function motorcycle_shop_cart_scripts() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'wc-cart-fragments' );

	if ( is_product() ) {
		wp_enqueue_script( 'wc-add-to-cart' );
	}

	$cart_js = get_template_directory() . '/js/cart.js';

	if ( file_exists( $cart_js ) ) {
		$cart_deps = array( 'jquery', 'wc-cart-fragments' );

		if ( is_product() ) {
			$cart_deps[] = 'wc-add-to-cart';
		}

		wp_enqueue_script(
			'motorcycle-shop-cart',
			get_template_directory_uri() . '/js/cart.js',
			$cart_deps,
			(string) filemtime( $cart_js ),
			true
		);

		wp_localize_script(
			'motorcycle-shop-cart',
			'motorcycleShopCart',
			array(
				'cartUrl'      => wc_get_cart_url(),
				'checkoutUrl'  => wc_get_checkout_url(),
				'wcAjaxUrl'    => WC_AJAX::get_endpoint( '%%endpoint%%' ),
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'cartNonce'    => wp_create_nonce( 'motorcycle-shop-cart' ),
				'isCartPage'   => is_cart(),
				'i18n'         => array(
					'updating' => __( 'Обновление…', 'motorcycle-shop' ),
					'error'    => __( 'Не удалось обновить корзину. Обновите страницу.', 'motorcycle-shop' ),
				),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_cart_scripts', 25 );

/**
 * Refresh header cart blocks after add to cart (AJAX).
 *
 * @param array $fragments Fragments.
 * @return array
 */
function motorcycle_shop_cart_fragments( $fragments ) {
	$variants = array( 'desktop', 'mobile', 'menu' );

	foreach ( $variants as $variant ) {
		ob_start();
		get_template_part( 'template-parts/header/cart-link', null, array( 'variant' => $variant ) );
		$fragments[ '#header-cart-' . $variant ] = ob_get_clean();
	}

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'motorcycle_shop_cart_fragments' );

/**
 * Remove default collaterals layout (custom cart template).
 */
function motorcycle_shop_cart_remove_collaterals() {
	if ( ! is_cart() ) {
		return;
	}

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
}
add_action( 'wp', 'motorcycle_shop_cart_remove_collaterals' );

/**
 * Short subtitle for cart line item.
 *
 * @param WC_Product $product Product.
 * @return string
 */
function motorcycle_shop_cart_item_subtitle( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}

	$short = $product->get_short_description();
	if ( $short ) {
		return wp_strip_all_tags( $short );
	}

	$specs = motorcycle_shop_get_product_specs( $product, 2 );
	return ! empty( $specs ) ? implode( ', ', $specs ) : '';
}

/**
 * Cart item thumbnail URL.
 *
 * @param WC_Product $product Product.
 * @return string
 */
function motorcycle_shop_cart_item_image_url( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return get_template_directory_uri() . '/img/moto.png';
	}

	$image_id = $product->get_image_id();
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' );
		if ( $url ) {
			return $url;
		}
	}

	return get_template_directory_uri() . '/img/moto.png';
}

/**
 * WooCommerce notices on cart page.
 */
function motorcycle_shop_cart_notice_styles() {
	if ( ! is_cart() ) {
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
	</style>
	<?php
}
add_action( 'wp_head', 'motorcycle_shop_cart_notice_styles' );

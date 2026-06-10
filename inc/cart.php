<?php
/**
 * Cart page, AJAX updates, header fragments.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Use classic PHP cart/checkout (not WooCommerce Blocks / Store API).
 *
 * @return bool
 */
function motorcycle_shop_use_classic_wc_cart() {
	return false;
}
add_filter( 'woocommerce_should_load_cart_and_checkout_blocks', 'motorcycle_shop_use_classic_wc_cart' );

/**
 * Session cookies on HTTP local installs (not only HTTPS).
 *
 * @param bool $secure Whether cookie is secure.
 * @return bool
 */
function motorcycle_shop_wc_session_secure_cookie( $secure ) {
	return is_ssl();
}
add_filter( 'wc_session_use_secure_cookie', 'motorcycle_shop_wc_session_secure_cookie' );

/**
 * Create or repair WooCommerce system pages (cart must not equal checkout).
 *
 * @param string $option_key WC page option key (cart|checkout).
 * @param string $title      Page title.
 * @param string $slug       Page slug.
 * @param string $shortcode  Page shortcode content.
 * @return int Page ID or 0.
 */
function motorcycle_shop_ensure_wc_system_page( $option_key, $title, $slug, $shortcode ) {
	$page_id = (int) wc_get_page_id( $option_key );

	if ( $page_id > 0 && 'publish' === get_post_status( $page_id ) ) {
		$content = get_post_field( 'post_content', $page_id );
		if ( false === strpos( $content, $shortcode ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_content' => $shortcode,
				)
			);
		}
		return $page_id;
	}

	$page = get_page_by_path( $slug );
	if ( $page && 'publish' === $page->post_status ) {
		$page_id = (int) $page->ID;
		update_option( 'woocommerce_' . $option_key . '_page_id', $page_id );
		if ( false === strpos( (string) $page->post_content, $shortcode ) ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_content' => $shortcode,
				)
			);
		}
		return $page_id;
	}

	$page_id = (int) wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $shortcode,
		),
		true
	);

	if ( $page_id > 0 && ! is_wp_error( $page_id ) ) {
		update_option( 'woocommerce_' . $option_key . '_page_id', $page_id );
	}

	return $page_id > 0 ? $page_id : 0;
}

/**
 * Ensure cart and checkout are separate pages with classic shortcodes.
 */
function motorcycle_shop_ensure_wc_store_pages() {
	if ( wp_installing() || ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	static $done = false;
	if ( $done ) {
		return;
	}
	$done = true;

	$cart_id     = motorcycle_shop_ensure_wc_system_page( 'cart', 'Корзина', 'cart', '[woocommerce_cart]' );
	$checkout_id = motorcycle_shop_ensure_wc_system_page( 'checkout', 'Оформление заказа', 'checkout', '[woocommerce_checkout]' );

	if ( $cart_id && $checkout_id && $cart_id === $checkout_id ) {
		$checkout_id = (int) wp_insert_post(
			array(
				'post_title'   => 'Оформление заказа',
				'post_name'    => 'checkout',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '[woocommerce_checkout]',
			),
			true
		);
		if ( $checkout_id > 0 && ! is_wp_error( $checkout_id ) ) {
			update_option( 'woocommerce_checkout_page_id', $checkout_id );
		}
	}
}
add_action( 'woocommerce_init', 'motorcycle_shop_ensure_wc_store_pages', 5 );

/**
 * Cart page permalink (never fall back to checkout URL).
 *
 * @param string $url Default URL.
 * @return string
 */
function motorcycle_shop_cart_page_url( $url ) {
	$cart_id = (int) wc_get_page_id( 'cart' );
	if ( $cart_id > 0 && 'publish' === get_post_status( $cart_id ) ) {
		return (string) get_permalink( $cart_id );
	}
	return home_url( '/cart/' );
}
add_filter( 'woocommerce_get_cart_url', 'motorcycle_shop_cart_page_url' );

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

	// Cart block (Gutenberg) does not use the theme cart template — force classic shortcode.
	if ( function_exists( 'has_block' ) && has_block( 'woocommerce/cart', $content ) ) {
		return do_shortcode( '[woocommerce_cart]' );
	}

	return do_shortcode( '[woocommerce_cart]' );
}

/**
 * Recalculate cart totals before rendering the cart page.
 */
function motorcycle_shop_cart_calculate_totals() {
	if ( is_cart() && WC()->cart ) {
		WC()->cart->calculate_totals();
	}
}
add_action( 'wp', 'motorcycle_shop_cart_calculate_totals', 15 );
add_filter( 'the_content', 'motorcycle_shop_cart_page_content', 5 );

/**
 * Ensure AJAX add to cart is enabled in WooCommerce settings.
 */
function motorcycle_shop_enable_ajax_add_to_cart() {
	if ( 'yes' !== get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) {
		update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );
	}
}
add_action( 'init', 'motorcycle_shop_enable_ajax_add_to_cart', 6 );

/**
 * Always redirect to cart after adding a product.
 */
function motorcycle_shop_enable_cart_redirect_after_add() {
	if ( 'yes' !== get_option( 'woocommerce_cart_redirect_after_add' ) ) {
		update_option( 'woocommerce_cart_redirect_after_add', 'yes' );
	}
}
add_action( 'init', 'motorcycle_shop_enable_cart_redirect_after_add', 6 );

/**
 * Force WooCommerce session cookie and cart persistence.
 */
function motorcycle_shop_cart_force_session() {
	if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart || ! WC()->session ) {
		return;
	}

	if ( ! WC()->session->has_session() ) {
		WC()->session->set_customer_session_cookie( true );
	}

	if ( ! WC()->cart->is_empty() ) {
		WC()->cart->calculate_totals();
		WC()->cart->set_session();
		WC()->cart->maybe_set_cart_cookies();
	}
}

/**
 * After adding to cart, redirect to the cart page (classic form submit).
 *
 * @param string $url Default redirect URL.
 * @return string
 */
function motorcycle_shop_add_to_cart_redirect( $url ) {
	if ( wp_doing_ajax() ) {
		return $url;
	}

	return motorcycle_shop_cart_page_url( $url );
}
add_filter( 'woocommerce_add_to_cart_redirect', 'motorcycle_shop_add_to_cart_redirect' );

/**
 * Start guest session when cart cookies exist but session was not loaded.
 */
function motorcycle_shop_wc_restore_guest_session() {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}

	if ( ! class_exists( 'WooCommerce' ) || ! WC()->session || ! WC()->cart ) {
		return;
	}

	if ( WC()->session->has_session() ) {
		return;
	}

	$has_cart_cookie = isset( $_COOKIE['woocommerce_items_in_cart'] ) && '1' === $_COOKIE['woocommerce_items_in_cart']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated

	if ( $has_cart_cookie ) {
		WC()->session->set_customer_session_cookie( true );
	}
}
add_action( 'woocommerce_init', 'motorcycle_shop_wc_restore_guest_session', 5 );

/**
 * Persist cart session immediately after add to cart.
 *
 * @param string $cart_item_key Cart item key.
 */
function motorcycle_shop_cart_set_session_after_add( $cart_item_key ) {
	motorcycle_shop_cart_force_session();
}
add_action( 'woocommerce_add_to_cart', 'motorcycle_shop_cart_set_session_after_add', 99 );

/**
 * Backup add-to-cart handler (runs after WC_Form_Handler on wp_loaded:20).
 */
function motorcycle_shop_backup_add_to_cart_handler() {
	if ( is_admin() || wp_doing_ajax() ) {
		return;
	}

	if ( empty( $_REQUEST['add-to-cart'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart ) {
		return;
	}

	$product_id = absint( wp_unslash( $_REQUEST['add-to-cart'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( $product_id <= 0 ) {
		return;
	}

	if ( ! WC()->cart->is_empty() ) {
		motorcycle_shop_cart_force_session();
		if ( ! headers_sent() ) {
			wp_safe_redirect( motorcycle_shop_cart_page_url( '' ) );
			exit;
		}
		return;
	}

	$product = wc_get_product( $product_id );
	if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
		return;
	}

	$quantity = isset( $_REQUEST['quantity'] ) ? wc_stock_amount( wp_unslash( $_REQUEST['quantity'] ) ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$quantity = max( 1, (int) $quantity );

	$added = WC()->cart->add_to_cart( $product_id, $quantity );

	if ( $added ) {
		motorcycle_shop_cart_force_session();
		wc_add_to_cart_message( array( $product_id => $quantity ), true );
	}

	if ( ! headers_sent() ) {
		wp_safe_redirect( motorcycle_shop_cart_page_url( '' ) );
		exit;
	}
}
add_action( 'wp_loaded', 'motorcycle_shop_backup_add_to_cart_handler', 25 );

/**
 * Use theme woocommerce.php wrapper for cart/checkout/account pages.
 *
 * @param string $template Path to template.
 * @return string
 */
function motorcycle_shop_woocommerce_page_template( $template ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $template;
	}

	if ( is_cart() || is_checkout() || is_account_page() ) {
		$wc_template = locate_template( 'woocommerce.php' );

		if ( $wc_template ) {
			return $wc_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'motorcycle_shop_woocommerce_page_template', 20 );

/**
 * Enqueue WooCommerce cart scripts site-wide.
 */
function motorcycle_shop_cart_scripts() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'wc-cart-fragments' );

	$cart_js = get_template_directory() . '/js/cart.js';

	if ( file_exists( $cart_js ) ) {
		wp_enqueue_script(
			'motorcycle-shop-cart',
			get_template_directory_uri() . '/js/cart.js',
			array( 'jquery', 'wc-cart-fragments' ),
			(string) filemtime( $cart_js ),
			true
		);

		wp_localize_script(
			'motorcycle-shop-cart',
			'motorcycleShopCart',
			array(
				'cartUrl'      => motorcycle_shop_cart_page_url( '' ),
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
 * Get cart item subtitle (category + engine volume).
 *
 * @param WC_Product $product Product.
 * @return string
 */
function motorcycle_shop_cart_item_subtitle( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}

	$result = array();

	// Get primary product category with singular name
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		// Get the first term (primary category)
		$term = reset( $terms );
		
		$category_name = $term->name;
		// Simple transformation: remove plural suffix if present
		$category_name = motorcycle_shop_singularize_category( $category_name );
		
		$result[] = esc_html( $category_name );
	}

	// Get engine volume
	$volume = motorcycle_shop_get_product_engine_volume( $product );
	if ( $volume ) {
		$result[] = esc_html( $volume );
	}

	return ! empty( $result ) ? implode( ', ', $result ) : '';
}

/**
 * Convert category name to singular form.
 *
 * @param string $name Category name.
 * @return string
 */
function motorcycle_shop_singularize_category( $name ) {
	// Work with a copy for transformations
	$result = $name;
	$result_lower = mb_strtolower( $result );

	// Replace adjectives (прилагательные) - anywhere in the string
	$adjective_replacements = array(
		'дорожные' => 'дорожный',
		'кроссовые' => 'кроссовый',
		'спортивные' => 'спортивный',
		'туристические' => 'туристический',
		'уличные' => 'уличный',
		'внедорожные' => 'внедорожный',
		'кастомные' => 'кастомный',
		'детские' => 'детский',
	);

	foreach ( $adjective_replacements as $plural => $singular ) {
		if ( mb_strpos( $result_lower, $plural ) !== false ) {
			$result = preg_replace( '/(' . preg_quote( $plural, '/' ) . ')/iu', $singular, $result );
			$result_lower = mb_strtolower( $result );
			break;
		}
	}

	// Replace nouns (существительные) - anywhere in the string
	$noun_replacements = array(
		'скутеры' => 'скутер',
		'мотоциклы' => 'мотоцикл',
		'квадроциклы' => 'квадроцикл',
		'мопеды' => 'мопед',
		'питбайки' => 'питбайк',
		'эндуро' => 'эндуро',
		'чопперы' => 'чоппер',
		'круизеры' => 'круизер',
		'минимото' => 'минимото',
		'байки' => 'байк',
	);

	foreach ( $noun_replacements as $plural => $singular ) {
		if ( mb_strpos( $result_lower, $plural ) !== false ) {
			$result = preg_replace( '/(' . preg_quote( $plural, '/' ) . ')/iu', $singular, $result );
			break;
		}
	}

	return $result;
}

/**
 * Get engine volume from product attributes.
 *
 * @param WC_Product $product Product.
 * @return string
 */
function motorcycle_shop_get_product_engine_volume( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return '';
	}

	// First, try to find attribute by label containing "объём", "объем" or "volume"
	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}

		$label = wc_attribute_label( $attribute->get_name(), $product );
		$slug = $attribute->get_name();

		// Check if label or slug contains volume-related keywords
		if ( stripos( $label, 'объём' ) !== false || 
		     stripos( $label, 'объем' ) !== false || 
		     stripos( $label, 'volume' ) !== false ||
		     stripos( $slug, 'cc' ) !== false ||
		     stripos( $slug, 'volume' ) !== false ) {
			
			if ( $attribute->is_taxonomy() ) {
				$terms = wc_get_product_terms(
					$product->get_id(),
					$slug,
					array( 'fields' => 'names' )
				);
				if ( ! empty( $terms ) ) {
					return reset( $terms );
				}
			} else {
				$options = $attribute->get_options();
				if ( ! empty( $options ) ) {
					return reset( $options );
				}
			}
		}
	}

	// If not found by keywords, return first visible attribute value (fallback)
	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}

		if ( $attribute->is_taxonomy() ) {
			$terms = wc_get_product_terms(
				$product->get_id(),
				$attribute->get_name(),
				array( 'fields' => 'names' )
			);
			if ( ! empty( $terms ) ) {
				// Return first term if it looks like a volume (contains numbers)
				$first_term = reset( $terms );
				if ( preg_match( '/[0-9]/', $first_term ) ) {
					return $first_term;
				}
			}
		} else {
			$options = $attribute->get_options();
			if ( ! empty( $options ) ) {
				$first_option = reset( $options );
				if ( preg_match( '/[0-9]/', $first_option ) ) {
					return $first_option;
				}
			}
		}
	}

	return '';
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
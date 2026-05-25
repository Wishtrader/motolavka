<?php
/**
 * Header cart icon with live count.
 *
 * @package motorcycle-shop
 *
 * @var string $variant desktop|mobile|menu
 */

defined( 'ABSPATH' ) || exit;

$variant = isset( $args['variant'] ) ? $args['variant'] : 'desktop';
$count   = ( class_exists( 'WooCommerce' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
$cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
$hidden  = $count < 1 ? ' hidden' : '';
$element_id = 'header-cart-' . $variant;

if ( 'desktop' === $variant ) :
	?>
	<a id="<?php echo esc_attr( $element_id ); ?>" href="<?php echo esc_url( $cart_url ); ?>" class="relative flex-shrink-0 motorcycle-shop-cart-link" aria-label="<?php esc_attr_e( 'Корзина', 'motorcycle-shop' ); ?>">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/img/cart.svg' ); ?>" alt="" width="24" height="24" />
		<span class="motorcycle-shop-cart-count absolute -top-[6px] -right-1 bg-[#FFFFFF] text-[#D95F0E] text-[10px] font-bold rounded-full min-w-[14px] h-[14px] px-0.5 flex items-center justify-center<?php echo esc_attr( $hidden ); ?>" data-cart-count><?php echo esc_html( $count ); ?></span>
	</a>
	<?php
else :
	?>
	<a id="<?php echo esc_attr( $element_id ); ?>" href="<?php echo esc_url( $cart_url ); ?>" class="relative motorcycle-shop-cart-link" aria-label="<?php esc_attr_e( 'Корзина', 'motorcycle-shop' ); ?>">
		<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
		</svg>
		<span class="motorcycle-shop-cart-count absolute -top-2 -right-2 bg-[#FF6B00] text-white text-[10px] font-bold rounded-full min-w-[20px] h-5 px-1 flex items-center justify-center<?php echo esc_attr( $hidden ); ?>" data-cart-count><?php echo esc_html( $count ); ?></span>
	</a>
	<?php
endif;

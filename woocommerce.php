<?php
/**
 * WooCommerce wrapper — routes archives to theme templates.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( is_singular( 'product' ) ) {
	while ( have_posts() ) {
		the_post();
		wc_get_template_part( 'content', 'single-product' );
	}
} elseif ( is_product_category() || is_product_tag() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_shop() ) {
	wc_get_template( 'archive-product.php' );
} elseif ( is_cart() || is_checkout() || is_account_page() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	woocommerce_content();
}

get_footer();

<?php
/**
 * Product search.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Search form action URL.
 *
 * @return string
 */
function motorcycle_shop_get_search_url() {
	return home_url( '/' );
}

/**
 * Whether the current search is for products.
 *
 * @return bool
 */
function motorcycle_shop_is_product_search() {
	if ( ! is_search() ) {
		return false;
	}

	$post_type = get_query_var( 'post_type' );

	if ( 'product' === $post_type ) {
		return true;
	}

	if ( is_array( $post_type ) && in_array( 'product', $post_type, true ) ) {
		return true;
	}

	return false;
}

/**
 * Limit search to WooCommerce products when requested.
 *
 * @param WP_Query $query Query.
 */
function motorcycle_shop_search_query_products( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

	if ( 'product' === $post_type ) {
		$query->set( 'post_type', 'product' );
		$query->set( 'post_status', 'publish' );
	}
}
add_action( 'pre_get_posts', 'motorcycle_shop_search_query_products' );

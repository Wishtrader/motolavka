<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package motorcycle-shop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function motorcycle_shop_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'motorcycle_shop_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function motorcycle_shop_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'motorcycle_shop_pingback_header' );

/**
 * Page URL by theme template file or slug fallback.
 *
 * @param string $template_file e.g. contact.php.
 * @param string $slug_fallback  Path slug without slashes.
 * @return string
 */
function motorcycle_shop_page_url( $template_file, $slug_fallback = '' ) {
	static $cache = array();

	$cache_key = $template_file . '|' . $slug_fallback;

	if ( isset( $cache[ $cache_key ] ) ) {
		return $cache[ $cache_key ];
	}

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => $template_file,
			'number'      => 1,
			'post_status' => 'publish',
		)
	);

	if ( ! empty( $pages ) ) {
		$cache[ $cache_key ] = get_permalink( $pages[0]->ID );
		return $cache[ $cache_key ];
	}

	if ( $slug_fallback ) {
		$page = get_page_by_path( $slug_fallback );

		if ( $page && 'publish' === $page->post_status ) {
			$cache[ $cache_key ] = get_permalink( $page );
			return $cache[ $cache_key ];
		}

		$cache[ $cache_key ] = home_url( '/' . trim( $slug_fallback, '/' ) . '/' );
		return $cache[ $cache_key ];
	}

	$cache[ $cache_key ] = home_url( '/' );

	return $cache[ $cache_key ];
}

/**
 * Footer product category links (WooCommerce product_cat).
 *
 * @return array<int, array{label: string, url: string}>
 */
function motorcycle_shop_footer_category_links() {
	$labels = array(
		'Дорожные мотоциклы',
		'Эндуро',
		'Квадроциклы',
		'Запчасти',
		'Аксессуары',
	);

	$catalog_url = motorcycle_shop_page_url( 'catalog.php', 'catalog' );
	$links       = array();

	foreach ( $labels as $label ) {
		$url  = $catalog_url;
		$term = get_term_by( 'name', $label, 'product_cat' );

		if ( ! $term ) {
			$term = get_term_by( 'slug', sanitize_title( $label ), 'product_cat' );
		}

		if ( $term && ! is_wp_error( $term ) ) {
			$term_link = get_term_link( $term );

			if ( ! is_wp_error( $term_link ) ) {
				$url = $term_link;
			}
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}

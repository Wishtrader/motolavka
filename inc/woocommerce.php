<?php
/**
 * WooCommerce theme integration.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declare WooCommerce support and tweak defaults.
 */
function motorcycle_shop_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'max_rows'        => 8,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 3,
			),
		)
	);
}
add_action( 'after_setup_theme', 'motorcycle_shop_woocommerce_setup' );

/**
 * Use Tailwind only — disable default WooCommerce stylesheets.
 *
 * @param array $styles Registered styles.
 * @return array
 */
function motorcycle_shop_woocommerce_dequeue_styles( $styles ) {
	unset( $styles['woocommerce-general'] );
	unset( $styles['woocommerce-layout'] );
	unset( $styles['woocommerce-smallscreen'] );

	return $styles;
}
add_filter( 'woocommerce_enqueue_styles', 'motorcycle_shop_woocommerce_dequeue_styles' );

/**
 * Remove default wrappers, sidebar, and loop chrome we replace in templates.
 */
function motorcycle_shop_woocommerce_remove_defaults() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );
}
add_action( 'init', 'motorcycle_shop_woocommerce_remove_defaults' );

/**
 * Hide default WooCommerce archive title (custom hero is used).
 *
 * @return bool
 */
function motorcycle_shop_hide_wc_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'motorcycle_shop_hide_wc_page_title' );

/**
 * Remove "View cart" link from add-to-cart success message (header cart badge is enough).
 *
 * @param string       $message  Message HTML.
 * @param int|array    $products Product IDs.
 * @param bool         $show_qty Show quantities.
 * @return string
 */
function motorcycle_shop_strip_view_cart_link_from_message( $message, $products, $show_qty ) {
	return trim( preg_replace( '#\s*<a\s+[^>]*class="[^"]*wc-forward[^"]*"[^>]*>.*?</a>#is', '', $message ) );
}
add_filter( 'wc_add_to_cart_message_html', 'motorcycle_shop_strip_view_cart_link_from_message', 10, 3 );

/**
 * Hide WooCommerce "View cart" link injected after AJAX add to cart on product page.
 */
function motorcycle_shop_hide_added_to_cart_link_css() {
	if ( ! is_product() ) {
		return;
	}
	?>
	<style id="motorcycle-shop-hide-view-cart">
		form.cart a.added_to_cart.wc-forward {
			display: none !important;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'motorcycle_shop_hide_added_to_cart_link_css', 100 );

/**
 * Remove default single product layout (custom templates).
 */
function motorcycle_shop_single_product_remove_defaults() {
	if ( ! is_product() ) {
		return;
	}

	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
}
add_action( 'wp', 'motorcycle_shop_single_product_remove_defaults' );

/**
 * Whether the current request is a single product page (safe before main query).
 *
 * @return bool
 */
function motorcycle_shop_is_single_product_page() {
	if ( function_exists( 'is_product' ) && is_product() ) {
		return true;
	}

	global $post;

	return $post instanceof WP_Post && 'product' === $post->post_type;
}

/**
 * Scripts for single product (quantity controls).
 * Note: is_product() is unreliable on wp_enqueue_scripts — use wp hook.
 */
function motorcycle_shop_single_product_scripts() {
	if ( ! motorcycle_shop_is_single_product_page() ) {
		return;
	}

	$script_path = get_template_directory() . '/js/single-product.js';

	wp_enqueue_script(
		'motorcycle-shop-single-product',
		get_template_directory_uri() . '/js/single-product.js',
		array(),
		file_exists( $script_path ) ? (string) filemtime( $script_path ) : _S_VERSION,
		true
	);
}
add_action( 'wp', 'motorcycle_shop_single_product_scripts' );

/**
 * URL of a page using a specific template file.
 *
 * @param string $template_file e.g. shipping.php.
 * @return string
 */
function motorcycle_shop_get_page_url_by_template( $template_file ) {
	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => $template_file,
			'number'     => 1,
		)
	);

	return ! empty( $pages ) ? get_permalink( $pages[0] ) : home_url( '/' );
}

/**
 * Deepest assigned product category.
 *
 * @param int $product_id Product ID.
 * @return WP_Term|null
 */
function motorcycle_shop_get_primary_product_category( $product_id ) {
	$terms = get_the_terms( $product_id, 'product_cat' );

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	usort(
		$terms,
		function ( $a, $b ) {
			$depth_a = count( get_ancestors( $a->term_id, 'product_cat' ) );
			$depth_b = count( get_ancestors( $b->term_id, 'product_cat' ) );
			return $depth_b <=> $depth_a;
		}
	);

	return $terms[0];
}

/**
 * Breadcrumbs for single product page.
 *
 * @param WC_Product $product Product.
 * @return array<int, array{label: string, url: string}>
 */
function motorcycle_shop_wc_product_breadcrumbs( $product ) {
	$items = array(
		array(
			'label' => 'Главная',
			'url'   => home_url( '/' ),
		),
		array(
			'label' => 'Каталог',
			'url'   => home_url( '/catalog/' ),
		),
	);

	$primary = motorcycle_shop_get_primary_product_category( $product->get_id() );

	if ( $primary ) {
		$ancestor_ids = array_reverse( get_ancestors( $primary->term_id, 'product_cat' ) );

		foreach ( $ancestor_ids as $ancestor_id ) {
			$ancestor = get_term( $ancestor_id, 'product_cat' );
			if ( $ancestor && ! is_wp_error( $ancestor ) ) {
				$items[] = array(
					'label' => $ancestor->name,
					'url'   => get_term_link( $ancestor ),
				);
			}
		}

		$items[] = array(
			'label' => $primary->name,
			'url'   => get_term_link( $primary ),
		);
	}

	$items[] = array(
		'label' => $product->get_name(),
		'url'   => '',
	);

	return $items;
}

/**
 * All visible product attributes as label => value rows.
 *
 * @param WC_Product $product Product.
 * @return array<int, array{label: string, value: string}>
 */
function motorcycle_shop_get_product_attribute_rows( $product ) {
	$rows = array();

	if ( ! $product instanceof WC_Product ) {
		return $rows;
	}

	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}

		$value = $product->get_attribute( $attribute->get_name() );
		if ( '' === $value ) {
			continue;
		}

		$rows[] = array(
			'label' => wc_attribute_label( $attribute->get_name(), $product ),
			'value' => $value,
		);
	}

	if ( $product->has_weight() ) {
		$rows[] = array(
			'label' => __( 'Вес', 'motorcycle-shop' ),
			'value' => wc_format_weight( $product->get_weight() ),
		);
	}

	if ( $product->has_dimensions() ) {
		$rows[] = array(
			'label' => __( 'Габариты', 'motorcycle-shop' ),
			'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
		);
	}

	return $rows;
}

/**
 * Highlight specs for the icon grid (up to 6).
 *
 * @param WC_Product $product Product.
 * @return array<int, array{label: string, value: string, icon: string}>
 */
function motorcycle_shop_get_product_highlight_specs( $product ) {
	$rows   = motorcycle_shop_get_product_attribute_rows( $product );
	$icons  = array( 's1.svg', 's2.svg', 's3.svg', 's4.svg', 's5.svg', 's6.svg' );
	$specs  = array();
	$uri    = get_template_directory_uri() . '/img/';

	foreach ( array_slice( $rows, 0, 6 ) as $index => $row ) {
		$specs[] = array(
			'label' => $row['label'],
			'value' => $row['value'],
			'icon'  => $uri . $icons[ $index % count( $icons ) ],
		);
	}

	return $specs;
}

/**
 * Product gallery attachment IDs.
 *
 * @param WC_Product $product Product.
 * @return int[]
 */
function motorcycle_shop_get_product_gallery_ids( $product ) {
	$ids = array();

	if ( ! $product instanceof WC_Product ) {
		return $ids;
	}

	$featured_id = (int) $product->get_image_id();
	if ( $featured_id ) {
		$ids[] = $featured_id;
	}

	$gallery_ids = $product->get_gallery_image_ids();

	if ( empty( $gallery_ids ) ) {
		$meta = get_post_meta( $product->get_id(), '_product_image_gallery', true );
		if ( is_string( $meta ) && '' !== $meta ) {
			$gallery_ids = array_filter( array_map( 'absint', explode( ',', $meta ) ) );
		}
	}

	foreach ( $gallery_ids as $gallery_id ) {
		$gallery_id = (int) $gallery_id;
		if ( $gallery_id && ! in_array( $gallery_id, $ids, true ) ) {
			$ids[] = $gallery_id;
		}
	}

	return $ids;
}

/**
 * Gallery switcher — printed in footer (works even if inline scripts are blocked).
 */
function motorcycle_shop_product_gallery_footer_script() {
	if ( ! motorcycle_shop_is_single_product_page() ) {
		return;
	}
	?>
	<script id="motorcycle-shop-product-gallery">
		function motorcycleShopSwitchProductImage(button) {
			var gallery = button.closest('[data-product-gallery]');
			if (!gallery) {
				return false;
			}

			var mainImage = gallery.querySelector('[data-gallery-main]');
			var fullUrl = button.getAttribute('data-full-url');

			if (!mainImage || !fullUrl) {
				return false;
			}

			mainImage.setAttribute('src', fullUrl);
			mainImage.removeAttribute('srcset');
			mainImage.removeAttribute('sizes');

			gallery.querySelectorAll('[data-gallery-thumb]').forEach(function (thumb) {
				thumb.classList.remove('is-active');
				thumb.style.borderColor = 'transparent';
				thumb.setAttribute('aria-pressed', 'false');
			});

			button.classList.add('is-active');
			button.style.borderColor = '#ff6b00';
			button.setAttribute('aria-pressed', 'true');

			return false;
		}
	</script>
	<?php
}
add_action( 'wp_footer', 'motorcycle_shop_product_gallery_footer_script', 5 );

/**
 * Related products heading.
 *
 * @param string $heading Default heading.
 * @return string
 */
function motorcycle_shop_related_products_heading( $heading ) {
	return 'Рекомендуем также';
}
add_filter( 'woocommerce_product_related_products_heading', 'motorcycle_shop_related_products_heading' );

/**
 * Russian add to cart label on product page.
 *
 * @return string
 */
function motorcycle_shop_single_add_to_cart_text() {
	return 'В корзину';
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'motorcycle_shop_single_add_to_cart_text' );

/**
 * Tailwind-friendly WooCommerce notices on product pages.
 */
function motorcycle_shop_wc_notice_styles() {
	if ( ! is_product() ) {
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
	</style>
	<?php
}
add_action( 'wp_head', 'motorcycle_shop_wc_notice_styles' );

/**
 * Product grid opener (div instead of ul).
 *
 * @param string $html Default markup.
 * @return string
 */
function motorcycle_shop_product_loop_start( $html ) {
	return '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[20px] woocommerce-product-grid">';
}
add_filter( 'woocommerce_product_loop_start', 'motorcycle_shop_product_loop_start' );

/**
 * Product grid closer.
 *
 * @param string $html Default markup.
 * @return string
 */
function motorcycle_shop_product_loop_end( $html ) {
	return '</div>';
}
add_filter( 'woocommerce_product_loop_end', 'motorcycle_shop_product_loop_end' );

/**
 * Russian labels for catalog sorting.
 *
 * @param array $options Sort options.
 * @return array
 */
function motorcycle_shop_catalog_orderby_labels( $options ) {
	return array(
		'menu_order' => 'По умолчанию',
		'popularity' => 'По популярности',
		'rating'     => 'По рейтингу',
		'date'       => 'По новизне',
		'price'      => 'По цене: сначала дешевле',
		'price-desc' => 'По цене: сначала дороже',
	);
}
add_filter( 'woocommerce_catalog_orderby', 'motorcycle_shop_catalog_orderby_labels' );

/**
 * Default sort: popularity (as in the design).
 *
 * @param string $default Default orderby.
 * @return string
 */
function motorcycle_shop_default_catalog_orderby( $default ) {
	return 'popularity';
}
add_filter( 'woocommerce_default_catalog_orderby', 'motorcycle_shop_default_catalog_orderby' );

/**
 * Products per page on category archives (3×3 grid).
 *
 * @return int
 */
function motorcycle_shop_category_products_per_page() {
	return 9;
}
add_filter( 'loop_shop_per_page', 'motorcycle_shop_category_products_per_page', 20 );

/**
 * Hero background for a product category.
 *
 * @param WP_Term $term Category term.
 * @return string Image URL.
 */
function motorcycle_shop_wc_category_hero_image( $term ) {
	return get_template_directory_uri() . '/img/inner-catalog-bg.png';
}

/**
 * Breadcrumb items for a product category archive.
 *
 * @param WP_Term $term Category term.
 * @return array<int, array{label: string, url: string}>
 */
function motorcycle_shop_wc_category_breadcrumbs( $term ) {
	$items = array(
		array(
			'label' => 'Главная',
			'url'   => home_url( '/' ),
		),
		array(
			'label' => 'Каталог',
			'url'   => motorcycle_shop_page_url( 'catalog.php', 'catalog' ),
		),
	);

	$ancestor_ids = array_reverse( get_ancestors( $term->term_id, 'product_cat' ) );

	foreach ( $ancestor_ids as $ancestor_id ) {
		$ancestor = get_term( $ancestor_id, 'product_cat' );
		if ( $ancestor && ! is_wp_error( $ancestor ) ) {
			$items[] = array(
				'label' => $ancestor->name,
				'url'   => get_term_link( $ancestor ),
			);
		}
	}

	$items[] = array(
		'label' => $term->name,
		'url'   => '',
	);

	return $items;
}

/**
 * Short spec tags for a product card (attributes, max 3).
 *
 * @param WC_Product $product Product object.
 * @param int        $limit   Max tags.
 * @return string[]
 */
function motorcycle_shop_get_product_specs( $product, $limit = 3 ) {
	$specs = array();

	if ( ! $product instanceof WC_Product ) {
		return $specs;
	}

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
			foreach ( $terms as $term_name ) {
				$specs[] = $term_name;
				if ( count( $specs ) >= $limit ) {
					return $specs;
				}
			}
		} else {
			foreach ( $attribute->get_options() as $value ) {
				$specs[] = $value;
				if ( count( $specs ) >= $limit ) {
					return $specs;
				}
			}
		}
	}

	return $specs;
}

/**
 * Formatted price parts for product cards (matches homepage markup).
 *
 * @param WC_Product $product Product object.
 * @return array{amount: string, currency: string}
 */
function motorcycle_shop_get_product_price_parts( $product ) {
	$price = (float) wc_get_price_to_display( $product );

	return array(
		'amount'   => number_format(
			$price,
			wc_get_price_decimals(),
			wc_get_price_decimal_separator(),
			wc_get_price_thousand_separator()
		),
		'currency' => get_woocommerce_currency(),
	);
}

/**
 * Default category description when the term has none.
 *
 * @param WP_Term $term Category term.
 * @return string
 */
function motorcycle_shop_wc_category_default_description( $term ) {
	$name = mb_strtolower( $term->name );

	/* translators: %s: product category name (lowercase) */
	return sprintf(
		'Модели для города, трассы и повседневной эксплуатации. В каталоге — %s разных классов с возможностью подбора по бренду, объёму двигателя и цене.',
		$name
	);
}

/**
 * SEO block title for category archives.
 *
 * @param WP_Term $term Category term.
 * @return string
 */
function motorcycle_shop_wc_category_seo_title( $term ) {
	/* translators: %s: product category name (lowercase) */
	return sprintf( 'Как выбрать %s', mb_strtolower( $term->name ) );
}

/**
 * SEO block body for category archives.
 *
 * @param WP_Term $term Category term.
 * @return string
 */
function motorcycle_shop_wc_category_seo_content( $term ) {
	if ( ! empty( $term->description ) ) {
		return wp_kses_post( wpautop( $term->description ) );
	}

	$name = esc_html( mb_strtolower( $term->name ) );

	return wp_kses_post(
		wpautop(
			"При выборе {$name} важно учитывать объём двигателя, предполагаемые условия эксплуатации, опыт вождения и доступность сервиса. Если нужен универсальный вариант для города и загородных поездок, подберём модель под ваш бюджет и задачи."
		)
	);
}

<?php
/**
 * Cookie consent banner.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

define( 'MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME', 'motorcycle_shop_cookie_consent' );

/**
 * Whether the visitor already chose cookie preferences.
 *
 * @return string|null accepted|declined|null
 */
function motorcycle_shop_get_cookie_consent() {
	if ( empty( $_COOKIE[ MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME ] ) ) {
		return null;
	}

	$value = sanitize_text_field( wp_unslash( $_COOKIE[ MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME ] ) );

	return in_array( $value, array( 'accepted', 'declined' ), true ) ? $value : null;
}

/**
 * Enqueue cookie consent script.
 */
function motorcycle_shop_cookie_scripts() {
	if ( is_admin() ) {
		return;
	}

	$script_path = get_template_directory() . '/js/cookies.js';

	if ( ! file_exists( $script_path ) ) {
		return;
	}

	wp_enqueue_script(
		'motorcycle-shop-cookies',
		get_template_directory_uri() . '/js/cookies.js',
		array(),
		(string) filemtime( $script_path ),
		true
	);

	wp_localize_script(
		'motorcycle-shop-cookies',
		'motorcycleShopCookies',
		array(
			'consentCookieName' => MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME,
			'cookiePolicyUrl'   => motorcycle_shop_cookie_policy_url(),
			'cookieDays'        => 365,
		)
	);
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_cookie_scripts', 30 );

/**
 * URL for cookie policy page (by template or slug).
 *
 * @return string
 */
function motorcycle_shop_cookie_policy_url() {
	static $url = null;

	if ( null !== $url ) {
		return $url;
	}

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'cookie-policy.php',
			'number'      => 1,
			'post_status' => 'publish',
		)
	);

	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0]->ID );
		return $url;
	}

	$page = get_page_by_path( 'cookie-policy' );

	if ( $page && 'publish' === $page->post_status ) {
		$url = get_permalink( $page );
		return $url;
	}

	$url = home_url( '/cookie-policy/' );

	return $url;
}

/**
 * URL for privacy policy page (by template or slug).
 *
 * @return string
 */
function motorcycle_shop_privacy_policy_url() {
	static $url = null;

	if ( null !== $url ) {
		return $url;
	}

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'privacy-policy.php',
			'number'      => 1,
			'post_status' => 'publish',
		)
	);

	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0]->ID );
		return $url;
	}

	$page = get_page_by_path( 'privacy-policy' );

	if ( $page && 'publish' === $page->post_status ) {
		$url = get_permalink( $page );
		return $url;
	}

	$page = get_page_by_path( 'politika-konfidencialnosti' );

	if ( $page && 'publish' === $page->post_status ) {
		$url = get_permalink( $page );
		return $url;
	}

	$url = home_url( '/privacy-policy/' );

	return $url;
}

/**
 * Find all pages that belong to a legal page definition (template or title).
 *
 * @param array $def Definition with title, slug, template.
 * @return WP_Post[]
 */
function motorcycle_shop_get_legal_page_candidates( $def ) {
	$by_template = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => $def['template'],
		)
	);

	$by_title = array();
	$page     = get_page_by_title( $def['title'], OBJECT, 'any' );

	if ( $page instanceof WP_Post ) {
		$by_title[] = $page;
	}

	global $wpdb;

	$slug_like = $wpdb->esc_like( $def['slug'] ) . '%';
	$slug_ids  = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'page' AND post_name LIKE %s AND post_status NOT IN ('trash', 'auto-draft')",
			$slug_like
		)
	);

	$pages = array();

	foreach ( array_merge( $by_template, $by_title ) as $page ) {
		if ( $page instanceof WP_Post ) {
			$pages[ $page->ID ] = $page;
		}
	}

	foreach ( $slug_ids as $page_id ) {
		$page_id = (int) $page_id;
		if ( $page_id && ! isset( $pages[ $page_id ] ) ) {
			$page = get_post( $page_id );
			if ( $page instanceof WP_Post ) {
				$pages[ $page_id ] = $page;
			}
		}
	}

	return array_values( $pages );
}

/**
 * Keep a single page per definition; delete duplicates.
 *
 * @param array $def Definition.
 * @return WP_Post|null Kept page.
 */
function motorcycle_shop_dedupe_legal_pages( $def ) {
	$pages = motorcycle_shop_get_legal_page_candidates( $def );

	if ( empty( $pages ) ) {
		return null;
	}

	$keeper = null;

	foreach ( $pages as $page ) {
		if ( $def['slug'] === $page->post_name ) {
			$keeper = $page;
			break;
		}
	}

	if ( ! $keeper ) {
		$keeper = $pages[0];
	}

	foreach ( $pages as $page ) {
		if ( (int) $page->ID === (int) $keeper->ID ) {
			continue;
		}

		wp_delete_post( $page->ID, true );
	}

	$update = array(
		'ID' => $keeper->ID,
	);

	if ( $def['slug'] !== $keeper->post_name ) {
		$update['post_name'] = $def['slug'];
	}

	if ( 'publish' !== $keeper->post_status ) {
		$update['post_status'] = 'publish';
	}

	if ( count( $update ) > 1 ) {
		wp_update_post( $update );
	}

	if ( get_page_template_slug( $keeper->ID ) !== $def['template'] ) {
		update_post_meta( $keeper->ID, '_wp_page_template', $def['template'] );
	}

	return get_post( $keeper->ID );
}

/**
 * Create privacy & cookie policy pages if missing (uses theme templates).
 */
function motorcycle_shop_ensure_legal_pages() {
	if ( wp_installing() ) {
		return;
	}

	static $checked = false;

	if ( $checked ) {
		return;
	}

	$checked = true;

	$definitions = array(
		array(
			'title'    => 'Политика конфиденциальности',
			'slug'     => 'privacy-policy',
			'template' => 'privacy-policy.php',
		),
		array(
			'title'    => 'Политика обработки файлов cookie',
			'slug'     => 'cookie-policy',
			'template' => 'cookie-policy.php',
		),
	);

	$needs_flush = false;
	$author_id   = (int) get_option( 'motorcycle_shop_legal_pages_author', 0 );

	if ( $author_id <= 0 ) {
		$admins = get_users(
			array(
				'role'   => 'administrator',
				'number' => 1,
			)
		);
		$author_id = ! empty( $admins ) ? (int) $admins[0]->ID : 1;
		update_option( 'motorcycle_shop_legal_pages_author', $author_id, false );
	}

	$GLOBALS['motorcycle_shop_creating_legal_pages'] = true;
	$previous_user_id                                = get_current_user_id();
	wp_set_current_user( $author_id );

	foreach ( $definitions as $def ) {
		$before_count = count( motorcycle_shop_get_legal_page_candidates( $def ) );
		$page         = motorcycle_shop_dedupe_legal_pages( $def );

		if ( $before_count > 1 ) {
			$needs_flush = true;
		}

		if ( $page instanceof WP_Post ) {
			continue;
		}

		$page_id = wp_insert_post(
			array(
				'post_title'  => $def['title'],
				'post_name'   => $def['slug'],
				'post_status' => 'publish',
				'post_type'   => 'page',
				'post_author' => $author_id,
			),
			true
		);

		if ( $page_id && ! is_wp_error( $page_id ) ) {
			update_post_meta( $page_id, '_wp_page_template', $def['template'] );
			$needs_flush = true;
		}
	}

	unset( $GLOBALS['motorcycle_shop_creating_legal_pages'] );
	wp_set_current_user( $previous_user_id );

	if ( $needs_flush ) {
		flush_rewrite_rules( false );
	}

	update_option( 'motorcycle_shop_legal_pages_ready', '1', false );
}
add_action( 'init', 'motorcycle_shop_ensure_legal_pages', 5 );

/**
 * Allow one-time legal page creation without an admin session on the front end.
 *
 * @param array    $allcaps All capabilities.
 * @param array    $caps    Required caps.
 * @param array    $args    Args.
 * @param WP_User  $user    User.
 * @return array
 */
function motorcycle_shop_legal_pages_user_caps( $allcaps, $caps, $args, $user ) {
	if ( empty( $GLOBALS['motorcycle_shop_creating_legal_pages'] ) ) {
		return $allcaps;
	}

	$allcaps['publish_pages'] = true;
	$allcaps['edit_pages']    = true;
	$allcaps['edit_page']     = true;

	return $allcaps;
}
add_filter( 'user_has_cap', 'motorcycle_shop_legal_pages_user_caps', 10, 4 );

/**
 * Render cookie banner in footer.
 */
function motorcycle_shop_render_cookie_banner() {
	if ( is_admin() ) {
		return;
	}

	get_template_part( 'template-parts/cookie', 'banner' );
}
add_action( 'wp_footer', 'motorcycle_shop_render_cookie_banner', 20 );

/**
 * Set consent cookie via AJAX (optional server sync).
 */
function motorcycle_shop_save_cookie_consent_ajax() {
	check_ajax_referer( 'motorcycle-shop-cookie-consent', 'nonce' );

	$consent = isset( $_POST['consent'] ) ? sanitize_text_field( wp_unslash( $_POST['consent'] ) ) : '';

	if ( ! in_array( $consent, array( 'accepted', 'declined' ), true ) ) {
		wp_send_json_error( array( 'message' => 'Invalid consent' ), 400 );
	}

	$expire = time() + ( 365 * DAY_IN_SECONDS );

	setcookie(
		MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME,
		$consent,
		$expire,
		COOKIEPATH ? COOKIEPATH : '/',
		COOKIE_DOMAIN ? COOKIE_DOMAIN : '',
		is_ssl(),
		false
	);

	$_COOKIE[ MOTORCYCLE_SHOP_COOKIE_CONSENT_NAME ] = $consent;

	wp_send_json_success( array( 'consent' => $consent ) );
}
add_action( 'wp_ajax_motorcycle_shop_cookie_consent', 'motorcycle_shop_save_cookie_consent_ajax' );
add_action( 'wp_ajax_nopriv_motorcycle_shop_cookie_consent', 'motorcycle_shop_save_cookie_consent_ajax' );

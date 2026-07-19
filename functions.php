<?php
/**
 * motorcycle-shop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package motorcycle-shop
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.3' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function motorcycle_shop_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on motorcycle-shop, use a find and replace
		* to change 'motorcycle-shop' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'motorcycle-shop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'motorcycle-shop' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'motorcycle_shop_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'motorcycle_shop_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function motorcycle_shop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'motorcycle_shop_content_width', 640 );
}
add_action( 'after_setup_theme', 'motorcycle_shop_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function motorcycle_shop_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'motorcycle-shop' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'motorcycle-shop' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'motorcycle_shop_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function motorcycle_shop_scripts() {
	wp_enqueue_style( 'motorcycle-shop-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'motorcycle-shop-style', 'rtl', 'replace' );

	wp_enqueue_script( 'motorcycle-shop-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'imask', 'https://unpkg.com/imask', array(), null, true );
	wp_enqueue_script( 'motorcycle-shop-phone-mask', get_template_directory_uri() . '/js/phone-mask.js', array( 'imask' ), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * WooCommerce integration.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
	require get_template_directory() . '/inc/cart.php';
	require get_template_directory() . '/inc/checkout.php';
}

/**
 * Product search.
 */
require get_template_directory() . '/inc/search.php';

/**
 * Cookie consent banner.
 */
require get_template_directory() . '/inc/cookies.php';

/**
 * Lead forms and thank-you page.
 */
require get_template_directory() . '/inc/leads.php';

/**
 * Get contact data from the "Контакты" page ACF fields.
 *
 * Returns an associative array with keys: phone, email, worktime, address, map_url.
 * Falls back to hardcoded defaults if ACF or the page is missing.
 *
 * @param string $context Optional context ('header', 'footer', etc.) for future per-context overrides.
 * @return array
 */
function motorcycle_shop_get_contacts( $context = '' ) {
	$defaults = array(
		'phone'    => '+375 29 307 06 03',
		'email'    => 'motolavkaby@yandex.by',
		'worktime' => 'Пн-Пт с 9:00 до 19:00',
		'address'  => 'г. Минск, ул. Глаголева 45, к.1',
		'map_url'  => 'https://yandex.ru/map-widget/v1/?ll=27.483255%2C53.884906&z=16&pt=27.483255%2C53.884906%2Cpm2rdm&l=map',
	);

	if ( ! function_exists( 'get_field' ) ) {
		return $defaults;
	}

	// Find the Contact page by template.
	$contact_page = get_page_by_path( 'contact' );
	if ( ! $contact_page ) {
		$args = array(
			'post_type'      => 'page',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'contact.php',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			$contact_page_id = $query->posts[0];
		}
		wp_reset_postdata();
	} else {
		$contact_page_id = $contact_page->ID;
	}

	if ( empty( $contact_page_id ) ) {
		return $defaults;
	}

	$phone    = get_field( 'phone', $contact_page_id );
	$email    = get_field( 'email', $contact_page_id );
	$worktime = get_field( 'worktime', $contact_page_id );
	$address  = get_field( 'address', $contact_page_id );
	$map_url  = get_field( 'map_url', $contact_page_id );

	return array(
		'phone'    => ! empty( $phone ) ? $phone : $defaults['phone'],
		'email'    => ! empty( $email ) ? $email : $defaults['email'],
		'worktime' => ! empty( $worktime ) ? $worktime : $defaults['worktime'],
		'address'  => ! empty( $address ) ? $address : $defaults['address'],
		'map_url'  => ! empty( $map_url ) ? $map_url : $defaults['map_url'],
	);
}

/**
 * Register ACF fields for the Contact page template.
 *
 * Adds a repeater "contact_cards" so contact cards can be managed from the
 * admin, plus the existing hero image and map URL fields.
 */
function motorcycle_shop_register_contact_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$contact_page = get_page_by_path( 'contact' );
	$location_id = $contact_page ? $contact_page->ID : null;

	acf_add_local_field_group( array(
		'key'      => 'group_contact_page',
		'title'    => 'Контакты — настройки страницы',
		'fields'   => array(
			array(
				'key'   => 'field_contact_hero_img',
				'label' => 'Фоновое изображение (Hero)',
				'name'  => 'hero_img',
				'type'  => 'image',
				'return_format' => 'url',
			),
			array(
				'key'   => 'field_contact_map_url',
				'label' => 'Ссылка на карту (iframe)',
				'name'  => 'map_url',
				'type'  => 'url',
			),
			array(
				'key'          => 'field_contact_cards',
				'label'        => 'Карточки контактов',
				'name'         => 'contact_cards',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Добавить карточку',
				'sub_fields'   => array(
					array(
						'key'           => 'field_contact_card_icon',
						'label'         => 'Иконка',
						'name'          => 'icon',
						'type'          => 'image',
						'return_format' => 'url',
						'required'      => 1,
					),
					array(
						'key'   => 'field_contact_card_title',
						'label' => 'Заголовок',
						'name'  => 'title',
						'type'  => 'text',
						'required' => 1,
					),
					array(
						'key'   => 'field_contact_card_value',
						'label' => 'Значение',
						'name'  => 'value',
						'type'  => 'text',
						'required' => 1,
					),
					array(
						'key'   => 'field_contact_card_link',
						'label' => 'Ссылка (необязательно, напр. tel:/mailto:)',
						'name'  => 'link',
						'type'  => 'text',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'contact.php',
				),
			),
		),
	) );
}
add_action( 'acf/init', 'motorcycle_shop_register_contact_acf_fields' );


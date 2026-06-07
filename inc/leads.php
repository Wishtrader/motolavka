<?php
/**
 * Lead request forms (modal, submissions, thank-you page).
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Validate Belarus phone by strict format: +375-XX-XXX-XX-XX
 *
 * @param string $phone Raw user input.
 * @return bool
 */
function motorcycle_shop_is_valid_phone_by_format( $phone ) {
	$phone = trim( (string) $phone );

	// Allow only exact pattern with dashes.
return (bool) preg_match( '/^\+375\d{9}$/', $phone );
}


/**
 * Register private post type for stored lead submissions.
 */
function motorcycle_shop_register_lead_post_type() {
	register_post_type(
		'ms_lead',
		array(
			'labels'              => array(
				'name'          => 'Заявки',
				'singular_name' => 'Заявка',
				'add_new'       => 'Добавить',
				'add_new_item'  => 'Добавить заявку',
				'edit_item'     => 'Заявка',
				'view_item'     => 'Просмотр',
				'search_items'  => 'Поиск заявок',
				'not_found'     => 'Заявок нет',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 26,
			'menu_icon'           => 'dashicons-email-alt',
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'capabilities'        => array(
				'create_posts' => 'do_not_allow',
			),
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'motorcycle_shop_register_lead_post_type' );

/**
 * Thank-you page URL.
 *
 * @return string
 */
function motorcycle_shop_thank_you_url() {
	return motorcycle_shop_page_url( 'thank-you.php', 'thank-you' );
}

/**
 * Create thank-you page if missing.
 */
function motorcycle_shop_ensure_thank_you_page() {
	if ( wp_installing() ) {
		return;
	}

	static $checked = false;

	if ( $checked ) {
		return;
	}

	$checked = true;

	$pages = get_pages(
		array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'thank-you.php',
			'number'      => 1,
			'post_status' => 'publish',
		)
	);

	if ( ! empty( $pages ) ) {
		return;
	}

	$page = get_page_by_path( 'thank-you' );

	if ( $page && 'publish' === $page->post_status ) {
		if ( get_page_template_slug( $page->ID ) !== 'thank-you.php' ) {
			update_post_meta( $page->ID, '_wp_page_template', 'thank-you.php' );
		}
		return;
	}

	$author_id = 1;
	$admins    = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
		)
	);

	if ( ! empty( $admins ) ) {
		$author_id = (int) $admins[0]->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'  => 'Спасибо за заявку',
			'post_name'   => 'thank-you',
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_author' => $author_id,
		),
		true
	);

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'thank-you.php' );
		flush_rewrite_rules( false );
	}
}
add_action( 'init', 'motorcycle_shop_ensure_thank_you_page', 6 );

/**
 * Output a button/link that opens the lead modal.
 *
 * @param array $args text, source, class, tag (button|a).
 */
function motorcycle_shop_lead_modal_trigger( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'text'   => 'Получить консультацию',
			'source' => 'site',
			'class'  => '',
			'tag'    => 'button',
		)
	);

	$attrs = sprintf(
		' data-lead-modal-open data-lead-source="%s" class="%s"',
		esc_attr( $args['source'] ),
		esc_attr( trim( $args['class'] ) )
	);

	if ( 'a' === $args['tag'] ) {
		printf(
			'<a href="#"%1$s>%2$s</a>',
			$attrs,
			esc_html( $args['text'] )
		);
		return;
	}

	printf(
		'<button type="button"%1$s>%2$s</button>',
		$attrs,
		esc_html( $args['text'] )
	);
}

/**
 * Enqueue lead modal script on the public site.
 */
function motorcycle_shop_lead_scripts() {
	if ( is_admin() ) {
		return;
	}

	$script_path = get_template_directory() . '/js/lead-modal.js';

	if ( ! file_exists( $script_path ) ) {
		return;
	}

	wp_enqueue_script(
		'motorcycle-shop-lead-modal',
		get_template_directory_uri() . '/js/lead-modal.js',
		array(),
		(string) filemtime( $script_path ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_lead_scripts', 35 );

/**
 * Enqueue contact form script on contact page.
 */
function motorcycle_shop_contact_scripts() {
	if ( is_admin() ) {
		return;
	}

	if ( ! is_page_template( 'contact.php' ) && ! is_page( 'contact' ) ) {
		return;
	}

	$script_path = get_template_directory() . '/js/contact.js';

	if ( ! file_exists( $script_path ) ) {
		return;
	}

	wp_enqueue_script(
		'motorcycle-shop-contact-form',
		get_template_directory_uri() . '/js/contact.js',
		array(),
		(string) filemtime( $script_path ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'motorcycle_shop_contact_scripts', 36 );

/**
 * Render lead modal in the footer.
 */
function motorcycle_shop_render_lead_modal() {
	if ( is_admin() ) {
		return;
	}

	get_template_part( 'template-parts/lead', 'modal' );
}
add_action( 'wp_footer', 'motorcycle_shop_render_lead_modal', 15 );

/**
 * Lead form validation error messages.
 *
 * @return array<string, string>
 */
function motorcycle_shop_lead_error_messages() {
	return array(
		'name'    => 'Укажите имя (минимум 2 символа).',
		'phone'   => 'Укажите корректный номер телефона.',
		'privacy' => 'Необходимо согласие с политикой конфиденциальности.',
		'invalid' => 'Не удалось отправить заявку. Попробуйте ещё раз.',
		'save'    => 'Ошибка сохранения. Попробуйте позже или позвоните нам.',
	);
}

/**
 * @param string $code Error code.
 * @return string
 */
function motorcycle_shop_lead_get_error_message( $code ) {
	$messages = motorcycle_shop_lead_error_messages();

	return isset( $messages[ $code ] ) ? $messages[ $code ] : '';
}

/**
 * Redirect back with a lead form error (modal or inline #form section).
 *
 * @param string $code Error code.
 */
function motorcycle_shop_lead_error_redirect( $code ) {
	$referer = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$referer = remove_query_arg( array( 'lead_error', 'lead_inline' ), $referer );
	$args    = array( 'lead_error' => $code );

	if ( ! empty( $_POST['lead_inline'] ) ) {
		$args['lead_inline'] = '1';
	}

	$url = add_query_arg( $args, $referer );

	if ( ! empty( $_POST['lead_inline'] ) ) {
		$url .= '#form';
	}

	wp_safe_redirect( $url );
	exit;
}

/**
 * Render inline lead form for #form sections (no modal).
 *
 * @param string $source Lead source identifier.
 */
function motorcycle_shop_render_inline_lead_form( $source = 'home-form' ) {
	$privacy_policy_url = function_exists( 'motorcycle_shop_privacy_policy_url' )
		? motorcycle_shop_privacy_policy_url()
		: home_url( '/privacy-policy/' );

	$lead_error         = isset( $_GET['lead_error'] ) ? sanitize_text_field( wp_unslash( $_GET['lead_error'] ) ) : '';
	$is_inline_context  = ! empty( $_GET['lead_inline'] );
	$lead_error_message = ( $is_inline_context && $lead_error ) ? motorcycle_shop_lead_get_error_message( $lead_error ) : '';
	?>
	<form method="post" action="" class="flex flex-1" data-lead-inline-form>
		<div class="flex flex-col flex-1 gap-[12px] w-full">
			<?php if ( $lead_error_message ) : ?>
				<p class="text-[#FF6B00] text-sm" role="alert"><?php echo esc_html( $lead_error_message ); ?></p>
			<?php endif; ?>

			<input type="hidden" name="motorcycle_shop_lead_submit" value="1">
			<input type="hidden" name="lead_inline" value="1">
			<input type="hidden" name="lead_source" value="<?php echo esc_attr( $source ); ?>">
			<?php wp_nonce_field( 'motorcycle_shop_submit_lead', 'motorcycle_shop_lead_nonce' ); ?>

			<input
				type="text"
				name="lead_name"
				required
				minlength="2"
				autocomplete="name"
				class="w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
				placeholder="Имя"
			/>

			<input
				type="tel"
				name="lead_phone"
				required
				autocomplete="tel"
				inputmode="tel"
pattern="^\\+375\\d{9}$"
				onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 43"
				class="w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
				placeholder="+375XXXXXXXXX"
			/>


			<label class="inline-flex items-start gap-3 cursor-pointer">
				<input type="checkbox" name="lead_privacy" value="1" class="peer sr-only" required checked />
				<span class="relative mt-[2px] w-[32px] h-[32px] shrink-0 rounded-[2px] bg-[#FF6B00] flex items-center justify-center hover:brightness-95 peer-checked:[&_svg]:opacity-100">
					<svg class="w-6 h-6 text-white opacity-100 transition-opacity duration-150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
						<path d="M20 6L9 17l-5-5" />
					</svg>
				</span>
				<span class="select-none text-white text-sm leading-[1.4] pt-1">
					Продолжая, вы соглашаетесь с
					<a href="<?php echo esc_url( $privacy_policy_url ); ?>" class="text-[#FF6B00] hover:text-[#FB8A3C] underline underline-offset-2" target="_blank" rel="noopener noreferrer">политикой конфиденциальности</a>
				</span>
			</label>

			<button
				type="submit"
				class="flex w-full flex-1 max-h-[52px] md:max-w-[285px] mt-[32px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
			>
				Отправить заявку
			</button>
		</div>
	</form>
	<?php
}

/**
 * Process lead form POST on the same host as the page (avoids admin-post nonce issues).
 */
function motorcycle_shop_maybe_handle_lead_submission() {
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		return;
	}

	if ( empty( $_POST['motorcycle_shop_lead_submit'] ) ) {
		return;
	}

	motorcycle_shop_handle_lead_submission();
}
add_action( 'init', 'motorcycle_shop_maybe_handle_lead_submission', 1 );

/**
 * Handle lead form POST submission.
 */
function motorcycle_shop_handle_lead_submission() {
	$nonce = isset( $_POST['motorcycle_shop_lead_nonce'] ) ? wp_unslash( $_POST['motorcycle_shop_lead_nonce'] ) : '';

	if ( ! is_string( $nonce ) || ! wp_verify_nonce( $nonce, 'motorcycle_shop_submit_lead' ) ) {
		motorcycle_shop_lead_error_redirect( 'invalid' );
	}

	$name   = isset( $_POST['lead_name'] ) ? sanitize_text_field( wp_unslash( $_POST['lead_name'] ) ) : '';
	$phone  = isset( $_POST['lead_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['lead_phone'] ) ) : '';
	$agree  = ! empty( $_POST['lead_privacy'] );
	$source = isset( $_POST['lead_source'] ) ? sanitize_text_field( wp_unslash( $_POST['lead_source'] ) ) : 'site';

	if ( ! $agree ) {
		motorcycle_shop_lead_error_redirect( 'privacy' );
	}

	if ( strlen( $name ) < 2 ) {
		motorcycle_shop_lead_error_redirect( 'name' );
	}

	if ( ! motorcycle_shop_is_valid_phone_by_format( $phone ) ) {
		motorcycle_shop_lead_error_redirect( 'phone' );
	}


	$title = sprintf(
		'%s — %s',
		$name,
		trim( $phone )
	);

	$author_id = 1;
	$admins    = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
		)
	);

	if ( ! empty( $admins ) ) {
		$author_id = (int) $admins[0]->ID;
	}

	$GLOBALS['motorcycle_shop_submitting_lead'] = true;
	$previous_user_id                           = get_current_user_id();
	wp_set_current_user( $author_id );

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'ms_lead',
			'post_title'  => $title,
			'post_status' => 'publish',
			'post_author' => $author_id,
		),
		true
	);

	unset( $GLOBALS['motorcycle_shop_submitting_lead'] );
	wp_set_current_user( $previous_user_id );

	if ( is_wp_error( $post_id ) ) {
		motorcycle_shop_lead_error_redirect( 'save' );
	}

	update_post_meta( $post_id, '_lead_name', $name );
	update_post_meta( $post_id, '_lead_phone', $phone );
	update_post_meta( $post_id, '_lead_source', $source );

	$admin_email = get_option( 'admin_email' );

	if ( $admin_email ) {
		wp_mail(
			$admin_email,
			sprintf( '[Мотолавка] Новая заявка: %s', $name ),
			sprintf(
				"Имя: %s\nТелефон: %s\nИсточник: %s\nIP адрес: %s\nДата: %s\n\nПросмотр в админке: %s",
				$name,
				$phone,
				$source,
				$_SERVER['REMOTE_ADDR'] ?? 'Неизвестно',
				current_time( 'd.m.Y H:i:s' ),
				admin_url( 'post.php?post=' . $post_id . '&action=edit' )
			)
		);
	}

	wp_safe_redirect( motorcycle_shop_thank_you_url() );
	exit;
}

/**
 * Allow programmatic lead creation from the public form handler.
 *
 * @param array   $allcaps All capabilities.
 * @param array   $caps    Required caps.
 * @param array   $args    Args.
 * @param WP_User $user    User.
 * @return array
 */
function motorcycle_shop_lead_insert_caps( $allcaps, $caps, $args, $user ) {
	if ( empty( $GLOBALS['motorcycle_shop_submitting_lead'] ) ) {
		return $allcaps;
	}

	$allcaps['edit_posts']    = true;
	$allcaps['publish_posts'] = true;

	return $allcaps;
}
add_filter( 'user_has_cap', 'motorcycle_shop_lead_insert_caps', 10, 4 );

/**
 * Admin list columns for leads.
 *
 * @param array $columns Columns.
 * @return array
 */
function motorcycle_shop_lead_columns( $columns ) {
	$new = array();

	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;

		if ( 'title' === $key ) {
			$new['lead_phone']  = 'Телефон';
			$new['lead_source'] = 'Источник';
		}
	}

	return $new;
}
add_filter( 'manage_ms_lead_posts_columns', 'motorcycle_shop_lead_columns' );

/**
 * @param string $column Column key.
 * @param int    $post_id Post ID.
 */
function motorcycle_shop_lead_column_content( $column, $post_id ) {
	if ( 'lead_phone' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_lead_phone', true ) );
	}

	if ( 'lead_source' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_lead_source', true ) );
	}
}
add_action( 'manage_ms_lead_posts_custom_column', 'motorcycle_shop_lead_column_content', 10, 2 );

/**
 * Set proper email headers for Gmail compatibility.
 */
function motorcycle_shop_set_email_headers( $headers ) {
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$headers = array(
		'From' => 'Мотолавка <noreply@' . $host . '>',
		'Content-Type' => 'text/plain; charset=UTF-8',
	);
	return $headers;
}
add_filter( 'wp_mail_headers', 'motorcycle_shop_set_email_headers' );

/**
 * Set proper "From" email address for Gmail compatibility.
 */
function motorcycle_shop_set_email_from( $from_email ) {
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	return 'noreply@' . $host;
}
add_filter( 'wp_mail_from', 'motorcycle_shop_set_email_from' );

/**
 * Set proper "From" name for Gmail compatibility.
 */
function motorcycle_shop_set_email_from_name( $from_name ) {
	return 'Мотолавка';
}
add_filter( 'wp_mail_from_name', 'motorcycle_shop_set_email_from_name' );

/**
 * Handle contact page form submission (direct POST, no modal).
 */
function motorcycle_shop_handle_contact_form_submission() {
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) ) {
		return;
	}

	if ( empty( $_POST['contact_source'] ) || 'contact-page' !== $_POST['contact_source'] ) {
		return;
	}

	$nonce = isset( $_POST['contact_nonce'] ) ? wp_unslash( $_POST['contact_nonce'] ) : '';

	if ( ! is_string( $nonce ) || ! wp_verify_nonce( $nonce, 'motorcycle_shop_contact_form' ) ) {
		motorcycle_shop_contact_error_redirect( 'invalid' );
	}

	$name   = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
	$phone  = isset( $_POST['contact_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) ) : '';
	$agree  = ! empty( $_POST['contact_privacy'] );

	if ( ! $agree ) {
		motorcycle_shop_contact_error_redirect( 'privacy' );
	}

	if ( strlen( $name ) < 2 ) {
		motorcycle_shop_contact_error_redirect( 'name' );
	}

	if ( ! motorcycle_shop_is_valid_phone_by_format( $phone ) ) {
		motorcycle_shop_contact_error_redirect( 'phone' );
	}


	// Save to database as lead
	$title = sprintf(
		'%s — %s',
		$name,
		trim( $phone )
	);

	$author_id = 1;
	$admins    = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
		)
	);

	if ( ! empty( $admins ) ) {
		$author_id = (int) $admins[0]->ID;
	}

	$GLOBALS['motorcycle_shop_submitting_lead'] = true;
	$previous_user_id                           = get_current_user_id();
	wp_set_current_user( $author_id );

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'ms_lead',
			'post_title'  => $title,
			'post_status' => 'publish',
			'post_author' => $author_id,
		),
		true
	);

	unset( $GLOBALS['motorcycle_shop_submitting_lead'] );
	wp_set_current_user( $previous_user_id );

	if ( is_wp_error( $post_id ) ) {
		motorcycle_shop_contact_error_redirect( 'save' );
	}

	update_post_meta( $post_id, '_lead_name', $name );
	update_post_meta( $post_id, '_lead_phone', $phone );
	update_post_meta( $post_id, '_lead_source', 'contact-page' );

	// Send email to admin
	$admin_email = get_option( 'admin_email' );

	if ( $admin_email ) {
		$subject = sprintf( '[Мотолавка] Новая заявка с контактной страницы: %s', $name );
		$message = sprintf(
			"Имя: %s\nТелефон: %s\nИсточник: Контактная страница\n\nIP адрес: %s\nДата: %s",
			$name,
			$phone,
			$_SERVER['REMOTE_ADDR'] ?? 'Неизвестно',
			current_time( 'd.m.Y H:i:s' )
		);

		wp_mail( $admin_email, $subject, $message );
	}

	// Redirect to success page
	$url = remove_query_arg( 'contact_error', wp_get_referer() );
	$url = add_query_arg( 'contact_sent', '1', $url );
	wp_safe_redirect( $url );
	exit;
}
add_action( 'init', 'motorcycle_shop_handle_contact_form_submission', 1 );

/**
 * Redirect back with contact form error.
 *
 * @param string $code Error code.
 */
function motorcycle_shop_contact_error_redirect( $code ) {
	$referer = wp_get_referer() ? wp_get_referer() : home_url( '/contact' );
	$referer = remove_query_arg( 'contact_sent', $referer );
	$url     = add_query_arg( 'contact_error', $code, $referer );
	wp_safe_redirect( $url );
	exit;
}

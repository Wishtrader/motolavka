<?php
/**
 * Cookie consent banner markup.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

$consent           = function_exists( 'motorcycle_shop_get_cookie_consent' ) ? motorcycle_shop_get_cookie_consent() : null;
$is_hidden         = null !== $consent;
$cookie_policy_url = function_exists( 'motorcycle_shop_cookie_policy_url' ) ? motorcycle_shop_cookie_policy_url() : home_url( '/cookie-policy/' );
$ajax_nonce        = wp_create_nonce( 'motorcycle-shop-cookie-consent' );
$ajax_url          = admin_url( 'admin-ajax.php' );
?>

<div
	id="cookie-consent-banner"
	class="fixed inset-x-0 bottom-0 z-[9999] transition-transform duration-300 ease-out <?php echo $is_hidden ? 'translate-y-full pointer-events-none' : 'translate-y-0'; ?>"
	role="dialog"
	aria-label="<?php esc_attr_e( 'Уведомление о файлах cookie', 'motorcycle-shop' ); ?>"
	aria-hidden="<?php echo $is_hidden ? 'true' : 'false'; ?>"
	data-cookie-banner
	data-initial-consent="<?php echo esc_attr( $consent ? $consent : '' ); ?>"
	data-ajax-url="<?php echo esc_url( $ajax_url ); ?>"
	data-ajax-nonce="<?php echo esc_attr( $ajax_nonce ); ?>"
>
	<div class="bg-[#1A1C20] border-y-2 border-[#FF6B00] shadow-[0_-8px_32px_rgba(0,0,0,0.45)]">
		<div class="max-w-[1200px] mx-auto px-4 md:px-0 py-5 md:py-6">
			<div class="flex flex-col md:flex-row md:items-center gap-5 md:gap-8">
				<div class="flex-1 min-w-0">
					<div class="flex flex-wrap items-center gap-2 mb-2">
						<h2 class="text-white text-base md:text-lg font-semibold leading-snug">
							Мы используем файлы cookies
						</h2>
						<svg class="w-6 h-6 text-[#FF6B00] shrink-0" viewBox="0 0 24 24" fill="none" aria-hidden="true">
							<path fill="currentColor" d="M12 2a10 10 0 1 0 10 10c0-.3-.02-.6-.05-.9A6 6 0 0 1 12 2Zm-3.5 7a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Zm7 0a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5ZM8.5 14.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Zm7 0a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/>
						</svg>
					</div>
					<p class="text-[#B8C0CC] text-sm leading-relaxed">
						Этот сайт применяет файлы cookies для корректной работы, анализа использования и улучшения качества сервиса. Вы можете принять все файлы cookies или ограничиться только необходимыми.
						<a href="<?php echo esc_url( $cookie_policy_url ); ?>" class="text-[#FB8A3C] hover:text-[#FF6B00] transition-colors underline underline-offset-2 whitespace-nowrap">
							Политика обработки файлов cookie
						</a>
					</p>
				</div>

				<div class="flex flex-col gap-3 w-full md:w-[200px] shrink-0">
					<button
						type="button"
						class="flex w-full min-h-[48px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold hover:bg-[#E55A00] transition-colors"
						data-cookie-accept
					>
						Принять
					</button>
					<button
						type="button"
						class="flex w-full min-h-[48px] items-center justify-center rounded-[2px] bg-[#2A3038] text-white text-base font-semibold border border-[#434C58] hover:bg-[#1F242B] transition-colors"
						data-cookie-decline
					>
						Отклонить
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	(function () {
		try {
			var key = 'motorcycle_shop_cookie_consent';
			var cookieName = key + '=';
			var hasCookie = document.cookie.split( ';' ).some( function ( part ) {
				return part.trim().indexOf( cookieName ) === 0;
			} );
			var banner = document.getElementById( 'cookie-consent-banner' );

			if ( ! hasCookie ) {
				localStorage.removeItem( key );
				return;
			}

			var stored = localStorage.getItem( key );
			if ( banner && ( stored === 'accepted' || stored === 'declined' ) ) {
				banner.classList.add( 'translate-y-full', 'pointer-events-none' );
				banner.setAttribute( 'aria-hidden', 'true' );
			}
		} catch ( e ) {}
	})();
</script>

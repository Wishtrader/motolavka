<?php
/**
 * Template Name: Thank You
 * Thank-you page after checkout or lead form submission.
 *
 * @package motorcycle-shop
 */

get_header();

$theme_uri   = get_template_directory_uri();
$catalog_url = motorcycle_shop_page_url( 'catalog.php', 'catalog' );
$bg_url      = $theme_uri . '/img/thank-you-bg.png';

$order_id = isset( $_GET['order_id'] ) ? absint( $_GET['order_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$order_key = isset( $_GET['key'] ) ? wc_clean( wp_unslash( $_GET['key'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$order     = null;

if ( $order_id && $order_key && function_exists( 'wc_get_order' ) ) {
	$maybe_order = wc_get_order( $order_id );
	if ( $maybe_order && hash_equals( $maybe_order->get_order_key(), $order_key ) ) {
		$order = $maybe_order;
	}
}

$title = $order
	? sprintf( 'Заказ отправлен', $order->get_order_number() )
	: 'Заказ отправлен';

$message = $order
	? 'Спасибо! Ваша заявка принята. Менеджер свяжется с вами в рабочее время для подтверждения заказа.'
	: 'Спасибо! Ваша заявка принята. Менеджер свяжется с вами в рабочее время для подтверждения заказа.';
?>

<section class="relative min-h-[calc(100vh-80px)] flex items-center overflow-hidden">
	<div class="absolute inset-0 bg-[url('<?php echo esc_url( $bg_url ); ?>')] bg-cover bg-center bg-no-repeat"></div>
	<div class="absolute inset-0 bg-black/55"></div>

	<div class="relative w-full max-w-[1200px] mx-auto fluid-px py-[140px] md:py-[160px]">
		<div class="max-w-[720px] mx-auto text-center">
			<h1 class="text-white text-[32px] md:text-[48px] font-bold leading-tight mb-6">
				<?php echo esc_html( $title ); ?>
			</h1>
			<p class="text-white text-base md:text-lg leading-relaxed mb-10 md:mb-12 max-w-[600px] mx-auto">
				<?php echo esc_html( $message ); ?>
			</p>
			<a
				href="<?php echo esc_url( $catalog_url ); ?>"
				class="inline-flex items-center justify-center min-w-[337px] h-[52px] bg-[#FF6B00] text-white px-8 py-4 rounded-[2px] text-base font-semibold hover:bg-[#E55A00] transition-colors"
			>
				Вернуться в каталог
			</a>
		</div>
	</div>
</section>

<?php
get_footer();

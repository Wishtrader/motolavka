<?php
/**
 * Template Name: Thank You
 * Thank-you page after lead form submission.
 *
 * @package motorcycle-shop
 */

get_header();

$theme_uri    = get_template_directory_uri();
$catalog_url  = motorcycle_shop_page_url( 'catalog.php', 'catalog' );
$bg_url       = $theme_uri . '/img/thank-you-bg.png';
?>

<section class="relative min-h-[calc(100vh-80px)] flex items-center overflow-hidden">
	<div class="absolute inset-0 bg-[url('<?php echo esc_url( $bg_url ); ?>')] bg-cover bg-center bg-no-repeat"></div>
	<div class="absolute inset-0 bg-black/55"></div>

	<div class="relative w-full max-w-[1200px] mx-auto px-[10px] md:px-0 py-[140px] md:py-[160px]">
		<div class="max-w-[720px] mx-auto text-center">
			<h1 class="text-white text-[32px] md:text-[48px] font-bold leading-tight mb-6">
				Заказ отправлен
			</h1>
			<p class="text-white text-base md:text-lg leading-relaxed mb-10 md:mb-12 max-w-[600px] mx-auto">
				Спасибо! Ваша заявка принята. Менеджер свяжется с вами в рабочее время для подтверждения заказа.
			</p>
			<a
				href="<?php echo esc_url( $catalog_url ); ?>"
				class="inline-flex items-center justify-center min-w-[280px] bg-[#FF6B00] text-white px-8 py-4 rounded-[2px] text-base font-semibold hover:bg-[#E55A00] transition-colors"
			>
				Вернуться в каталог
			</a>
		</div>
	</div>
</section>

<?php
get_footer();

<?php
/**
 * Empty cart page.
 *
 * @package motorcycle-shop
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_cart_is_empty' );
?>

<div class="w-full px-[10px] md:px-0 pt-[110px] md:pt-[130px] pb-16">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex flex-wrap items-center gap-2 text-sm mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
			<svg class="w-4 h-4 text-[#FB8A3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
			</svg>
			<span class="text-white">Корзина</span>
		</nav>

		<h1 class="text-white text-[32px] md:text-[40px] font-bold mb-8">Корзина</h1>

		<div class="bg-[#2A3038] border border-[#434C58] rounded-[2px] p-8 md:p-12 text-center max-w-[640px]">
			<p class="text-white text-xl font-bold mb-3">Ваша корзина пуста</p>
			<p class="text-[#B8C0CC] text-base mb-8">Добавьте товары из каталога, чтобы оформить заказ.</p>
			<a
				href="<?php echo esc_url( motorcycle_shop_page_url( 'catalog.php', 'catalog' ) ); ?>"
				class="inline-flex items-center justify-center min-h-[52px] px-8 pb-4 rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold text-center leading-none whitespace-nowrap hover:bg-[#E55A00] transition-colors"
			>
				<?php esc_html_e( 'Перейти в каталог', 'motorcycle-shop' ); ?>
			</a>
		</div>
	</div>
</div>

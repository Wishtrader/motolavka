<?php

/**
 * Empty cart page.
 *
 * @package motorcycle-shop
 * @version 7.0.1
 */

defined('ABSPATH') || exit();

do_action('woocommerce_cart_is_empty');
?>

<div class="w-full fluid-px pt-[110px] md:pt-[130px] pb-[102px]">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex items-center gap-2 text-[13px] mb-[60px] lg:mt-[80px] md:mt-[50px]" aria-label="<?php esc_attr_e(
    		'Breadcrumb',
    		'motorcycle-shop',
		); ?>">
			<a href="<?php echo
    			esc_url(home_url('/'))
			; ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
			<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
			<span class="text-white lg:ml-2">Корзина</span>
		</nav>

		<div class="mx-auto text-center max-w-[348px] mt-[108px]">
			<div class="flex items-center justify-center w-[100px] h-[100px] bg-[#FB8A3C] rounded-full mx-auto mb-3">
				<img src="<?php echo get_template_directory_uri(); ?>/img/cart.svg" alt='cart' class="w-9 h-8" />
			</div>
			<h1 class="text-white text-2xl lg:text-[32px] font-normal mb-3">Ваша корзина пуста</h1>
			<p class="text-[#B8C0CC] text-lg mb-4">Добавьте товары из каталога, чтобы оформить заказ.</p>
			<a
				href="<?php echo esc_url(motorcycle_shop_page_url('catalog.php', 'catalog')); ?>"
				class="inline-flex items-center justify-center min-h-[52px] min-w-[338px] px-8 rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold text-center leading-none whitespace-nowrap hover:bg-[#E55A00] transition-colors"
			>
				<?php esc_html_e('Вернуться в каталог', 'motorcycle-shop'); ?>
			</a>
		</div>
	</div>
</div>

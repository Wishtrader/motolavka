<?php
/**
 * No products found in category.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="bg-[#2A3038] border border-[#434C58] rounded-[2px] p-8 md:p-12 text-center">
	<p class="text-white text-xl font-bold mb-3">В этой категории пока нет товаров</p>
	<p class="text-[#B8C0CC] text-base mb-8">Скоро здесь появятся новые позиции. А пока посмотрите другие категории или оставьте заявку.</p>
	<a
		href="<?php echo esc_url( motorcycle_shop_page_url( 'catalog.php', 'catalog' ) ); ?>"
		class="inline-flex items-center justify-center rounded-[2px] bg-[#FF6B00] text-white px-8 py-4 text-base font-semibold hover:bg-[#E55A00] transition-colors"
	>
		Перейти в каталог
	</a>
</div>

<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package motorcycle-shop
 */

get_header();
?>

<section class="relative bg-[#171A1F] pt-[180px] pb-[70px] overflow-hidden">
	<img class="mx-auto" src="<?php echo get_template_directory_uri(); ?>/img/404-bg.png" alt="404" />
	<div class="flex max-w-[670px] mx-auto text-white mt-[50px] items-center flex-col">
		<h3 class="text-lg font-semibold leading-[1.35]">Страница не найдена</h3>
		<p class="text-white text-md text-center text-base my-[20px]">К сожалению, запрашиваемая страница недоступна. <br>
Возможно, страница была удалена, ссылка устарела или адрес указан с ошибкой.</p>
			<a href="<?php echo
    			esc_url(motorcycle_shop_page_url('/', 'home'))
			; ?>" class="flex w-full flex-1 lg:max-w-[380px] max-h-[52px] items-center justify-center rounded-[2px] bg-[#F97316] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#111317] transition-colors border border-[#434C58]">
			Вернуться на главную
		</a>
	</div>
	
</section>

<?php

get_footer();

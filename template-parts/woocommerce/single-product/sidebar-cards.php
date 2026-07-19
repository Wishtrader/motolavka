<?php
/**
 * Sidebar cards — payment & service.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

$shipping_url = motorcycle_shop_get_page_url_by_template( 'shipping.php' );
$service_url  = motorcycle_shop_get_page_url_by_template( 'service.php' );
?>

<aside class="flex flex-col gap-5 lg:gap-7 max-w-[488px] lg:mt-16">
	<div class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-[10px] md:p-6 md:py-[20px] md:px-[30px]">
		<h3 class="text-white text-lg md:text-2xl font-nirmal mb-4">Оплата и доставка</h3>
		<p class="text-white text-sm md:text-lg !leading-[1.6] mb-5">
			Актуальную цену, наличие и удобный способ получения подтверждаем перед оформлением. Доставка по Беларуси обсуждается с клиентом индивидуально.
		</p>
		<ul class="space-y-2 text-[#F5F7FA] text-sm md:text-lg">
			<li class="flex items-center gap-6 p-[10px] bg-[#1F242B] border border-[#434C58] rounded-[2px]">
				<span class="w-[13px] h-[13px] rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Самовывоз из салона</span>
			</li>
			<li class="flex items-center gap-6 p-[10px] bg-[#1F242B] border border-[#434C58] rounded-[2px]">
				<span class="w-[13px] h-[13px] rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Доставка по Минску и РБ</span>
			</li>
			<li class="flex items-center gap-6 p-[10px] bg-[#1F242B] border border-[#434C58] rounded-[2px]">
				<span class="w-[13px] h-[13px] rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Наличный и безналичный расчёт</span>
			</li>
		</ul>
	</div>

	<div class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-[10px] md:p-6 md:py-[20px] md:pl-[30px]">
		<h3 class="text-white text-lg md:text-2xl font-normal mb-4">Сервис</h3>
		<p class="text-white text-sm md:text-lg !leading-[1.6] mb-5">
			При необходимости подскажем по обслуживанию, расходникам и подбору запчастей под эту модель. Собственный сервис для диагностики и ТО.
		</p>
		<?php
		motorcycle_shop_lead_modal_trigger(
			array(
				'source' => 'product',
				'class'  => 'flex w-full min-h-[48px] items-center justify-center rounded-[2px] text-[#F5F7FA] text-sm rounded-[2px] font-normal border border-[#434C58] hover:bg-[#111317] transition-colors',
			)
		);
		?>
		<a href="<?php echo esc_url( $service_url ); ?>" class="sr-only"><?php esc_html_e( 'Сервис', 'motorcycle-shop' ); ?></a>
	</div>
</aside>

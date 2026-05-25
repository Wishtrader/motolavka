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

<aside class="flex flex-col gap-5 lg:gap-6">
	<div class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8">
		<h3 class="text-white text-lg md:text-xl font-bold mb-4">Оплата и доставка</h3>
		<p class="text-[#B8C0CC] text-sm md:text-base leading-relaxed mb-5">
			Подберём удобный способ получения заказа и расскажем об условиях оплаты до оформления покупки.
		</p>
		<ul class="space-y-3 text-[#F5F7FA] text-sm md:text-base">
			<li class="flex items-start gap-3">
				<span class="mt-2 w-2 h-2 rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Самовывоз из магазина</span>
			</li>
			<li class="flex items-start gap-3">
				<span class="mt-2 w-2 h-2 rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Доставка по Минску и Беларуси</span>
			</li>
			<li class="flex items-start gap-3">
				<span class="mt-2 w-2 h-2 rounded-full bg-[#FF6B00] shrink-0"></span>
				<span>Оплата наличными и безналичным расчётом</span>
			</li>
		</ul>
		<a href="<?php echo esc_url( $shipping_url ); ?>" class="inline-block mt-6 text-[#FF6B00] text-sm font-semibold hover:text-[#FB8A3C] transition-colors">
			Подробнее о доставке
		</a>
	</div>

	<div class="bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8">
		<h3 class="text-white text-lg md:text-xl font-bold mb-4">Сервис</h3>
		<p class="text-[#B8C0CC] text-sm md:text-base leading-relaxed mb-6">
			Техническое обслуживание, подбор запчастей и консультации по эксплуатации мототехники.
		</p>
		<?php
		motorcycle_shop_lead_modal_trigger(
			array(
				'source' => 'product',
				'class'  => 'flex w-full min-h-[48px] items-center justify-center rounded-[2px] bg-[#1F242B] text-white text-base font-semibold border border-[#434C58] hover:bg-[#111317] transition-colors',
			)
		);
		?>
		<a href="<?php echo esc_url( $service_url ); ?>" class="sr-only"><?php esc_html_e( 'Сервис', 'motorcycle-shop' ); ?></a>
	</div>
</aside>

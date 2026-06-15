
<section id="form" class="relative w-full py-10">
	<div class="absolute inset-0 bg-[url('<?php echo esc_url( get_template_directory_uri() . '/img/moto3.png' ); ?>')] bg-center"></div>

	<div class="flex flex-col lg:flex-row max-w-[1200px] mx-auto gap-[20px] relative fluid-px">
		<div class="flex flex-col flex-1">
			<h2 class="fluid-h2 max-w-[560px] text-white font-bold leading-[1.15]">
				<?php echo esc_html( get_field( 'form_heading', get_option( 'page_on_front' ) ) ); ?>
			</h2>
			<p class="text-[#F5F7FA] max-w-[800px] mt-[20px] fluid-body leading-relaxed font-normal">
				
				<?php echo esc_html( get_field( 'form_description', get_option( 'page_on_front' ) ) ); ?>
			</p>
			<a href="<?php echo esc_url( motorcycle_shop_page_url( 'catalog.php', 'catalog' ) ); ?>" class="flex w-full flex-1 lg:max-w-[285px] max-h-[52px] mt-[50px] items-center justify-center rounded-[2px] bg-[#2A3038] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#111317] transition-colors border border-[#434C58]">
				Перейти в каталог
			</a>
		</div>
		<?php motorcycle_shop_render_inline_lead_form( 'service-form' ); ?>
	</div>
</section>

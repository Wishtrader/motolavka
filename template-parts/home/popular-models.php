<section id="popular-models" class="w-full py-10 fluid-px">
  <div class="flex flex-col lg:flex-row w-full justify-between max-w-[1200px] mx-auto gap-[20px]">
    <div>
      <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15] fluid-mb">
        Популярные модели
     </h2>
      <p class="text-[#F5F7FA] max-w-[800px] fluid-body leading-relaxed font-normal">
         Подборка техники, на которую чаще всего обращают внимание наши клиенты.
      </p>
    </div>
    <div class="flex items-center gap-[10px] md:justify-end">
      <a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="text-white leading-none hover:text-[#F97316] text-[16px] font-semibold">Смотреть все модели</a>
      <img src="<?php echo get_template_directory_uri(); ?>/img/arrow-forward.svg" alt="arrow" />
    </div>
  </div>
  <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[20px] w-full max-w-[1200px] mx-auto mt-[40px]">
    <div class="bg-[#2A3038] overflow-hidden">
      <img src="<?php echo get_template_directory_uri(); ?>/img/moto.png" alt="moto" class="w-full hover:scale-110 duration-300" />
      <div class="flex flex-col p-[10px] md:p-5">
        <h4 class="text-white text-[20px] md:text-2xl">Racer Sport RC250</h4>
        <div class="flex mt-[10px] mb-[30px] gap-[10px]">
          <span class='px-[8px] py-[2px] text-[#B8C0CC] text-[13px] bg-[#1F242B]'>250 см³</span>
          <span class='px-[8px] py-[2px] text-[#B8C0CC] text-[13px] bg-[#1F242B]'>4-тактный</span>
          <span class='px-[8px] py-[2px] text-[#B8C0CC] text-[13px] bg-[#1F242B]'>Электростартер</span>
        </div>
<?php
$product_title = 'Racer Sport RC250';
$popular_product = null;

if ( class_exists( 'WC_Product' ) ) {
	$popular_products = get_posts(
		array(
			'post_type'      => 'product',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
			'title'          => $product_title,
			'suppress_filters' => false,
		)
	);

	if ( ! empty( $popular_products ) ) {
		$popular_product = wc_get_product( $popular_products[0]->ID );
	}
}

$product_url = $popular_product ? get_permalink( $popular_product->get_id() ) : '#';
?>

        <div class="flex flex-col lg:flex-row w-full items-center justify-between gap-[30px]">
          <h4 class="text-white text-left w-full text-[24px] lg:text-2xl font-semibolt">7 890<span class="text-base text-[#B8C0CC]"> BYN</span></h4>
          <a href="<?php echo esc_url( $product_url ); ?>" class="flex w-full flex-1 lg:min-w-[210px] items-center justify-center rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[10px] text-base font-semibold hover:bg-[#E55A00] transition-colors">
            Подробнее	
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

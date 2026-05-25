<section id="credit" class="w-full py-10 px-[10px] md:px-0">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="text-[28px] md:text-[40px] max-w-[530px] text-white font-bold leading-[1.15]">
      Рассматриваете покупку в кредит?
   </h2>
    <p class="text-[#F5F7FA] max-w-[700px] text-[16px] md:text-[18px] leading-relaxed font-normal">
      Если вас интересует оформление в кредит, свяжитесь с нами — подскажем по доступным условиям и поможем уточнить детали по выбранной модели.
    </p>
    <div class="flex flex-col w-full justify-between items-start md:flex-row">
      <div class='flex flex-col max-w-[590px] gap-[20px] mt-[30px] w-full'>
        <div class='flex items-center w-full bg-[#2A3038] px-[20px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-lg font-semibold'>Подскажем по доступным вариантам</p>
        </div>

        <div class='flex items-center w-full bg-[#2A3038] px-[20px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-lg font-semibold'>Поможем с выбором модели</p>
        </div>


        <div class='flex items-center w-full bg-[#2A3038] px-[20px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-lg font-semibold'>Уточним условия перед оформлением</p>
        </div>

        <?php
        motorcycle_shop_lead_modal_trigger(
          array(
            'text'   => 'Узнать подробности',
            'source' => 'credit',
            'class'  => 'flex flex-1 items-center justify-center md:max-w-[285px] mt-[20px] rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors',
          )
        );
        ?>
      </div>
      <div class="flex flex-col w-full max-w-[387px] md:px-[73px] p-[40px] bg-[#2A3038] md:-mt-[80px] mt-[20px]">
        <img src="<?php echo get_template_directory_uri(); ?>/img/credit-icon.svg" alt="credit" class="max-w-[72px] mb-[30px]" />
        <h4 class="text-white text-xl font-semibold mb-[30px]">Кредит</h4>
        <p class="text-white text-base font-normal">Условия покупки уточняются по выбранной модели. Свяжитесь с нами, чтобы узнать детали.</p>
      </div>
    </div>
  </div>
</section>

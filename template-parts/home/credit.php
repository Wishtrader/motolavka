<section id="credit" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="fluid-h2 max-w-[530px] text-white font-bold leading-[1.15]">
    <?php the_field('credit_heading') ?> 
   </h2>
    <p class="text-[#F5F7FA] max-w-[700px] fluid-body leading-relaxed font-normal">
      <?php the_field('credit_title') ?>
    </p>
    <div class="flex flex-col w-full justify-between items-start lg:flex-row">
      <div class='flex flex-col max-w-[590px] gap-[20px] mt-[30px] w-full'>
        <div class='flex items-center w-full bg-[#2A3038] md:px-[20px] px-[10px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-base font-regular'><?php the_field('bullet_1') ?></p>
        </div>

        <div class='flex items-center w-full bg-[#2A3038] md:px-[20px] px-[10px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-base font-regular'><?php the_field('bullet_2') ?></p>
        </div>


        <div class='flex items-center w-full bg-[#2A3038] md:px-[20px] px-[10px] py-[27px] gap-[20px]'>
          <div class='h-[13px] w-[13px] bg-[#D95F0E] rounded-[13px]'></div>
          <p class='text-white text-base font-regular leading-[1.2]'><?php the_field('bullet_3') ?></p>
        </div>

        <?php
        motorcycle_shop_lead_modal_trigger(
          array(
            'text'   => 'Узнать подробности',
            'source' => 'credit',
            'class'  => 'flex flex-1 items-center justify-center lg:max-w-[285px] mt-[20px] rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors',
          )
        );
        ?>
      </div>
      <div class="flex flex-col w-full max-w-[387px] md:px-[73px] md:p-[40px] p-[10px] bg-[#2A3038] lg:-mt-[80px] mt-[20px]">
        <img src="<?php the_field('credit_icon') ?>" alt="credit" class="max-w-[47px] md:max-w-[73px] mb-[20px] md:mb-[30px]" />
        <h4 class="text-white text-xl font-semibold md:mb-[30px] mb-[10px]"><?php the_field('credit_heading2') ?></h4>
        <p class="text-white text-base font-normal"><?php the_field('credit_description2') ?></p>
      </div>
    </div>
  </div>
</section>

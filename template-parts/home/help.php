
<section id="help" class="w-full py-10 relative">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php echo get_template_directory_uri(); ?>/img/moto2.png')] bg-cover md:bg-contain bg-no-repeat bg-center md:bg-right"></div>

  <div class="flex flex-col lg:flex-row max-w-[1200px] w-full mx-auto justify-between gap-[40px] md:gap-[100px] relative fluid-px">
    <div class="flex flex-1 flex-col gap-[20px] max-w-[550px]">
    <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15]">
      <?php the_field('main-support_heading') ?></h2>
      <p class="text-[#F5F7FA] max-w-[800px] fluid-body leading-relaxed font-normal">
        <?php the_field('main-support_description') ?>
      </p>
    </div>
    <div class='flex flex-1 flex-col gap-[20px]'>
      <div class='flex items-start bg-[#2A3038]/80 p-[10px] md:px-[37px] md:py-[40px] w-full gap-[20px] md:gap-[50px] border-[1px] border-[#434C58]'>
        <img src="<?php the_field('support-pay_icon') ?>" alt='wallet' class='md:max-w-[60px] max-w-[30px] md:max-h-[52px] w-full' />
        <div class='w-full'>
          <h3 class='text-white text-[24px] md:text-3xl'>
            <?php the_field('support-pay_heading') ?>
          </h3>
          <div class='bg-[#434C58] my-[10px] md:my-[20px] h-[1px]'></div>
          <p class='text-white text-base font-normal'>
            <?php the_field('support-pay_description') ?>
          </p>
        </div>
      </div>
      <div class='flex flex-1'>
        <div class='flex items-start bg-[#2A3038]/80 p-[10px] md:px-[37px] md:py-[40px] w-full gap-[20px] md:gap-[50px] border-[1px] border-[#434C58]'>
          <img src="<?php the_field('support-delivery_icon') ?>" alt='track' class='max-w-[35px] md:max-w-[70px] max-h-[52px] w-full' />
          <div class='w-full'>
            <h3 class='text-white text-[24px] md:text-3xl'>
              <?php the_field('support-delivery_heading') ?>
            </h3>
            <div class='bg-[#434C58] my-[10px] md:my-[20px] h-[1px]'></div>
            <p class='text-white text-base font-normal'>
              <?php the_field('support-delivery_description') ?>
            </p>
          </div>
        </div>
      <div>
    <div>
  </div>
</section>

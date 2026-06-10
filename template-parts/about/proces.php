<section id="popular-cat" class="w-fullform py-10 px-[10px] md:px-0">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <div class="flex flex-col md:flex-row w-full justify-between max-w-[1200px] mx-auto gap-[20px]">
    <div>
      <h2 class="text-[28px] md:text-[40px] max-w-[800px] text-white font-bold leading-[1.15] mb-[20px]">
        <?php the_field('about-process_heading') ?>
    </h2>
      <p class="text-[#B8C0CC] max-w-[800px] text-[16px] md:text-[18px] leading-[1.6] font-normal">
        <?php the_field('about-process_description') ?>
      </p>
    </div>
  </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mt-[40px] mb-[40px]">    
    <div class="flex w-full flex-col gap-[20px]">
      <div class="flex">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">01</h1>
        <img class="hidden md:block max-w-[230px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
      </div>
      <p class="text-lg font-semibold text-white">
				<?php the_field('about-step1_heading') ?>
			</p>
      <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
      <p class="text-sm font-normal text-white">
				<?php the_field('about-step1_description') ?>
			</p>
    </div>

      <div class="flex w-full flex-1 flex-col gap-[20px]">
        <div class="flex">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">02</h1>
          <img class="hidden md:block max-w-[220px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step2_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white">
					<?php the_field('about-step2_description') ?>
				</p>
      </div>

      <div class="flex w-full flex-1 flex-col gap-[20px]">
        <div class="flex">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">03</h1>
          <img class="hidden md:block max-w-[220px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step3_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white">
					<?php the_field('about-step3_description') ?>
				</p>
      </div>

      <div class="flex w-full flex-1 flex-col gap-[20px]">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">04</h1>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step4_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white">
					<?php the_field('about-step4_description') ?>
				</p>
      </div>

  </div>
</section>

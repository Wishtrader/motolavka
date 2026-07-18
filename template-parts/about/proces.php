<section id="popular-cat" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <div class="flex flex-col lg:flex-row w-full justify-between max-w-[1200px] mx-auto gap-[20px]">
    <div>
      <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15] mb-[20px]">
        <?php the_field('about-process_heading') ?>
    </h2>
      <p class="text-[#B8C0CC] max-w-[800px] fluid-body leading-[1.6] font-normal">
        <?php the_field('about-process_description') ?>
      </p>
    </div>
  </div>

    <div class="flex md:grid overflow-x-auto md:overflow-visible snap-x snap-mandatory gap-5 mt-[40px] mb-[40px] md:grid-cols-4">
    <div class="proces-item snap-start flex flex-col gap-[10px]">
      <div class="flex items-center">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4 shrink-0">01</h1>
        <img class="lg:block flex-1 min-w-0 w-full h-auto max-w-[180px] md:max-w-[220px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
      </div>
      <p class="text-lg font-semibold text-white">
				<?php the_field('about-step1_heading') ?>
			</p>
      <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
      <p class="text-[14px] font-normal text-white">
				<?php the_field('about-step1_description') ?>
			</p>
    </div>

      <div class="proces-item snap-start flex flex-col gap-[10px]">
        <div class="flex items-center">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4 shrink-0">02</h1>
          <img class="lg:block flex-1 min-w-0 w-full h-auto max-w-[180px] md:max-w-[210px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step2_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white max-w-[225px]">
					<?php the_field('about-step2_description') ?>
				</p>
      </div>

      <div class="proces-item snap-start flex flex-col gap-[10px]">
        <div class="flex items-center">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4 shrink-0">03</h1>
          <img class="lg:block flex-1 min-w-0 w-full h-auto max-w-[180px] md:max-w-[200px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step3_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white max-w-[225px]">
					<?php the_field('about-step3_description') ?>
				</p>
      </div>

      <div class="proces-item snap-start flex flex-col gap-[10px]">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">04</h1>
        <p class="text-lg font-semibold text-white">
					<?php the_field('about-step4_heading') ?>
				</p>
        <div class="border-b-[#D95F0E]/50 border-b-[0.15px] w-full max-w-[193px]"></div>
        <p class="text-sm font-normal text-white max-w-[225px]">
					<?php the_field('about-step4_description') ?>
				</p>
      </div>

  </div>
</section>

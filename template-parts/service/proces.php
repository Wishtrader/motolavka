<section id="popular-cat" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <div class="flex flex-col lg:flex-row w-full justify-between max-w-[1200px] mx-auto gap-[20px]">
    <div>
      <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15] mb-[20px]">
        <?php the_field('sec4-heading') ?>
    </h2>
    </div>
  </div>

    <div class="flex md:grid overflow-x-auto md:overflow-visible snap-x snap-mandatory gap-5 mt-[40px] mb-[40px] md:grid-cols-4">
    <div class="proces-item snap-start flex flex-col gap-[20px]">
      <div class="flex">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">01</h1>
        <img class="lg:block max-w-[180px] md:max-w-[230px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
      </div>
      <p class="text-lg font-semibold text-white"><?php the_field('sec4-title1') ?></p>
    </div>

      <div class="proces-item snap-start flex flex-col gap-[20px]">
        <div class="flex">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">02</h1>
          <img class="lg:block max-w-[180px] md:max-w-[230px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white"><?php the_field('sec4-title2') ?></p>
      </div>

      <div class="proces-item snap-start flex flex-col gap-[20px]">
        <div class="flex">
          <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">03</h1>
          <img class="lg:block max-w-[180px] md:max-w-[230px]" src="<?php echo get_template_directory_uri(); ?>/img/line.svg" alt="line" />
        </div>
        <p class="text-lg font-semibold text-white"><?php the_field('sec4-title3') ?></p>
      </div>

      <div class="proces-item snap-start flex flex-col gap-[20px]">
        <h1 class="text-[52px] text-[#D95F0E]/30 font-bold mr-4">04</h1>
        <p class="text-lg font-semibold text-white"><?php the_field('sec4-title4') ?></p>
      </div>

  </div>
</section>

<?php
$cards = [
  ['img' => get_field('service-card1_icon'), 'title' => get_field('service-card1_heading'), 'description' => get_field('service-card1_description')],
  ['img' => get_field('service-card2_icon'), 'title' => get_field('service-card2_heading'), 'description' => get_field('service-card2_description')],
  ['img' => get_field('service-card3_icon'), 'title' => get_field('service-card3_heading'), 'description' => get_field('service-card3_description')],
  ['img' => get_field('service-card4_icon'), 'title' => get_field('service-card4_heading'), 'description' => get_field('service-card4_description')],
];
?>

<section id="full-services" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15]">
      <?php the_field('heading') ?>
    </h2>

    <p class="text-[#F5F7FA] max-w-[800px] fluid-body leading-relaxed font-normal">
    <?php the_field('description') ?>
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[20px] mt-10">
      <?php foreach ($cards as $card) :
        $img = htmlspecialchars($card['img'], ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($card['title'], ENT_QUOTES, 'UTF-8');
        $desc = htmlspecialchars($card['description'], ENT_QUOTES, 'UTF-8');
      ?>
        <div
          class="transform transition duration-200 ease-[cubic-bezier(0.22,1,0.36,1)] will-change-transform
                bg-[#2A3038] text-white flex flex-col fluid-card-px fluid-card-py
                hover:-translate-y-[10px] hover:shadow-[0_12px_30px_rgba(0,0,0,0.45)]
                hover:bg-gradient-to-b hover:from-[#38424A] hover:to-[#2E3A41] hover:text-[#E6F0FF]
                focus:outline-none focus-visible:ring-2 focus-visible:ring-[#6B7280]
              ">
          <img src="<?= $img ?>" alt="<?= $title ?>" class="mb-[30px] h-[72px] mr-auto" loading="lazy">
          <h5 class="text-[20px]"><?= $title ?></h5>
          <p class="text-base mt-[20px]"><?= $desc ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
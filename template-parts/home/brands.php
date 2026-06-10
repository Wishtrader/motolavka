
<section id="brands" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15]">
      Бренды, с которыми работаем
   </h2>
    <p class="text-[#F5F7FA] max-w-[800px] fluid-body leading-relaxed font-normal">
      Подбираем технику и комплектующие по проверенным маркам, с которыми удобно работать по наличию, сервису и подбору запчастей.
    </p>
  </div>
  <?php
  $brands = get_terms( array(
    'taxonomy'   => 'product_brand',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC'
  ) );

  if ( ! empty( $brands ) && ! is_wp_error( $brands ) ) :
  ?>
  <div class="grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-[20px] w-full max-w-[1540px] mx-auto mt-[60px]">
    <?php foreach ( $brands as $brand ) :
      $image_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
      $image_url = '';
      if ( $image_id ) {
        $image_url = wp_get_attachment_image_url( $image_id, 'medium' );
        if ( ! $image_url ) {
          $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
        }
        if ( ! $image_url ) {
          $image_url = wp_get_attachment_image_url( $image_id, 'full' );
        }
      }
      if ( ! $image_url ) {
        $image_url = get_template_directory_uri() . '/img/brand-placeholder.png';
      }
      $brand_link = get_term_link( $brand );
    ?>
      <a href="<?php echo esc_url( $brand_link ); ?>" class="block group">
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" class="w-full h-auto object-contain transition-opacity group-hover:opacity-80" loading="lazy" />
      </a>
    <?php endforeach; ?>
  </div>
  <?php else : ?>
    <p class="text-[#F5F7FA] mt-4">Бренды не найдены.</p>
  <?php endif; ?>
</section>

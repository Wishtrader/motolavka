<section id="popular-cat" class="w-fullform py-10 px-[10px] md:px-0">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <div class="flex flex-col md:flex-row w-full justify-between max-w-[1200px] mx-auto gap-[20px] items-start">
    <div>
      <h2 class="text-[28px] md:text-[40px] max-w-[800px] text-white font-bold leading-[1.15] mb-[20px]">
				<?php the_field( 'services-catalog_heading' ); ?>
    </h2>
      <p class="text-[#B8C0CC] max-w-[900px] w-full text-[16px] md:text-[18px] leading-[1.6] font-normal">
        <?php the_field( 'services-catalog_description' ); ?>
      </p>
    </div>
    <div class="flex items-center gap-[10px] md:justify-end mt-5">
      <a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="text-white leading-none hover:text-[#F97316] text[16px] font-semibold">Смотреть каталог</a>
      <img src="<?php echo get_template_directory_uri(); ?>/img/arrow-forward.svg" alt="arrow" />
    </div>
  </div>
    <div class="flex mt-[40px]">
      <?php
				$categories = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'number' => 4,
				) );
				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				?>
				<div class="flex-1">
					<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
						<?php foreach ( $categories as $cat ) :
							$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
							$image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/img/placeholder.png';
						?>
						<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="group relative overflow-hidden block">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" class="w-full h-[210px] object-cover transition-transform duration-300 group-hover:scale-110">
							<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
							<div class="absolute bg-[#2A3038]/80 h-[36px] bottom-0 left-0 right-0 p-4 flex items-center justify-between">
								<span class="text-white text-base font-medium"><?php echo esc_html( $cat->name ); ?></span>
								<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
							</div>
						</a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
    </div>

  </div>
</section>

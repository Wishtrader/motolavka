<section id="popular-cat" class="w-full py-10 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15]">
      Популярные категории
    </h2>

    <p class="text-[#F5F7FA] max-w-[800px] fluid-body leading-relaxed font-normal">
      Основные направления каталога для подбора техники, расходников и экипировки. 
    </p>
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
							<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" class="w-full fluid-card-img object-cover transition-transform duration-300 group-hover:scale-110">
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

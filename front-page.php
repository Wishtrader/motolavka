<?php
/**
 * Front page template (homepage).
 *
 * @package motorcycle-shop
 */

get_header();
?>

<!-- Hero Section -->
<section class="relative bg-black overflow-hidden">
	<div class="relative md:h-screen flex items-center">
		<div class="absolute inset-0 bg-[url('<?php echo esc_url( get_template_directory_uri() . '/img/hero-img.png' ); ?>')] bg-cover bg-right"></div>

		<div class="relative w-full max-w-[1200px] mx-auto mt-[140px] 2xl:mt-0">
			<div class="hidden md:flex items-center gap-[20px]">
				<div class="flex-1">
					<h1 class="text-white sm:text-[34px] md:text-[52px] font-bold mb-[30px] leading-[1.1]">
						<?php the_field('hero_heading') ?>	
					</h1>
					<p class="text-white text-[20px] mb-8 leading-relaxed">
						<?php the_field('hero_subtitle') ?>
					</p>
					<div class="flex gap-[20px] w-full">
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="flex-1 bg-[#FF6B00] text-white text-center px-8 py-4 rounded-[2px] font-medium hover:bg-[#E55A00] transition-colors">
							Смотреть каталог
						</a>
						<button type="button" data-lead-modal-open data-lead-source="hero" class="flex-1 bg-[#2C2C2C] text-center text-white px-8 py-4 rounded-[2px] font-medium hover:bg-[#3C3C3C] transition-colors">
							Оставить заявку
						</button>
					</div>
				</div>

				<?php
				$categories = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => false,
						'number'     => 4,
					)
				);
				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
					?>
				<div class="flex-1">
					<div class="grid grid-cols-2 gap-4">
						<?php foreach ( $categories as $cat ) :
							$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
							$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/img/placeholder.png';
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

			<div class="md:hidden h-full px-[10px] mt-[40px] relative">
				<div class="relative">
					<h1 class="text-white text-[34px] font-bold mb-6 leading-tight">
						Подберите технику<br>и запчасти под<br>свои задачи
					</h1>
					<p class="text-gray-300 text-[20px] mb-8 leading-relaxed">
						Каталог мотоциклов, квадрациклов, скутеров, запчастей и аксессуаров
					</p>
					<div class="space-y-5 mb-10">
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="block bg-[#FF6B00] text-white text-center px-8 py-4 rounded font-medium hover:bg-[#E55A00] transition-colors">
							Смотреть каталог
						</a>
						<button type="button" data-lead-modal-open data-lead-source="hero" class="block w-full bg-[#2C2C2C] text-white text-center px-8 py-4 rounded font-medium hover:bg-[#3C3C3C] transition-colors">
							Оставить заявку
						</button>
					</div>
				</div>

				<?php
				$categories_mobile = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => false,
						'number'     => 4,
					)
				);
				if ( ! empty( $categories_mobile ) && ! is_wp_error( $categories_mobile ) ) :
					?>
				<div class="space-y-4">
					<?php foreach ( $categories_mobile as $cat ) :
						$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
						$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/img/placeholder.png';
						?>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="group relative overflow-hidden rounded-lg block">
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>" class="w-full h-[200px] object-cover transition-transform duration-300 group-hover:scale-110">
						<div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
						<div class="absolute bottom-0 left-0 right-0 p-4 flex items-center justify-between">
							<span class="text-white text-base font-medium"><?php echo esc_html( $cat->name ); ?></span>
							<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/home/full-services', 'full-services' );
get_template_part( 'template-parts/home/popular-cat', 'popular-cat' );
get_template_part( 'template-parts/home/popular-models', 'popular-models' );
get_template_part( 'template-parts/home/credit', 'credit' );
get_template_part( 'template-parts/home/brands', 'brands' );
get_template_part( 'template-parts/home/help', 'help' );
get_template_part( 'template-parts/home/form', 'form' );
get_footer();

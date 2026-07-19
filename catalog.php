<?php
/**
 * Template Name: Catalog
 * Template for catalog page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative bg-black overflow-hidden">
	<div class="relative md:h-[600px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('catalog_hero-bg') ?>')] bg-cover bg-center"></div>
		<div class="absolute inset-0 bg-black/60"></div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full flex items-start md:mt-[140px] fluid-px">
			<div class="flex max-w-[712px] gap-8 w-full items-center">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px] relative z-10">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[50px]">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
						<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
						<span class="text-white lg:ml-2">Каталог</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white fluid-h1 font-bold mb-6 leading-tight w-full">
						<?php the_field('catalog_heading') ?>
					</h1>
					
					<!-- Description -->
					<p class="text-gray-300 fluid-body mb-10 leading-relaxed">
						<?php the_field('catalog_description') ?>
					</p>
					
					<!-- Button -->
					<?php
					motorcycle_shop_lead_modal_trigger(
						array(
							'source' => 'catalog',
							'class'  => 'inline-block flex items-center justify-center bg-[#2A3038] text-white text-center max-h-[48px] px-8 py-4 rounded-[2px] w-full lg:max-w-[285px] font-medium hover:bg-[#3C3C3C] transition-colors border border-[#434C58] border-[1px]',
						)
					);
					?>
				</div>
				
				<!-- Right Image -->
				<div class="hidden md:block absolute right-0 max-w-[30vw]">
					<img src="<?php the_field('catalog_hero-img') ?>" alt="Мотоцикл" class="w-full h-auto">
				</div>
			</div>
		</div>
	</div>
</section>



<section id="popular-cat" class="w-full form py-20 fluid-px">
  <div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
    <h2 class="fluid-h2 max-w-[800px] text-white font-bold leading-[1.15]">
      Основные категории
    </h2>

    <div class="flex mt-[40px]">
      <?php
				$categories = get_terms( array(
					'taxonomy' => 'product_cat',
					'hide_empty' => false,
					'number' => 11,
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
<?php get_template_part( 'template-parts/catalog/form', 'form' ); ?>

<?php get_footer(); ?>

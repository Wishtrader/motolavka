<?php
/**
 * Template Name: About
 * Template for about page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative bg-black overflow-hidden">
	<div class="relative md:h-screen flex items-center">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('about_hero-bg') ?>')] bg-cover bg-right"></div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto 2xl:mt-0 fluid-px">
        <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm mb-[60px] mt-[80px]">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
                <img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
                <span class="text-white">О компании</span>
            </nav>  
			<!-- Desktop Version -->
			<div class="hidden md:grid grid-cols-2 items-center gap-[20px]">
				<!-- Left Content -->
				<div class="flex-1">
					<h1 class="text-white sm:text-[34px] fluid-h1 font-bold mb-[30px] leading-[1.2]">
					<?php the_field('about_heading') ?>
					</h1>
					<p class="text-[#B8C0CC] text-[18px] mb-8 md:leading-[1.6]">
						<?php the_field('about_description') ?>
					</p>
					<div class="flex gap-[20px] w-full">
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="flex-1 bg-[#FF6B00] text-white text-center px-8 py-4 rounded-[2px] font-medium hover:bg-[#E55A00] transition-colors">
							Смотреть каталог
						</a>
						<?php
						motorcycle_shop_lead_modal_trigger(
							array(
								'source' => 'about',
								'class'  => 'flex-1 bg-[#2C2C2C] text-center text-white px-8 py-4 rounded-[2px] border border-[1px] border-[#434C58] font-medium hover:bg-[#3C3C3C] transition-colors',
							)
						);
						?>
					</div>
				</div>
			</div>
			
			<!-- Mobile Version -->
			<div class="md:hidden h-full px-[10px] mt-[40px] relative">
				<div class="relative">
					<h1 class="text-white text-[34px] font-bold mb-6 leading-[1.2]">
						<?php the_field('about_heading') ?>
					</h1>
					<p class="text-gray-300 text-[20px] mb-8 leading-[1.4]">
						<?php the_field('about_description') ?>
					</p>
					<div class="space-y-5 mb-10">
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="block bg-[#FF6B00] text-white text-center px-8 py-4 rounded font-medium hover:bg-[#E55A00] transition-colors">
							Смотреть каталог
						</a>
						<?php
						motorcycle_shop_lead_modal_trigger(
							array(
								'source' => 'about',
								'class'  => 'block w-full bg-[#2C2C2C] text-white text-center px-8 py-4 rounded font-medium hover:bg-[#3C3C3C] transition-colors',
							)
						);
						?>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/about/full-services-about', 'full-services-about' ); ?>
<?php get_template_part( 'template-parts/about/popular-cat-about', 'popular-cat-about' ); ?>
<?php get_template_part( 'template-parts/about/proces', 'proces' ); ?>
<?php get_template_part( 'template-parts/home/brands', 'brands' ); ?>
<?php get_template_part( 'template-parts/about/support', 'support' ); ?>
<?php get_template_part( 'template-parts/home/form', 'form' ); ?>

<?php get_footer(); ?>



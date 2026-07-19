<?php
/**
 * Template Name: Service
 * Template for Service page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
	<div class="relative h-[494px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('service_bg') ?>')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 flex items-start fluid-px">
			<div class="flex max-w-[712px] gap-8 w-full items-center md:mt-[140px]">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[50px]">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
						<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
						<span class="text-white lg:ml-2">Сервис</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white fluid-h1 font-bold mb-6 leading-tight w-full">
						Сервис
					</h1>
					
					<!-- Description -->
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/service/service', 'service' ); ?>
<?php get_template_part( 'template-parts/service/why', 'why' ); ?>
<?php get_template_part( 'template-parts/service/proces', 'proces' ); ?>
<?php get_template_part( 'template-parts/service/form', 'form' ); ?>

<?php get_footer(); ?>

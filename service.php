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
		<div class="absolute inset-0 bg-[url('<?php echo get_template_directory_uri(); ?>/img/service-bg.jpeg')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 h-full flex items-start">
			<div class="flex max-w-[712px] gap-8 w-full items-center mt-[140px]">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-sm mb-[60px] md:mt-[50px]">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
						<svg class="w-4 h-4 text-[#FB8A3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
						<span class="text-white">Сервис</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white text-[32px] md:text-[40px] font-bold mb-6 leading-tight w-full">
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

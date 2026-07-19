<?php

/**
 * Template Name: Shipping and Payment
 * Template for Shipping and Payment page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
	<div class="relative md:h-[480px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('delivery_main-image') ?>')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 flex items-start fluid-px">
			<div class="flex max-w-[712px] gap-8 w-full items-center">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px] md:mt-[154px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[50px]">
						<a href="<?php echo
    						esc_url(home_url('/'))
						; ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
						<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
						<span class="text-white lg:ml-2">Доставка и Оплата</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white fluid-h1 font-bold mb-6 leading-tight w-full">
						<?php the_field('delivery_main-heading') ?>
					</h1>
					
					<!-- Description -->
					<p class="text-[#B8C0CC] fluid-body mb-10 leading-[1.6] lg:mt-10">
						<?php the_field('delivery_main-description') ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part('template-parts/shipping/payments', 'payments'); ?>
<?php get_template_part('template-parts/shipping/proces', 'proces'); ?>

<?php get_footer();

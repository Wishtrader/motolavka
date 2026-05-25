<?php
/**
 * Template Name: Shipping and Payment
 * Template for Shipping and Payment page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
	<div class="relative h-[494px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php echo get_template_directory_uri(); ?>/img/shipping-bg.jpeg')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 h-full flex items-start">
			<div class="flex max-w-[712px] gap-8 w-full items-center">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px] mt-[140px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-sm mb-[60px]">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
						<svg class="w-4 h-4 text-[#FB8A3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
						<span class="text-white">Доставка и Оплата</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white text-[32px] md:text-[40px] font-bold mb-6 leading-tight w-full">
						Доставка и Оплата
					</h1>
					
					<!-- Description -->
					<p class="text-[#B8C0CC] text-[16px] md:text-[18px] mb-10 leading-[1.6]">
						Условия покупки и получения заказа уточняются перед подтверждением. Мы связываемся с клиентом, подтверждаем наличие, цену и удобный способ получения.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/shipping/payments', 'payments' ); ?>
<?php get_template_part( 'template-parts/shipping/proces', 'proces' ); ?>

<?php get_footer(); ?>

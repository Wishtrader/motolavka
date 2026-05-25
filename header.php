<?php ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Nata+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
	tailwind.config = {
		theme: {
			extend: {
				fontFamily: {
					'nata': ['"Nata Sans"', 'sans-serif'],
					'plex': ['"IBM Plex Sans"', 'sans-serif']
				}
			}
		}
	}
</script>
<style>
	h1, h2, h3, h4 {
		font-family: 'Nata Sans', sans-serif;
	}
	h5, h6, p, span, a, label, input, button {
		font-family: 'IBM Plex Sans', sans-serif;
	}
	html, body {
		overflow-x: hidden;
		max-width: 100vw;
	}
</style>

	<?php wp_head(); ?>
	<style>
		.nav-link-active { color: #FB8A3C !important; }
		.nav-btn-active { background-color: #FB8A3C !important; }
	</style>
</head>

<body class="bg-[#171A1F]">
	<header class="absolute flex flex-col w-full top-0 z-50">
		<!-- Top Bar -->
		<div class="text-white text-sm my-[20px]">
			<div class="max-w-[1200px] h-[42px] mx-auto px-4 flex items-center justify-center gap-6">
				<span class="hidden sm:inline">Пн-Пт с 9:00 до 19:00</span>
				<div class="hidden sm:block h-[42px] w-[1px] bg-[#B8C0CC]"></div>
				<span>Доставка по Беларуси</span>
				<div class="hidden sm:block h-[42px] w-[1px] bg-[#B8C0CC]"></div>
				<a href="tel:+375293070603" class="hover:text-[#FB8A3C]">+375 29 307 06 03</a>
			</div>
		</div>
		
		<!-- Main Header -->
		<div>
			<div class="max-w-[1200px] mx-auto">
				<div class="hidden md:flex items-center h-[60px] gap-8">
					<!-- Logo -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex-shrink-0">
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="МОТОЛАВКА" class="h-[60px] w-auto">
					</a>
					
					<!-- Catalog Button -->
					<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="bg-[#F97316] flex items-center justify-center h-[52px] w-[180px] rounded-[2px] text-white font-medium hover:bg-[#FB8A3C] transition-colors">
						Каталог
					</a>
					
					<!-- Search -->
					<div class="flex-1 max-w-[224px]">
						<?php get_template_part( 'template-parts/header/search-form', null, array( 'variant' => 'desktop' ) ); ?>
					</div>
					
					<!-- Navigation -->
					<nav class="flex items-center gap-6 flex-1">
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="text-white text-sm hover:text-[#FB8A3C] transition-colors">О компании</a>
						<a href="<?php echo esc_url( home_url( '/shipping-and-payment' ) ); ?>" class="text-white text-sm hover:text-[#FB8A3C] transition-colors">Доставка и Оплата</a>
						<a href="<?php echo esc_url( home_url( '/service' ) ); ?>" class="text-white text-sm hover:text-[#FB8A3C] transition-colors">Сервис</a>
						<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="text-white text-sm hover:text-[#FB8A3C] transition-colors">Контакты</a>
					</nav>
					
					<!-- Cart -->
					<?php get_template_part( 'template-parts/header/cart-link', null, array( 'variant' => 'desktop' ) ); ?>
				</div>
				
				<!-- Mobile Header -->
				<div class="md:hidden flex items-center justify-between h-[70px] px-[10px]">
					<!-- Logo -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
						<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="МОТОЛАВКА" class="h-[40px] w-auto">
					</a>
					
					<!-- Right side: Catalog, Cart, Menu -->
					<div class="flex items-center gap-4">
						<!-- Catalog Button -->
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="bg-[#FF6B00] text-white px-4 py-2 rounded text-sm font-medium">
							Каталог
						</a>
						
						<!-- Cart -->
						<?php get_template_part( 'template-parts/header/cart-link', null, array( 'variant' => 'mobile' ) ); ?>
						
						<!-- Hamburger Menu -->
						<button id="mobile-menu-toggle" class="text-white">
							<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
							</svg>
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Mobile Menu Overlay -->
		<div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-black/80 z-50 md:hidden">
			<div class="flex flex-col h-full">
				<!-- Header with Cart and Close -->
				<div class="flex items-center justify-between p-4 bg-[#1A1A1A] border-b border-gray-700">
					<h2 class="text-white text-lg font-bold">Меню</h2>
					<div class="flex items-center gap-4">
						<!-- Cart in menu header -->
						<?php get_template_part( 'template-parts/header/cart-link', null, array( 'variant' => 'menu' ) ); ?>
						<!-- Close button -->
						<button id="mobile-menu-close" class="text-white">
							<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
							</svg>
						</button>
					</div>
				</div>
				
				<!-- Menu Content -->
				<div class="flex-1 overflow-y-auto bg-[#1A1A1A] p-4">
					<!-- Catalog Button -->
					<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="block w-full bg-[#FF6B00] text-white text-center py-4 rounded-lg font-bold text-lg mb-6">
						Каталог
					</a>
					
					<!-- Search -->
					<div class="mb-6">
						<?php get_template_part( 'template-parts/header/search-form', null, array( 'variant' => 'mobile' ) ); ?>
					</div>
					
					<!-- Menu Links -->
					<nav class="space-y-4 mb-8">
						<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="block <?php echo is_page('catalog') ? 'text-[#FB8A3C]' : 'text-white'; ?> text-lg">Каталог</a>
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="block <?php echo is_page('about') ? 'text-[#FB8A3C]' : 'text-white'; ?> text-lg">О компании</a>
						<a href="<?php echo esc_url( home_url( '/shipping-and-payment' ) ); ?>" class="block <?php echo is_page('shipping-and-payment') ? 'text-[#FB8A3C]' : 'text-white'; ?> text-lg">Доставка и Оплата</a>
						<a href="#" class="block text-white text-lg">Сервис</a>
						<a href="#" class="block text-white text-lg">Контакты</a>
					</nav>
					
					<!-- Contacts Section -->
					<div class="border-t border-gray-700 pt-6">
						<h3 class="text-white text-xl font-bold mb-4">Контакты</h3>
						
						<div class="space-y-4">
							<div>
								<p class="text-gray-400 text-sm mb-1">Телефон</p>
								<a href="tel:+375293070603" class="text-white text-lg font-medium">+375 29 307 06 03</a>
							</div>
							
							<div>
								<p class="text-gray-400 text-sm mb-1">Email:</p>
								<a href="mailto:motolavkaby@yandex.by" class="text-white text-lg">motolavkaby@yandex.by</a>
							</div>
							
							<div>
								<p class="text-gray-400 text-sm mb-1">Адрес:</p>
								<p class="text-white text-base">г. Минск, ул. Руссиянова, д. 3, корп. 1, ком. 326-А/69</p>
							</div>
							
							<div>
								<p class="text-gray-400 text-sm mb-1">Режим работы:</p>
								<p class="text-white text-lg font-medium">Пн-Пт с 9:00 до 19:00</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const menuToggle = document.getElementById('mobile-menu-toggle');
			const menuClose = document.getElementById('mobile-menu-close');
			const menuOverlay = document.getElementById('mobile-menu-overlay');
			
			if (menuToggle && menuOverlay) {
				menuToggle.addEventListener('click', function() {
					menuOverlay.classList.remove('hidden');
					document.body.style.overflow = 'hidden';
				});
			}
			
			if (menuClose && menuOverlay) {
				menuClose.addEventListener('click', function() {
					menuOverlay.classList.add('hidden');
					document.body.style.overflow = '';
				});
			}
			
			if (menuOverlay) {
				menuOverlay.addEventListener('click', function(e) {
					if (e.target === menuOverlay) {
						menuOverlay.classList.add('hidden');
						document.body.style.overflow = '';
					}
				});
			}
		});
	</script>

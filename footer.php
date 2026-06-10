<?php
$footer_home_url     = home_url( '/' );
$footer_catalog_url  = motorcycle_shop_page_url( 'catalog.php', 'catalog' );
$footer_about_url    = motorcycle_shop_page_url( 'about.php', 'about' );
$footer_shipping_url = motorcycle_shop_page_url( 'shipping.php', 'shipping-and-payment' );
$footer_service_url  = motorcycle_shop_page_url( 'service.php', 'service' );
$footer_contact_url  = motorcycle_shop_page_url( 'contact.php', 'contact' );
$footer_privacy_url  = function_exists( 'motorcycle_shop_privacy_policy_url' )
	? motorcycle_shop_privacy_policy_url()
	: motorcycle_shop_page_url( 'privacy-policy.php', 'privacy-policy' );
$footer_cookie_url   = function_exists( 'motorcycle_shop_cookie_policy_url' )
	? motorcycle_shop_cookie_policy_url()
	: motorcycle_shop_page_url( 'cookie-policy.php', 'cookie-policy' );

$footer_nav_links = array(
	array(
		'label' => 'Каталог',
		'url'   => $footer_catalog_url,
	),
	array(
		'label' => 'О компании',
		'url'   => $footer_about_url,
	),
	array(
		'label' => 'Доставка и Оплата',
		'url'   => $footer_shipping_url,
	),
	array(
		'label' => 'Сервис',
		'url'   => $footer_service_url,
	),
	array(
		'label' => 'Контакты',
		'url'   => $footer_contact_url,
	),
);

$footer_category_links = motorcycle_shop_footer_category_links();
?>

	<footer class="pt-4">
		<div class="max-w-[1200px] mx-auto px-4 md:px-0">
			<!-- Main Footer Content -->
			<div class="hidden md:flex items-stretch gap-16">
				<!-- Left Column: Logo & Description -->
				<div class="flex-shrink-0">
					<a href="<?php echo esc_url( $footer_home_url ); ?>" class="flex-shrink-0">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo.svg' ); ?>" alt="МОТОЛАВКА" class="h-[85px] w-auto">
					</a>
					<p class="text-gray-400 text-sm leading-relaxed max-w-[320px]">
						Каталог мототехники, запчастей и аксессуаров с подбором под задачи клиента и сервисной поддержкой.
					</p>
				</div>

				<!-- Navigation Column -->
				<div class="flex-shrink-0">
					<h3 class="text-white text-lg font-bold mb-4">Навигация</h3>
					<nav class="space-y-3">
						<?php foreach ( $footer_nav_links as $link ) : ?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" class="block text-white text-sm hover:text-[#FF6B00] transition-colors">
								<?php echo esc_html( $link['label'] ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				</div>

				<!-- Categories Column -->
				<div class="flex-shrink-0">
					<h3 class="text-white text-lg font-bold mb-4">Категории</h3>
					<nav class="space-y-3">
						<?php foreach ( $footer_category_links as $link ) : ?>
							<a href="<?php echo esc_url( $link['url'] ); ?>" class="block text-white text-sm hover:text-[#FF6B00] transition-colors">
								<?php echo esc_html( $link['label'] ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				</div>

				<!-- Contacts Column -->
				<div class="flex-shrink-0">
					<h3 class="text-white text-lg font-bold mb-4">Контакты</h3>
					<div class="space-y-4">
						<div>
							<p class="text-white text-sm mb-1">Телефон</p>
							<a href="tel:+375293070603" class="text-white text-base font-medium hover:text-[#FF6B00] transition-colors">+375 29 307 06 03</a>
						</div>

						<div>
							<p class="text-white text-sm mb-1">Email:</p>
							<a href="mailto:motolavkaby@yandex.by" class="text-white text-base hover:text-[#FF6B00] transition-colors">motolavkaby@yandex.by</a>
						</div>

						<div>
							<p class="text-white text-sm mb-1">Адрес:</p>
							<p class="text-white text-base">г. Минск, ул. Глаголева 45, к.1</p>
						</div>

						<div>
							<p class="text-white text-sm mb-1">Режим работы:</p>
							<p class="text-white text-base font-medium">Пн-Пт с 9:00 до 19:00</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Mobile Footer -->
			<div class="md:hidden py-8 space-y-6">
				<div>
					<a href="<?php echo esc_url( $footer_home_url ); ?>" class="inline-block mb-4">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo.svg' ); ?>" alt="МОТОЛАВКА" class="h-[60px] w-auto">
					</a>
					<p class="text-gray-400 text-sm leading-relaxed">
						Каталог мототехники, запчастей и аксессуаров с подбором под задачи клиента и сервисной поддержкой.
					</p>
				</div>
				<div class="flex w-full">
					<div class="flex-1">
						<h3 class="text-white text-lg font-bold mb-3">Навигация</h3>
						<nav class="space-y-2">
							<?php foreach ( $footer_nav_links as $link ) : ?>
								<a href="<?php echo esc_url( $link['url'] ); ?>" class="block text-white text-sm hover:text-[#FF6B00] transition-colors">
									<?php echo esc_html( $link['label'] ); ?>
								</a>
							<?php endforeach; ?>
						</nav>
					</div>

					<div class="flex-1">
						<h3 class="text-white text-lg font-bold mb-3">Категории</h3>
						<nav class="space-y-2">
							<?php foreach ( $footer_category_links as $link ) : ?>
								<a href="<?php echo esc_url( $link['url'] ); ?>" class="block text-white text-sm hover:text-[#FF6B00] transition-colors">
									<?php echo esc_html( $link['label'] ); ?>
								</a>
							<?php endforeach; ?>
						</nav>
					</div>
				</div>
				<div>
					<h3 class="text-white text-lg font-bold mb-3">Контакты</h3>
					<div class="space-y-3">
						<div>
							<p class="text-gray-400 text-sm mb-1">Телефон</p>
							<a href="tel:+375293070603" class="text-white text-base font-medium hover:text-[#FF6B00] transition-colors">+375 29 307 06 03</a>
						</div>

						<div>
							<p class="text-gray-400 text-sm mb-1">Email:</p>
							<a href="mailto:motolavkaby@yandex.by" class="text-white text-base hover:text-[#FF6B00] transition-colors">motolavkaby@yandex.by</a>
						</div>

						<div>
							<p class="text-gray-400 text-sm mb-1">Адрес:</p>
							<p class="text-white text-base">г. Минск, ул. Глаголева 45 к.1</p>
						</div>

						<div>
							<p class="text-gray-400 text-sm mb-1">Режим работы:</p>
							<p class="text-white text-base font-medium">Пн-Пт с 9:00 до 19:00</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer Bottom Bar -->
		<div>
			<div class="max-w-[1200px] mx-auto px-2">
				<div class="hidden md:flex items-center justify-between py-4">
					<a href="<?php echo esc_url( $footer_privacy_url ); ?>" class="text-[#B8C0CC] text-sm hover:text-[#B8C0CC] transition-colors">Политика конфиденциальности</a>
					<p class="text-[#B8C0CC] text-sm">© Мотолавка, 2026. Все права защищены.</p>
					<a href="<?php echo esc_url( $footer_cookie_url ); ?>" class="text-[#B8C0CC] text-sm hover:text-[#B8C0CC] transition-colors">Политика обработки файлов cookie</a>
				</div>

				<div class="md:hidden py-4 text-center">
					<p class="text-[#B8C0CC] text-sm mb-2">© Мотолавка, 2026. Все права защищены.</p>
					<div class="space-y-1">
						<a href="<?php echo esc_url( $footer_privacy_url ); ?>" class="block text-[#B8C0CC] text-sm hover:text-[#FF6B00] transition-colors">Политика конфиденциальности</a>
						<a href="<?php echo esc_url( $footer_cookie_url ); ?>" class="block text-[#B8C0CC] text-sm hover:text-[#FF6B00] transition-colors">Политика обработки файлов cookie</a>
					</div>
				</div>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>

</body>
</html>

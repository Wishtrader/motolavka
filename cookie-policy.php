<?php
/**
 * Template Name: Cookie Policy
 * Template for Cookie Policy page
 *
 * @package motorcycle-shop
 */

get_header();

$browser_links = array(
	'Firefox'           => 'https://support.mozilla.org/ru/kb/udalenie-kukov-dlya-udaleniya-informacii-kotoruyu-',
	'Google Chrome'     => 'https://support.google.com/chrome/answer/95647?hl=ru',
	'Safari'            => 'https://support.apple.com/ru-ru/guide/safari/sfri11471/mac',
	'Opera'             => 'https://help.opera.com/en/latest/web-preferences/#cookies',
	'Internet Explorer' => 'https://support.microsoft.com/ru-ru/windows/удаление-файлов-cookie-и-изменение-параметров-файлов-cookie-168dab11-0753-043d-7c16-ede5947fc64d',
	'Яндекс'            => 'https://yandex.ru/support/browser/ru/personal-data-protection/cookies.html',
	'Microsoft Edge'    => 'https://support.microsoft.com/ru-ru/microsoft-edge/удаление-файлов-cookie-в-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09',
);
?>

<section class="w-full px-[10px] md:px-0 pt-[110px] md:pt-[130px] pb-12 md:pb-16">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex flex-wrap items-center gap-2 text-sm mb-6 md:mb-8" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
			<svg class="w-4 h-4 text-[#FB8A3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
			</svg>
			<span class="text-white">Политика обработки файлов cookie</span>
		</nav>

		<article class="text-[#B8C0CC] text-sm md:text-base leading-relaxed max-w-[960px]">
			<h1 class="text-white text-[28px] md:text-[36px] font-bold leading-tight mb-8 md:mb-10">
				Политика в отношении обработки файлов cookie
			</h1>

			<div class="space-y-6 md:space-y-8">
				<section>
					<p>
						<span class="text-white font-semibold">1.</span>
						Настоящая Политика описывает порядок использования файлов cookie на сайте «Мотолавка» (далее — Сайт). Файлы cookie — это небольшие текстовые файлы, которые сохраняются в браузере пользователя при посещении Сайта. Они помогают распознавать браузер, запоминать настройки, обеспечивать корректную работу отдельных функций и собирать обезличенную статистику посещений. Файлы cookie не являются исполняемыми программами, не содержат вирусов и не представляют угрозы для устройства пользователя.
					</p>
				</section>

				<section>
					<p class="mb-4">
						<span class="text-white font-semibold">2.</span>
						На Сайте могут использоваться следующие категории файлов cookie:
					</p>
					<ul class="list-disc pl-5 md:pl-6 space-y-2 marker:text-[#FF6B00]">
						<li>
							<span class="text-white font-medium">Обязательные (необходимые)</span> — обеспечивают базовую работу Сайта, безопасность, сохранение выбора пользователя в баннере cookie, работу корзины и оформления заказа. Без них использование Сайта может быть невозможно или ограничено.
						</li>
						<li>
							<span class="text-white font-medium">Функциональные</span> — запоминают предпочтения пользователя (например, язык интерфейса, регион, ранее просмотренные разделы) и делают работу с Сайтом более удобной.
						</li>
						<li>
							<span class="text-white font-medium">Целевые и аналитические</span> — используются для анализа посещаемости, популярности страниц и поведения пользователей на Сайте в обезличенном виде с целью улучшения качества сервиса и контента.
						</li>
					</ul>
				</section>

				<section>
					<p class="mb-4">
						<span class="text-white font-semibold">3.</span>
						По сроку хранения файлы cookie подразделяются на:
					</p>
					<ul class="list-disc pl-5 md:pl-6 space-y-2 marker:text-[#FF6B00]">
						<li>
							<span class="text-white font-medium">Сессионные cookie</span> — хранятся только в течение текущего сеанса работы с браузером и удаляются после его закрытия.
						</li>
						<li>
							<span class="text-white font-medium">Постоянные cookie</span> — сохраняются на устройстве в течение установленного срока (например, до 12 месяцев) и позволяют распознавать пользователя при повторных визитах, в том числе запоминать согласие на использование cookie.
						</li>
					</ul>
				</section>

				<section>
					<p>
						<span class="text-white font-semibold">4.</span>
						При первом посещении Сайта пользователю отображается уведомление о файлах cookie с возможностью нажать «Принять» (согласие на использование всех категорий cookie, указанных в уведомлении) или «Отклонить» (ограничение только необходимыми cookie). Выбор сохраняется и при повторных визитах баннер не отображается, пока пользователь не удалит сохранённые данные в браузере. Отключение функциональных и аналитических cookie может повлиять на удобство использования отдельных разделов Сайта.
					</p>
				</section>

				<section>
					<p class="mb-4">
						<span class="text-white font-semibold">5.</span>
						Пользователь может в любой момент изменить настройки cookie в параметрах браузера: заблокировать сохранение cookie, удалить ранее сохранённые файлы или включить режим приватного просмотра. Инструкции по управлению cookie в популярных браузерах:
					</p>
					<ul class="list-disc pl-5 md:pl-6 space-y-2 marker:text-[#FF6B00]">
						<?php foreach ( $browser_links as $name => $url ) : ?>
							<li>
								<a
									href="<?php echo esc_url( $url ); ?>"
									class="text-white hover:text-[#FB8A3C] transition-colors underline underline-offset-2"
									target="_blank"
									rel="noopener noreferrer"
								>
									<?php echo esc_html( $name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
					<p class="mt-4">
						По вопросам, связанным с обработкой файлов cookie и персональных данных, вы можете связаться с нами по телефону
						<a href="tel:+375293070603" class="text-white hover:text-[#FB8A3C] transition-colors">+375 29 307 06 03</a>
						или по электронной почте
						<a href="mailto:motolavkaby@yandex.by" class="text-white hover:text-[#FB8A3C] transition-colors">motolavkaby@yandex.by</a>.
					</p>
				</section>
			</div>
		</article>
	</div>
</section>

<?php
get_footer();

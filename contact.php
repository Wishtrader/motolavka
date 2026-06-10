<?php
/**
 * Template Name: Contact
 * Template for Contact page
 */
?>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
	<div class="relative h-[494px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('hero_img') ?>')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 flex items-start fluid-px">
			<div class="flex max-w-[712px] gap-8 w-full items-center mt-[140px]">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-sm mb-[60px] md:mt-[50px]">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
						<svg class="w-4 h-4 text-[#FB8A3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
						<span class="text-white">Контакты</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white fluid-h1 font-bold mb-6 leading-tight w-full">
						Контакты
					</h1>
					
					<!-- Description -->
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$theme_uri = get_template_directory_uri();
?>

<!-- Contact Section -->
<section class="w-full py-10 fluid-px">
	<div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
		<div class="flex flex-col lg:flex-row gap-[20px]">
			<!-- Contact info cards -->
			<div class="grid grid-cols-2 gap-[20px] w-full lg:w-[590px] lg:shrink-0">
				<!-- Phone -->
				<div class="bg-[#2A3038] flex flex-col items-center justify-center text-center px-6 py-[40px] min-h-[200px]">
					<div class="w-[44px] h-[44px] rounded-[2px] bg-[#FF6B00] flex items-center justify-center mb-5">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
						</svg>
					</div>
					<h3 class="text-white text-[18px] font-semibold mb-2">Телефон</h3>
					<a href="tel:<?php the_field('phone') ?>" class="text-[#B8C0CC] text-[14px] leading-relaxed hover:text-[#FF6B00] transition-colors"><?php the_field('phone') ?></a>
				</div>

				<!-- Email -->
				<div class="bg-[#2A3038] flex flex-col items-center justify-center text-center px-6 py-[40px] min-h-[200px]">
					<div class="w-[44px] h-[44px] rounded-[2px] bg-[#FF6B00] flex items-center justify-center mb-5">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
						</svg>
					</div>
					<h3 class="text-white text-[18px] font-semibold mb-2">Email</h3>
					<a href="mailto:<?php the_field('email') ?>" class="text-[#B8C0CC] text-[14px] leading-relaxed hover:text-[#FF6B00] transition-colors break-all"><?php the_field('email') ?></a>
				</div>

				<!-- Hours -->
				<div class="bg-[#2A3038] flex flex-col items-center justify-center text-center px-6 py-[40px] min-h-[200px]">
					<div class="w-[44px] h-[44px] rounded-[2px] bg-[#FF6B00] flex items-center justify-center mb-5">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
						</svg>
					</div>
					<h3 class="text-white text-[18px] font-semibold mb-2">Режим работы</h3>
					<p class="text-[#B8C0CC] text-[14px] leading-relaxed"><?php the_field('worktime') ?></p>
				</div>

				<!-- Address -->
				<div class="bg-[#2A3038] flex flex-col items-center justify-center text-center px-6 py-[40px] min-h-[200px]">
					<div class="w-[44px] h-[44px] rounded-[2px] bg-[#FF6B00] flex items-center justify-center mb-5">
						<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
						</svg>
					</div>
					<h3 class="text-white text-[18px] font-semibold mb-2">Адрес</h3>
					<p class="text-[#B8C0CC] text-[14px] leading-relaxed max-w-[240px]"><?php the_field('address')?></p>
				</div>
			</div>

			<!-- Contact form -->
			<div class="relative flex-1 min-h-[420px] overflow-hidden">
				<div class="absolute inset-0 bg-[url('<?php echo esc_url( $theme_uri ); ?>/img/moto3.png')] bg-cover bg-center"></div>
				<div class="absolute inset-0 bg-[#171A1F]/75"></div>
				<form
					id="contact-form"
					method="post"
					action=""
					class="relative flex flex-col h-full min-h-[420px] px-8 py-10 md:px-10 md:py-12 justify-center"
					data-contact-form
				>
					<h2 class="text-white fluid-h2-sm font-bold leading-[1.15] mb-4">
						Связаться с нами
					</h2>
					<p class="text-[#B8C0CC] fluid-body-sm leading-relaxed mb-8 max-w-[480px]">
						Напишите, что вас интересует, и мы свяжемся с вами в рабочее время.
					</p>

					<?php
					$contact_error    = isset( $_GET['contact_error'] ) ? sanitize_text_field( wp_unslash( $_GET['contact_error'] ) ) : '';
					$contact_success  = isset( $_GET['contact_sent'] ) && '1' === $_GET['contact_sent'];
					$contact_error_message = '';
					if ( $contact_error && ! $contact_success ) {
						$messages = array(
							'name'    => 'Укажите имя (минимум 2 символа).',
							'phone'   => 'Укажите корректный номер телефона.',
							'privacy' => 'Необходимо согласие с политикой конфиденциальности.',
							'invalid' => 'Не удалось отправить заявку. Попробуйте ещё раз.',
							'save'    => 'Ошибка сохранения. Попробуйте позже или позвоните нам.',
						);
						$contact_error_message = isset( $messages[ $contact_error ] ) ? $messages[ $contact_error ] : 'Ошибка отправки формы.';
					}
					?>

					<?php if ( $contact_success ) : ?>
						<div class="flex flex-col gap-[12px] max-w-[480px] w-full">
							<div class="p-4 bg-green-600/20 border border-green-500 rounded-[2px] text-green-400 text-sm">
								Заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.
							</div>
							<button
								type="button"
								id="contact-form-reset"
								class="flex w-full max-h-[52px] mt-5 items-center justify-center rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors"
							>
								Отправить ещё одну заявку
							</button>
						</div>
					<?php else : ?>
						<?php if ( $contact_error_message ) : ?>
							<div class="p-4 bg-red-600/20 border border-red-500 rounded-[2px] text-red-400 text-sm">
								<?php echo esc_html( $contact_error_message ); ?>
							</div>
						<?php endif; ?>

						<div class="flex flex-col gap-[12px] max-w-[480px] w-full">
							<input
								type="text"
								name="contact_name"
								required
								minlength="2"
								class="contact-name w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
								placeholder="Имя"
							/>

							<input
								type="tel"
								name="contact_phone"
								required
								class="contact-phone w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
								placeholder="+375 (XX) XXX-XX-XX"
							/>

							<label class="inline-flex items-center gap-3 cursor-pointer mt-1">
								<input
									type="checkbox"
									name="contact_privacy"
									value="1"
									class="contact-privacy peer sr-only"
									required
									checked
								/>
								<span class="relative w-[32px] h-[32px] shrink-0 rounded-[2px] bg-[#FF6B00] flex items-center justify-center hover:brightness-95 transition-[filter] peer-checked:[&_svg]:opacity-100">
									<svg
										class="w-6 h-6 text-white opacity-0 transition-opacity duration-150"
										viewBox="0 0 24 24"
										fill="none"
										stroke="currentColor"
										stroke-width="3"
										stroke-linecap="round"
										stroke-linejoin="round"
										aria-hidden="true"
									>
										<path d="M20 6L9 17l-5-5" />
									</svg>
								</span>
								<span class="select-none text-[#B8C0CC] text-[12px] md:text-sm leading-[1.4]">
									Продолжая, вы соглашаетесь с политикой конфиденциальности
								</span>
							</label>

							<button
								type="submit"
								class="contact-submit flex w-full max-h-[52px] mt-5 items-center justify-center rounded-[2px] bg-[#FF6B00] text-[#F5F7FA] px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
							>
								Отправить заявку
							</button>
						</div>
					<?php endif; ?>

					<?php wp_nonce_field( 'motorcycle_shop_contact_form', 'contact_nonce' ); ?>
					<input type="hidden" name="contact_source" value="contact-page" />
				</form>
			</div>
		</div>

		<!-- Map -->
		<div class="w-full h-[320px] md:h-[400px] overflow-hidden">
			<iframe
				src="https://yandex.ru/map-widget/v1/?ll=27.483255%2C53.884906&amp;z=16&amp;pt=27.483255%2C53.884906%2Cpm2rdm&amp;l=map"
				class="w-full h-full border-0"
				allowfullscreen
				loading="lazy"
				title="Карта — г. Минск, ул. Глаголева, д. 45, к. 1"
			></iframe>
		</div>
	</div>
</section>

<?php get_footer(); ?>

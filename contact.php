<?php

/**
 * Template Name: Contact
 * Template for Contact page
 */
?>

<?php get_header();

$contact_page_contacts = motorcycle_shop_get_contacts('contact');
?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
	<div class="relative h-[227px] lg:h-[484px]">
		<!-- Background Image -->
		<div class="absolute inset-0 bg-[url('<?php the_field('hero_img') ?>')] bg-cover bg-right">
		</div>
		
		<!-- Content -->
		<div class="relative w-full max-w-[1200px] mx-auto h-full my-0 flex items-start fluid-px">
			<div class="flex max-w-[712px] gap-8 w-full items-center lg:mt-[140px]">
				<!-- Left Content -->
				<div class="text-white w-full max-w-[680px]">
					<!-- Breadcrumb -->
					<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[64px]">
						<a href="<?php echo
    						esc_url(home_url('/'))
						; ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
						<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
						<span class="text-white lg:ml-2">Контакты</span>
					</nav>
					
					<!-- Title -->
					<h1 class="text-white text-[34px] lg:text-[40px] font-bold mb-6 leading-tight w-full">
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
<section class="w-full py-14 fluid-px">
	<div class="flex flex-col max-w-[1200px] mx-auto gap-[20px]">
		<div class="flex flex-col lg:flex-row gap-[20px]">
			<!-- Contact info cards -->
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-[20px] w-full lg:w-[590px] lg:shrink-0">
				<?php

				$contact_cards = array();
				if (function_exists('have_rows') && have_rows('contact_cards')) {
    				while (have_rows('contact_cards')) {
        				the_row();
        				$contact_cards[] = array(
            				'icon' => get_sub_field('icon'),
            				'title' => get_sub_field('title'),
            				'value' => get_sub_field('value'),
            				'link' => get_sub_field('link'),
        				);
    				}
				} else {
    				$contact_cards = array(
        				array(
            				'icon' => 'phone',
            				'title' => 'Телефон',
            				'value' => get_field('phone'),
            				'link' => 'tel:' . get_field('phone'),
        				),
        				array(
            				'icon' => 'email',
            				'title' => 'Email',
            				'value' => get_field('email'),
            				'link' => 'mailto:' . get_field('email'),
        				),
        				array(
            				'icon' => 'hours',
            				'title' => 'Режим работы',
            				'value' => get_field('worktime'),
            				'link' => '',
        				),
        				array(
            				'icon' => 'address',
            				'title' => 'Адрес',
            				'value' => get_field('address'),
            				'link' => '',
        				),
    				);
				}

				foreach ($contact_cards as $card):
    				$card_icon = isset($card['icon']) ? $card['icon'] : '';
    				$card_title = isset($card['title']) ? $card['title'] : '';
    				$card_value = isset($card['value']) ? $card['value'] : '';
    				$card_link = isset($card['link']) ? $card['link'] : '';
    				?>
					<div class="bg-[#2A3038] flex flex-col items-center justify-start text-center p-2.5 lg:p-5 lg:min-h-[303px]">
						<div class="w-[44px] h-[44px] rounded-[2px] bg-[#FF6B00] flex items-center justify-center mb-5 lg:mb-10">
							<img src="<?php echo esc_url($card_icon); ?>" alt="" class="w-8 h-8 object-contain" />
						</div>
						<h3 class="text-white text-[20px] lg:text-[24px] font-semibold mb-2.5 lg:mb-8"><?php echo
    						esc_html($card_title)
						; ?></h3>
						<?php if ($card_link): ?>
							<a href="<?php echo
    							esc_attr($card_link)
							; ?>" class="text-[#B8C0CC] text-base lg:text-lg leading-relaxed hover:text-[#FF6B00] transition-colors break-all"><?php echo
    							esc_html($card_value)
							; ?></a>
						<?php else: ?>
							<p class="text-[#B8C0CC] text-base lg:text-lg leading-relaxed"><?php echo esc_html($card_value); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<!-- Contact form -->
			<div class="relative flex-1 min-h-[420px] overflow-hidden items-center">
				<div class="absolute inset-0 bg-[url('<?php echo esc_url($theme_uri); ?>/img/moto3.png')] bg-cover bg-center"></div>
				<form
					id="contact-form"
					method="post"
					action=""
					class="relative flex flex-col h-full lg:min-h-[420px] p-2.5 md:px-10 md:py-12 justify-center"
					data-contact-form
				>
					<h2 class="text-white text-[28px] lg:text-[40px] font-bold leading-[1.15] mb-4">
						Связаться с нами
					</h2>
					<p class="text-[#B8C0CC] text-base lg:text-lg leading-relaxed mb-8 max-w-[480px]">
						Напишите, что вас интересует, и мы свяжемся с вами в рабочее время.
					</p>

					<?php

					$contact_error = isset($_GET['contact_error']) ? sanitize_text_field(wp_unslash($_GET['contact_error'])) : '';
					$contact_success = isset($_GET['contact_sent']) && '1' === $_GET['contact_sent'];
					$contact_error_message = '';
					if ($contact_error && !$contact_success) {
    					$messages = array(
        					'name' => 'Укажите имя (минимум 2 символа).',
        					'phone' => 'Укажите корректный номер телефона.',
        					'privacy' => 'Необходимо согласие с политикой конфиденциальности.',
        					'invalid' => 'Не удалось отправить заявку. Попробуйте ещё раз.',
        					'save' => 'Ошибка сохранения. Попробуйте позже или позвоните нам.',
    					);
    					$contact_error_message = isset($messages[$contact_error])
        					? $messages[$contact_error]
        					: 'Ошибка отправки формы.';
					}
					?>

					<?php if ($contact_success): ?>
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
					<?php else: ?>
						<?php if ($contact_error_message): ?>
							<div class="p-4 bg-red-600/20 border border-red-500 rounded-[2px] text-red-400 text-sm">
								<?php echo esc_html($contact_error_message); ?>
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

					<?php wp_nonce_field('motorcycle_shop_contact_form', 'contact_nonce'); ?>
					<input type="hidden" name="contact_source" value="contact-page" />
				</form>
			</div>
		</div>

		<!-- Map -->
		<div class="w-full h-[247px] md:h-[400px] overflow-hidden mt-10">
			<iframe
				src="<?php echo esc_url($contact_page_contacts['map_url']); ?>"
				class="w-full h-full border-0"
				allowfullscreen
				loading="lazy"
				title="Карта — <?php echo esc_attr($contact_page_contacts['address']); ?>"
			></iframe>
		</div>
	</div>
</section>

<?php get_footer();

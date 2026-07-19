<!-- Methods Section -->
<section class="py-[40px] overflow-x-hidden">
	<div class="max-w-[1200px] mx-auto px-4 lg:px-0">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-6">
			
			<!-- Left Column -->
			<div class="space-y-5">
				
				<!-- Ways of Payment -->
				<div>
					<h2 class="text-white text-[28px] lg:text-[40px] font-bold mb-5 leading-[1.2]">
						Способы оплаты
					</h2>
					<p class="text-[#B8C0CC] fluid-body-sm lg:text-lg !font-light mb-6 md:mb-10 leading-relaxed">
						Уточняем удобный вариант оплаты перед подтверждением заказа и помогаем согласовать детали в зависимости от категории товара.
					</p>
					
					<div class="space-y-3 md:space-y-5">
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-center gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full"></div>
								<p class="text-white text-[20px] lg:text-lg lg:font-semibold leading-[1.6]">
									<?php the_field('variant1') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-center gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full"></div>
								<p class="text-white text-[20px] lg:text-lg lg:font-semibold leading-[1.6]">
									<?php the_field('variant2') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-center gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full"></div>
								<p class="text-white text-[20px] lg:text-lg lg:font-semibold leading-[1.6]">
									<?php the_field('variant3') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-center gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full"></div>
								<p class="text-white lg:font-semibold text-[20px] lg:text-lg leading-[1.4]">
									<?php the_field('variant4') ?>
								</p>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Delivery -->
				<div>
					<h2 class="text-white text-[24px] md:text-[32px] lg:text-[40px] font-bold mb-6 md:mb-8">
						Доставка
					</h2>
					
					<div class="bg-[#2A3038] p-4 md:p-6">
						<div class="flex items-center gap-3 md:gap-4">
							<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full"></div>
							<p class="text-white text-[20px] lg:text-lg lg:font-semibold leading-[1.2]">
								<?php the_field('delivery') ?>
							</p>
						</div>
					</div>
				</div>
				
			</div>
			
			<!-- Right Column - FAQ -->
			<div class="bg-[#2A3038] p-4 md:p-6 lg:p-10 h-fit lg:ml-[100px]">
				<div class="flex items-center gap-3 mb-5 md:mb-6 pb-4 border-b border-[#FF6B00]">
					<div class="flex-shrink-0 w-[36px] h-[36px] md:w-[44px] md:h-[44px] flex items-center justify-center">
						<img src="<?php echo
    						get_template_directory_uri()
						; ?>/img/question.svg" alt="" class="w-[36px] h-[36px] md:w-[44px] md:h-[44px]">
					</div>
					<h3 class="text-white text-[20px] md:text-[24px] font-bold">
						Частые вопросы
					</h3>
				</div>
				
				<div class="space-y-3 md:space-y-2">
						
					<div>
						<h4 class="text-white text-base md:text-[18px] font-semibold mb-2 md:mb-3">
							<?php the_field('q1') ?>
						</h4>
						<p class="text-[#B8C0CC] text-sm leading-[1.2] mb-5">
							<?php the_field('a1') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-base md:text-lg font-semibold mb-2 md:mb-8 tracking-tight">
							<?php the_field('q2') ?>
						</h4>
						<p class="text-[#B8C0CC] text-sm leading-[1.2] lg:mb-5">
							<?php the_field('a2') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-base md:text-lg font-semibold mb-2 md:mb-3">
							<?php the_field('q3') ?>
						</h4>
						<p class="text-[#B8C0CC] text-sm leading-[1.2] lg:mb-6">
							<?php the_field('a3') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-[16px] md:text-[18px] font-semibold mb-2 md:mb-7">
							<?php the_field('q4') ?>
						</h4>
						<p class="text-[#B8C0CC] text-sm leading-[1.2]">
							<?php the_field('a4') ?>
						</p>
					</div>
				</div>
				
				<div class="mt-8 md:mt-11 text-center  mx-auto">
					<h4 class="text-white text-[18px] md:text-[20px] font-bold mb-2 md:mb-2">
						Остались вопросы?
					</h4>
					<p class="text-[#B8C0CC] fluid-body-sm mb-4 md:mb-10 leading-[1.5] max-w-[286px] mx-auto">
						Свяжитесь с нами — подскажем по оплате, наличию и получению товара.
					</p>
					<a href="/contact" class="inline-block bg-[#FF6B00] text-white font-semibold px-4 md:px-8 py-3 md:py-4 rounded-none hover:bg-[#FB8A3C] transition-colors w-full">
						Связаться с нами
					</a>
				</div>
			</div>
			
		</div>
	</div>
</section>

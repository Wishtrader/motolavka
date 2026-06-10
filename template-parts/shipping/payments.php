<!-- Methods Section -->
<section class="py-[40px] md:py-[80px] overflow-x-hidden">
	<div class="max-w-[1200px] mx-auto px-4">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-12">
			
			<!-- Left Column -->
			<div class="space-y-10">
				
				<!-- Ways of Payment -->
				<div>
					<h2 class="text-white fluid-h2 font-bold mb-4 md:mb-6">
						Способы оплаты
					</h2>
					<p class="text-[#B8C0CC] fluid-body-sm mb-6 md:mb-8 leading-relaxed">
						Уточняем удобный вариант оплаты перед подтверждением заказа и помогаем согласовать детали в зависимости от категории товара.
					</p>
					
					<div class="space-y-3 md:space-y-4">
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-start gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full mt-2"></div>
								<p class="text-white fluid-body-sm leading-relaxed">
									<?php the_field('variant1') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-start gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full mt-2"></div>
								<p class="text-white fluid-body-sm leading-relaxed">
									<?php the_field('variant2') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-start gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full mt-2"></div>
								<p class="text-white fluid-body-sm leading-relaxed">
									<?php the_field('variant3') ?>
								</p>
							</div>
						</div>
						
						<div class="bg-[#2A3038] p-4 md:p-6">
							<div class="flex items-start gap-3 md:gap-4">
								<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full mt-2"></div>
								<p class="text-white fluid-body-sm leading-relaxed">
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
						<div class="flex items-start gap-3 md:gap-4">
							<div class="flex-shrink-0 w-3 h-3 bg-[#FF6B00] rounded-full mt-2"></div>
							<p class="text-white fluid-body-sm leading-relaxed">
								<?php the_field('delivery') ?>
							</p>
						</div>
					</div>
				</div>
				
			</div>
			
			<!-- Right Column - FAQ -->
			<div class="bg-[#2A3038] p-4 md:p-6 lg:p-8 h-fit">
				<div class="flex items-center gap-3 mb-6 md:mb-8 pb-4 border-b border-[#FF6B00]">
					<div class="flex-shrink-0 w-[36px] h-[36px] md:w-[44px] md:h-[44px] flex items-center justify-center">
						<img src="<?php echo get_template_directory_uri(); ?>/img/question.svg" alt="" class="w-[36px] h-[36px] md:w-[44px] md:h-[44px]">
					</div>
					<h3 class="text-white text-[20px] md:text-[24px] font-bold">
						Частые вопросы
					</h3>
				</div>
				
				<div class="space-y-4 md:space-y-6">
						
					<div>
						<h4 class="text-white text-[16px] md:text-[18px] font-semibold mb-2 md:mb-3">
							<?php the_field('q1') ?>
						</h4>
						<p class="text-[#B8C0CC] fluid-body-sm leading-relaxed">
							<?php the_field('a1') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-[16px] md:text-[18px] font-semibold mb-2 md:mb-3">
							<?php the_field('q2') ?>
						</h4>
						<p class="text-[#B8C0CC] fluid-body-sm leading-relaxed">
							<?php the_field('a2') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-[16px] md:text-[18px] font-semibold mb-2 md:mb-3">
							<?php the_field('q3') ?>
						</h4>
						<p class="text-[#B8C0CC] fluid-body-sm leading-relaxed">
							<?php the_field('a3') ?>
						</p>
					</div>
					
					<div>
						<h4 class="text-white text-[16px] md:text-[18px] font-semibold mb-2 md:mb-3">
							<?php the_field('q4') ?>
						</h4>
						<p class="text-[#B8C0CC] fluid-body-sm leading-relaxed">
							<?php the_field('a4') ?>
						</p>
					</div>
				</div>
				
				<div class="mt-8 md:mt-10 text-center">
					<h4 class="text-white text-[18px] md:text-[20px] font-bold mb-2 md:mb-3">
						Остались вопросы?
					</h4>
					<p class="text-[#B8C0CC] fluid-body-sm mb-4 md:mb-6 leading-[1.5]">
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

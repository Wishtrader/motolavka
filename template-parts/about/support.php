<section id="support" class="w-full py-10 px-[10px] md:px-0 relative mb-10">
	<!-- Background Image -->
	<div class="absolute inset-0 bg-[url('<?php echo get_template_directory_uri(); ?>/img/support.png')] bg-cover bg-no-repeat bg-left opacity-40"></div>

	<div class="flex flex-col md:flex-row max-w-[1200px] w-full mx-auto relative z-10">
		<!-- Content Section -->
		<div class="flex flex-col justify-center w-full md:w-auto md:min-w-[793px] ml-auto pl-0 md:pl-[100px]">
			<!-- Title -->
			<h2 class="text-white text-[28px] md:text-[40px] font-bold leading-[1.15] mb-4">
				<?php the_field('support_heading') ?>
			</h2>

			<!-- Description -->
			<p class="text-[#B8C0CC] text-[14px] md:text-[16px] leading-relaxed max-w-[700px] mb-8">
				<?php the_field('support_description') ?>
			</p>

			<!-- Features List -->
			<div class="flex flex-col gap-[25px] mb-8">
				<!-- Item 1 -->
				<div class="flex items-start gap-[15px]">
					<div class="flex-shrink-0 w-[44px] h-[44px] flex items-center justify-center overflow-hidden">
						<img src="<?php echo get_template_directory_uri(); ?>/img/mark.svg" alt="check" class="w-[44px] h-[44px]">
					</div>
					<div>
						<h3 class="text-white text-[18px] font-semibold mb-1">
							<?php the_field('support_subheading1') ?>
						</h3>
						<p class="text-[#B8C0CC] text-[14px] leading-relaxed">
							<?php the_field('support_description1') ?>
						</p>
					</div>
				</div>

				<!-- Item 2 -->
				<div class="flex items-start gap-[15px]">
					<div class="flex-shrink-0 w-[44px] h-[44px] flex items-center justify-center overflow-hidden">
						<img src="<?php echo get_template_directory_uri(); ?>/img/mark.svg" alt="check" class="w-[44px] h-[44px]">
					</div>
					<div>
						<h3 class="text-white text-[18px] font-semibold mb-1">
							<?php the_field('support_subheading2') ?>
						</h3>
						<p class="text-[#B8C0CC] text-[14px] leading-relaxed">
							<?php the_field('support_description2') ?>
						</p>
					</div>
				</div>

				<!-- Item 3 -->
				<div class="flex items-start gap-[15px]">
					<div class="flex-shrink-0 w-[44px] h-[44px] flex items-center justify-center overflow-hidden">
						<img src="<?php echo get_template_directory_uri(); ?>/img/mark.svg" alt="check" class="w-[44px] h-[44px]">
					</div>
					<div>
						<h3 class="text-white text-[18px] font-semibold mb-1">
							<?php the_field('support_subheading3') ?>
						</h3>
						<p class="text-[#B8C0CC] text-[14px] leading-relaxed">
							<?php the_field('support_description3') ?>
						</p>
					</div>
				</div>

				<!-- Item 4 -->
				<div class="flex items-start gap-[15px]">
					<div class="flex-shrink-0 w-[44px] h-[44px] flex items-center justify-center overflow-hidden">
						<img src="<?php echo get_template_directory_uri(); ?>/img/mark.svg" alt="check" class="w-[44px] h-[44px]">
					</div>
					<div>
						<h3 class="text-white text-[18px] font-semibold mb-1">
							<?php the_field('support_subheading4') ?>
						</h3>
						<p class="text-[#B8C0CC] text-[14px] leading-relaxed">
							<?php the_field('support_description4') ?>
						</p>
					</div>
				</div>
			</div>

			<!-- CTA Button -->
			<a href="<?php echo esc_url( home_url( '/catalog' ) ); ?>" class="inline-flex items-center justify-center bg-[#F97316] text-white text-[16px] font-medium px-8 py-[14px] rounded hover:bg-[#FB8A3C] transition-colors max-w-[220px]">
				Перейти в каталог
			</a>
		</div>
	</div>
</section>

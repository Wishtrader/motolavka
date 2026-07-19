<?php
/**
 * Template Name: Cookie Policy
 * Template for Cookie Policy page
 *
 * @package motorcycle-shop
 */

get_header();
?>
<div class="text-white w-full max-w-[1200px] mx-auto mt-[80px] md:mt-[50px]">
<!-- Breadcrumb -->
<nav class="flex items-center gap-2 text-[13px] mb-[60px]">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
		<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
		<span class="text-white lg:ml-2">Политика обработки файлов cookie</span>
</nav>
</div>
<?php

the_content();
get_footer();

<?php
/**
 * Template Name: Cookie Policy
 * Template for Cookie Policy page
 *
 * @package motorcycle-shop
 */

get_header();
get_header();
?>
<div class="text-white w-full max-w-[1200px] mx-auto md:mt-[190px]">
<!-- Breadcrumb -->
<nav class="flex items-center gap-2 text-sm">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
		<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
		<span class="text-white">Политика обработки файлов cookie</span>
</nav>
</div>
<?php

the_content();
get_footer();

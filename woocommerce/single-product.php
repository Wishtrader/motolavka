<?php
/**
 * Single product page.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

get_template_part( 'template-parts/catalog/form', 'form' );
get_footer();

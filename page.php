<?php
/**
 * Default page template.
 *
 * @package motorcycle-shop
 */

get_header();

while ( have_posts() ) :
	the_post();

	if ( ! is_cart() && ! is_checkout() && ! is_account_page() ) :
		?>
		<div class="w-full px-[10px] md:px-0 pt-[110px] md:pt-[130px] pb-8">
			<div class="max-w-[1200px] mx-auto">
				<?php the_title( '<h1 class="text-white text-[32px] md:text-[40px] font-bold mb-8">', '</h1>' ); ?>
			</div>
		</div>
		<?php
	endif;
	?>
	<div class="w-full px-[10px] md:px-0 pb-12 <?php echo is_cart() || is_checkout() ? '' : 'max-w-[1200px] mx-auto'; ?>">
		<div class="<?php echo is_cart() || is_checkout() ? '' : 'max-w-[1200px] mx-auto text-[#B8C0CC] entry-content'; ?>">
			<?php the_content(); ?>
		</div>
	</div>
	<?php
endwhile;

get_footer();

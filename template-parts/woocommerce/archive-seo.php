<?php
/**
 * SEO / info block below product grid on category archives.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_product_category() ) {
	return;
}

$term = get_queried_object();

if ( ! $term instanceof WP_Term ) {
	return;
}
?>

<section class="w-full fluid-section-py fluid-px">
	<div class="max-w-[1200px] mx-auto">
		<div class="bg-[#2A3038] rounded-[2px] border border-[#434C58]/40 p-6 md:p-10">
			<h2 class="text-white fluid-h3 font-bold mb-4 md:mb-6 leading-tight">
				<?php echo esc_html( motorcycle_shop_wc_category_seo_title( $term ) ); ?>
			</h2>
			<div class="text-white/90 fluid-body leading-relaxed space-y-4 [&_p]:mb-4 [&_p:last-child]:mb-0 [&_a]:text-[#FF6B00] [&_a]:hover:text-[#FB8A3C]">
				<?php echo motorcycle_shop_wc_category_seo_content( $term ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		</div>
	</div>
</section>

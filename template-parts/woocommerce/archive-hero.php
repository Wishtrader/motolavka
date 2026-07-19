<?php
/**
 * Hero section for WooCommerce product category archives.
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

$hero_image  = motorcycle_shop_wc_category_hero_image( $term );
$breadcrumbs = motorcycle_shop_wc_category_breadcrumbs( $term );
$description = ! empty( $term->description )
	? wp_strip_all_tags( $term->description )
	: motorcycle_shop_wc_category_default_description( $term );
$last_index  = count( $breadcrumbs ) - 1;
?>

<section class="relative bg-black overflow-hidden">
	<div class="relative min-h-[420px] md:min-h-[500px] lg:min-h-[560px]">
		<div
			class="absolute inset-0 bg-cover bg-right scale-105 blur-[3px]"
			style="background-image: url('<?php echo esc_url( $hero_image ); ?>');"
			role="img"
			aria-label="<?php echo esc_attr( $term->name ); ?>"
		></div>
		<div class="absolute inset-0 bg-black/75"></div>

		<div class="relative w-full max-w-[1200px] mx-auto fluid-px fluid-pt-page pb-12 md:pb-16">
			<nav class="flex flex-wrap items-center gap-2 text-[13px] mb-8 md:mb-[60px] mt-10" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
				<?php foreach ( $breadcrumbs as $index => $crumb ) : ?>
					<?php if ( $index > 0 ) : ?>
						<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
					<?php endif; ?>

					<?php if ( $index === $last_index || empty( $crumb['url'] ) ) : ?>
						<span class="text-[#FB8A3C] font-medium lg:ml-2"><?php echo esc_html( $crumb['label'] ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">
							<?php echo esc_html( $crumb['label'] ); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>

			<div class="max-w-[720px]">
				<h1 class="text-white fluid-h1 font-bold mb-6 leading-tight">
					<?php echo esc_html( $term->name ); ?>
				</h1>

				<p class="text-[#B8C0CC] fluid-body mb-8 md:mb-10 leading-relaxed">
					<?php echo esc_html( $description ); ?>
				</p>

				<?php
				motorcycle_shop_lead_modal_trigger(
					array(
						'source' => 'category',
						'class'  => 'inline-flex items-center justify-center bg-[#2A3038] text-white text-center min-h-[48px] px-8 py-4 rounded-[2px] w-full sm:w-auto sm:min-w-[285px] font-medium hover:bg-[#3C3C3C] transition-colors border border-[#434C58]',
					)
				);
				?>
			</div>
		</div>
	</div>
</section>

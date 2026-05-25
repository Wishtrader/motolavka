<?php
/**
 * Breadcrumbs — single product.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$breadcrumbs = motorcycle_shop_wc_product_breadcrumbs( $product );
$last_index  = count( $breadcrumbs ) - 1;
?>

<div class="w-full px-[10px] md:px-0 pt-[110px] md:pt-[130px] pb-6 md:pb-8">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex flex-wrap items-center gap-2 text-sm mt-10" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<?php foreach ( $breadcrumbs as $index => $crumb ) : ?>
				<?php if ( $index > 0 ) : ?>
					<svg class="w-4 h-4 text-[#FB8A3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
					</svg>
				<?php endif; ?>

				<?php if ( $index === $last_index || empty( $crumb['url'] ) ) : ?>
					<span class="text-white"><?php echo esc_html( $crumb['label'] ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $crumb['url'] ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">
						<?php echo esc_html( $crumb['label'] ); ?>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</nav>
	</div>
</div>

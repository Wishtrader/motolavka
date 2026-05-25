<?php
/**
 * Product image gallery.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

global $product;

$gallery_ids = motorcycle_shop_get_product_gallery_ids( $product );
$fallback    = get_template_directory_uri() . '/img/moto.png';
$thumb_count = count( $gallery_ids );

if ( $thumb_count > 0 ) {
	$main_id  = $gallery_ids[0];
	$main_url = wp_get_attachment_image_url( $main_id, 'full' )
		?: wp_get_attachment_image_url( $main_id, 'large' )
		?: $fallback;
} else {
	$main_url = $fallback;
}
?>

<style>
	.product-gallery [data-gallery-thumb] {
		box-sizing: border-box;
		border: 2px solid transparent;
		transition: border-color 0.2s ease;
	}
	.product-gallery [data-gallery-thumb].is-active {
		border-color: #ff6b00 !important;
	}
</style>

<div class="product-gallery w-full" data-product-gallery>
	<div class="bg-[#1F242B] rounded-[2px] overflow-hidden border border-[#434C58]/40">
		<img
			data-gallery-main
			src="<?php echo esc_url( $main_url ); ?>"
			alt="<?php echo esc_attr( $product->get_name() ); ?>"
			class="w-full aspect-[4/3] lg:aspect-[16/11] object-cover"
			decoding="async"
		/>
	</div>

	<?php if ( $thumb_count > 1 ) : ?>
		<div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mt-4" data-gallery-thumbs role="list">
			<?php foreach ( $gallery_ids as $index => $attachment_id ) : ?>
				<?php
				$thumb_url = wp_get_attachment_image_url( $attachment_id, 'woocommerce_thumbnail' )
					?: wp_get_attachment_image_url( $attachment_id, 'medium' )
					?: $fallback;
				$full_url  = wp_get_attachment_image_url( $attachment_id, 'full' )
					?: wp_get_attachment_image_url( $attachment_id, 'large' )
					?: $thumb_url;
				$is_first  = 0 === $index;
				$border    = $is_first ? '#ff6b00' : 'transparent';
				?>
				<button
					type="button"
					role="listitem"
					data-gallery-thumb
					data-full-url="<?php echo esc_url( $full_url ); ?>"
					onclick="return motorcycleShopSwitchProductImage(this);"
					class="rounded-[2px] overflow-hidden <?php echo $is_first ? 'is-active' : ''; ?> focus:outline-none focus:ring-2 focus:ring-[#FF6B00] cursor-pointer p-0 bg-transparent w-full"
					style="border: 2px solid <?php echo esc_attr( $border ); ?>;"
					aria-label="<?php echo esc_attr( sprintf( __( 'Изображение %d', 'motorcycle-shop' ), $index + 1 ) ); ?>"
					aria-pressed="<?php echo $is_first ? 'true' : 'false'; ?>"
				>
					<img
						src="<?php echo esc_url( $thumb_url ); ?>"
						alt=""
						class="w-full aspect-[4/3] object-cover block pointer-events-none select-none"
						loading="lazy"
						draggable="false"
					/>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

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
	
	/* Carousel container */
	.gallery-carousel-wrap {
		position: relative;
	}
	.gallery-carousel-viewport {
		overflow: hidden;
	}
	.gallery-carousel-track {
		display: flex;
		gap: 12px;
		transition: transform 0.3s ease;
	}
	.gallery-carousel-track [data-gallery-thumb] {
		width: calc((100% / 3) - 8px); /* 3 items minus gap */
		max-width: calc((100% / 3) - 8px);
		height: 134px;
	}
	/* Carousel arrows */
	.gallery-carousel-arrow {
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		width: 36px;
		height: 36px;
		background: #2A3038;
		border: 1px solid #434C58;
		color: #fff;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		transition: all 0.2s ease;
		z-index: 10;
	}
	.gallery-carousel-arrow:hover {
		background: #ff6b00;
		border-color: #ff6b00;
	}
	.gallery-carousel-arrow:disabled {
		opacity: 0.3;
		cursor: not-allowed;
	}
	.gallery-carousel-arrow.prev {
		left: -18px;
	}
	.gallery-carousel-arrow.next {
		right: -18px;
	}
	.gallery-carousel-arrow svg {
		width: 16px;
		height: 16px;
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
		<div class="gallery-carousel-wrap mt-4">
			<?php if ( $thumb_count > 3 ) : ?>
				<button type="button" class="gallery-carousel-arrow prev" data-gallery-prev aria-label="<?php esc_attr_e( 'Назад', 'motorcycle-shop' ); ?>">
					<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
					</svg>
				</button>
				<button type="button" class="gallery-carousel-arrow next" data-gallery-next aria-label="<?php esc_attr_e( 'Вперед', 'motorcycle-shop' ); ?>">
					<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
					</svg>
				</button>
			<?php endif; ?>
			
			<div class="gallery-carousel-viewport" data-gallery-viewport>
				<div class="gallery-carousel-track" data-gallery-track>
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
							data-gallery-thumb
							data-full-url="<?php echo esc_url( $full_url ); ?>"
							onclick="return motorcycleShopSwitchProductImage(this);"
							class="shrink-0 w-[80px] h-[60px] md:w-[100px] md:h-[75px] rounded-[2px] overflow-hidden flex items-center justify-center <?php echo $is_first ? 'is-active' : ''; ?> focus:outline-none focus:ring-2 focus:ring-[#FF6B00] cursor-pointer p-0 bg-transparent"
							style="border: 2px solid <?php echo esc_attr( $border ); ?>;"
							aria-label="<?php echo esc_attr( sprintf( __( 'Изображение %d', 'motorcycle-shop' ), $index + 1 ) ); ?>"
							aria-pressed="<?php echo $is_first ? 'true' : 'false'; ?>"
						>
							<img
								src="<?php echo esc_url( $thumb_url ); ?>"
								alt=""
								class="w-full h-full object-cover block pointer-events-none select-none"
								loading="lazy"
								draggable="false"
							/>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

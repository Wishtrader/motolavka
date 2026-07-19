<?php
/**
 * Cart page template.
 *
 * @package motorcycle-shop
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );
?>

<div class="w-full fluid-px pt-[110px] md:pt-[130px] pb-10 md:pb-14">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[50px]" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
			<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
			<span class="text-white lg:ml-2">Корзина</span>
		</nav>

		<h1 class="text-white text-[32px] md:text-[40px] font-bold leading-tight mb-8 md:mb-10">Корзина</h1>

		<?php if ( function_exists( 'wc_print_notices' ) ) : ?>
			<div class="woocommerce-notices-wrapper mb-6"><?php wc_print_notices(); ?></div>
		<?php endif; ?>

		<div data-cart-page-root class="transition-opacity">
			<form class="woocommerce-cart-form motorcycle-shop-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 lg:gap-10 items-start">
					<div class="flex flex-col gap-4" data-cart-items>
						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								continue;
							}

							$product_name     = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							$subtitle         = motorcycle_shop_cart_item_subtitle( $_product );
							$image_url        = motorcycle_shop_cart_item_image_url( $_product );
							$line_price       = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

							if ( $_product->is_sold_individually() ) {
								$min_quantity = 1;
								$max_quantity = 1;
							} else {
								$min_quantity = 1;
								$max_quantity = $_product->get_max_purchase_quantity();
							}
							?>
							<article class="woocommerce-cart-form__cart-item bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-4 <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
								<div class="flex flex-col lg:flex-row gap-4 lg:gap-10 items-start lg:items-center">
									<!-- Image (full width on mobile, fixed on desktop) -->
									<div class="w-full lg:w-auto shrink-0">
										<?php if ( $product_permalink ) : ?>
											<a href="<?php echo esc_url( $product_permalink ); ?>" class="block w-full h-[140px] md:h-[160px] lg:w-[160px] lg:h-[120px] rounded-[8px] overflow-hidden bg-[#1F242B] bg-cover">
												<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product_name ); ?>" class="w-full rounded-[8px] h-full object-cover" />
											</a>
										<?php else : ?>
											<div class="block w-full h-[140px] md:h-[160px] lg:w-[120px] lg:h-[90px] rounded-[8px] overflow-hidden bg-[#1F242B]">
												<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $product_name ); ?>" class="w-full rounded-[8px] h-full object-cover" />
											</div>
										<?php endif; ?>
									</div>

									<!-- Product info (name + subtitle) -->
									<div class="flex-1 min-w-0 lg:max-w-[200px]">
										<?php if ( $product_permalink ) : ?>
											<a href="<?php echo esc_url( $product_permalink ); ?>" class="block text-white text-[20px] md:text-lg lg:text-xl font-normal hover:text-[#FB8A3C] transition-colors truncate">
												<?php echo esc_html( $product_name ); ?>
											</a>
										<?php else : ?>
											<h2 class="text-white text-[20px] md:text-lg lg:text-xl font-normal truncate"><?php echo esc_html( $product_name ); ?></h2>
										<?php endif; ?>

										<?php if ( $subtitle ) : ?>
											<p class="text-[#B8C0CC] text-[14px] md:text-sm mt-1 truncate"><?php echo esc_html( $subtitle ); ?></p>
										<?php endif; ?>
									</div>
<div class="flex items-center gap-4 justify-between w-full lg:w-auto lg:gap-6 lg:shrink-0">
									<!-- Quantity counter -->
									<div class="shrink-0">
										<div class="flex items-stretch h-[44px]">
											<button type="button" data-cart-qty-minus class="w-11 bg-[#1F242B] text-white text-[24px] hover:bg-[#111317] transition-colors rounded-l-[2px]" aria-label="<?php esc_attr_e( 'Уменьшить', 'motorcycle-shop' ); ?>">−</button>
											<label class="sr-only" for="cart-qty-<?php echo esc_attr( $cart_item_key ); ?>"><?php esc_html_e( 'Количество', 'motorcycle-shop' ); ?></label>
											<input
												type="number"
												id="cart-qty-<?php echo esc_attr( $cart_item_key ); ?>"
												data-cart-qty-input
												class="w-[12px] bg-[#1F242B] text-white text-center text-[20px] font-semibold focus:outline-none focus:ring-2 focus:ring-[#FF6B00] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
												name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
												value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
												min="<?php echo esc_attr( $min_quantity ); ?>"
												<?php echo 0 < $max_quantity ? 'max="' . esc_attr( $max_quantity ) . '"' : ''; ?>
												step="1"
												inputmode="numeric"
											/>
											<button type="button" data-cart-qty-plus class="w-11 bg-[#1F242B] text-white text-[24px] hover:bg-[#111317] transition-colors rounded-r-[2px]" aria-label="<?php esc_attr_e( 'Увеличить', 'motorcycle-shop' ); ?>">+</button>
										</div>
									</div>

									<!-- Price -->
									<div class="shrink-0">
										<div class="text-white text-3xl md:text-[32px] font-['Nata Sans' font-semibold">
											<?php echo wp_kses_post( $line_price ); ?>
										</div>
									</div>
</div>
									<!-- Remove button -->
									<div class="shrink-0 lg:ml-auto">
										<button
											type="button"
											data-cart-remove
											data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
											class="p-2 text-white/70 hover:text-[#FF6B00] transition-colors"
											aria-label="<?php echo esc_attr( sprintf( __( 'Удалить %s', 'motorcycle-shop' ), $product_name ) ); ?>"
										>
											<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m2-3h6a1 1 0 011 1v1H8V5a1 1 0 011-1z"/>
											</svg>
										</button>
									</div>
								</div>
							</article>
							<?php
						}
						?>
					</div>

					<div class="lg:sticky lg:top-[140px]" data-cart-totals>
						<?php woocommerce_cart_totals(); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

				<button type="submit" class="hidden" name="update_cart" value="1" data-cart-update-submit aria-hidden="true" tabindex="-1">Update</button>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>
		</div>
	</div>
</div>

<?php
do_action( 'woocommerce_after_cart' );

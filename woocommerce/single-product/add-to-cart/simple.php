<?php
/**
 * Simple product add to cart — custom layout.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 10.2.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

if ( ! $product->is_in_stock() ) {
	return;
}

$min_qty    = max( 1, (int) $product->get_min_purchase_quantity() );
$max_qty    = $product->get_max_purchase_quantity();
$cart_action = function_exists( 'motorcycle_shop_cart_page_url' )
	? motorcycle_shop_cart_page_url( '' )
	: wc_get_cart_url();
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form
	class="cart flex flex-col gap-4"
	method="post"
	enctype="multipart/form-data"
	action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $cart_action ) ); ?>"
>
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<div class="flex flex-row gap-3 sm:gap-4">
		<div class="flex items-stretch h-[52px] flex-1 min-w-0">
			<button
				type="button"
				data-qty-minus
				class="w-16 bg-[#2A3038]/60 text-white text-3xl font-plex hover:bg-[#1F242B] transition-colors rounded-l-[2px]"
				aria-label="<?php esc_attr_e( 'Уменьшить количество', 'motorcycle-shop' ); ?>"
			>−</button>
			<label class="sr-only" for="quantity_<?php echo esc_attr( $product->get_id() ); ?>"><?php esc_html_e( 'Количество', 'motorcycle-shop' ); ?></label>
			<input
				type="number"
				id="quantity_<?php echo esc_attr( $product->get_id() ); ?>"
				data-qty-input
				class="w-16 sm:w-16 bg-[#2A3038]/60 text-white font-plex text-center text-xl font-semibold focus:outline-none focus:ring-2 focus:ring-[#FF6B00] [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
				name="quantity"
				value="<?php echo esc_attr( $min_qty ); ?>"
				min="<?php echo esc_attr( $min_qty ); ?>"
				<?php echo 0 < $max_qty ? 'max="' . esc_attr( $max_qty ) . '"' : ''; ?>
				step="1"
				inputmode="numeric"
			/>
			<button
				type="button"
				data-qty-plus
				class="w-16 bg-[#2A3038]/60 text-white text-3xl font-plex hover:bg-[#1F242B] transition-colors rounded-r-[2px]"
				aria-label="<?php esc_attr_e( 'Увеличить количество', 'motorcycle-shop' ); ?>"
			>+</button>
		</div>

		<button
			type="submit"
			name="add-to-cart"
			value="<?php echo esc_attr( $product->get_id() ); ?>"
			data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
			data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
			data-quantity="<?php echo esc_attr( $min_qty ); ?>"
			class="single_add_to_cart_button add_to_cart_button product_type_<?php echo esc_attr( $product->get_type() ); ?> flex-1 min-h-[52px] flex items-center justify-center rounded-[2px] bg-[#FF6B00] text-white text-base font-semibold hover:bg-[#E55A00] transition-colors"
		>
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>
	</div>

	<?php
	motorcycle_shop_lead_modal_trigger(
		array(
			'source' => 'product',
			'class'  => 'flex w-full min-h-[52px] items-center justify-center rounded-[2px] bg-[#2A3038] text-white text-base font-semibold border border-[#434C58] hover:bg-[#1F242B] transition-colors',
		)
	);
	?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

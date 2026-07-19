<?php

/**
 * Checkout order review sidebar.
 *
 * @package motorcycle-shop
 * @version 5.2.0
 */

defined('ABSPATH') || exit();
?>

<div class="shop_table woocommerce-checkout-review-order-table">

	<h2 class="text-white text-xl md:text-[24px] font-normal mb-4">Ваш заказ</h2>
	<div class="h-[1px] w-full bg-[#FF6B00]"></div>

	<?php do_action('woocommerce_review_order_before_cart_contents'); ?>

	<div class="flex flex-col">
		<?php

		$visible_items = array();

		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    		$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

    		if (
        		!$_product
        		|| !$_product->exists()
        		|| $cart_item['quantity'] <= 0
        		|| !apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)
    		) {
        		continue;
    		}

    		$visible_items[] = array(
        		'cart_item_key' => $cart_item_key,
        		'cart_item' => $cart_item,
        		'product' => $_product,
    		);
		}

		$items_count = count($visible_items);

		foreach ($visible_items as $index => $item) {
    		$cart_item_key = $item['cart_item_key'];
    		$cart_item = $item['cart_item'];
    		$_product = $item['product'];
    		$line_price = apply_filters(
        		'woocommerce_cart_item_subtotal',
        		WC()->cart->get_product_subtotal($_product, $cart_item['quantity']),
        		$cart_item,
        		$cart_item_key,
    		);
    		$is_last = $index === ($items_count - 1);
    		?>
			<div class="py-5 <?php echo
    			esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key))
			; ?>">
				<div class="flex items-start justify-between gap-4">
					<div class="min-w-0">
						<p class="text-white !text-lg font-semibold leading-snug"><?php echo esc_html($_product->get_name()); ?></p>
						<p class="text-[#B8C0CC] text-sm mt-1"><?php echo esc_html(sprintf('%d шт', (int) $cart_item['quantity'])); ?></p>
						<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="text-white text-base font-bold shrink-0 text-right product-total">
						<?php echo wp_kses_post($line_price); ?>
					</div>
				</div>
			</div>
			<?php if (!$is_last): ?>
				<div class="h-[1px] w-full bg-[#FF6B00]" aria-hidden="true"></div>
			<?php endif; ?>
			<?php
		}
		?>
	</div>

	<?php do_action('woocommerce_review_order_after_cart_contents'); ?>

	<?php if ($items_count > 0): ?>
		<div class="h-[1px] w-full bg-[#FF6B00]" aria-hidden="true"></div>
	<?php endif; ?>

	<?php do_action('woocommerce_review_order_before_order_total'); ?>

	<div class="flex items-baseline justify-between gap-4 py-6 order-total-row">
		<span class="text-[#B8C0CC] text-lg md:text-[24px] font-normal">Итого:</span>
		<span class="text-white text-xl md:text-2xl font-bold order-total-value"><?php wc_cart_totals_order_total_html(); ?></span>
	</div>

	<?php do_action('woocommerce_review_order_after_order_total'); ?>
</div>

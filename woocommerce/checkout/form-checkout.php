<?php

/**
 * Checkout form layout.
 *
 * @package motorcycle-shop
 * @version 9.4.0
 */

defined('ABSPATH') || exit();

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo
        esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __(
            'You must be logged in to checkout.',
            'woocommerce',
        )))
    ;
    return;
}
?>

<div class="w-full fluid-px pt-[110px] md:pt-[130px] pb-10 md:pb-14">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex items-center gap-2 text-[13px] mb-[60px] mt-[80px] md:mt-[50px]" aria-label="<?php esc_attr_e(
    		'Breadcrumb',
    		'motorcycle-shop',
		); ?>">
			<a href="<?php echo
    			esc_url(home_url('/'))
			; ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Главная</a>
			<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
			<a href="<?php echo
    			esc_url(home_url('/cart'))
			; ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors lg:mr-3">Корзина</a>
			<img src="<?php echo get_template_directory_uri() . '/img/arr.svg'; ?>" alt="arrow">
			<span class="text-white lg:ml-2">Оформление заказа</span>
		</nav>

		<h1 class="text-white text-[34px] md:text-[53px] font-bold leading-tight mb-8 md:mb-10">Оформление заказа</h1>

		<?php if (function_exists('wc_print_notices')): ?>
			<div class="woocommerce-notices-wrapper mb-6"><?php wc_print_notices(); ?></div>
		<?php endif; ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo
    		esc_url(wc_get_checkout_url())
		; ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__('Checkout', 'woocommerce'); ?>">

			<div class="grid grid-cols-1 md:grid-cols-[1fr_360px] gap-[20px]">
				<div class="flex flex-col justify-start">
					<?php if ($checkout->get_checkout_fields()): ?>
						<?php do_action('woocommerce_checkout_before_customer_details'); ?>

						<div id="customer_details" class="flex flex-col gap-6 md:-mt-6">
							<?php do_action('woocommerce_checkout_billing'); ?>
							<?php get_template_part('template-parts/woocommerce/checkout/delivery', 'options'); ?>
						</div>

						<?php do_action('woocommerce_checkout_after_customer_details'); ?>
					<?php endif; ?>
				</div>

				<div class="lg:sticky lg:top-[140px]">
					<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
					<?php do_action('woocommerce_checkout_before_order_review'); ?>

					<div id="order_review" class="woocommerce-checkout-review-order bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-2.5 md:px-[25px] md:py-5">
						<?php do_action('woocommerce_checkout_order_review'); ?>
					</div>

					<?php do_action('woocommerce_checkout_after_order_review'); ?>
				</div>
			</div>

		</form>
	</div>
</div>

<?php

do_action('woocommerce_after_checkout_form', $checkout);

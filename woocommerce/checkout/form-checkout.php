<?php
/**
 * Checkout form layout.
 *
 * @package motorcycle-shop
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<div class="w-full px-[10px] md:px-0 pt-[110px] md:pt-[130px] pb-10 md:pb-14">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex flex-wrap items-center gap-2 text-sm mb-6 md:mt-[60px] md:mb-8" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
			<svg class="w-4 h-4 text-[#FB8A3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
			</svg>
			<span class="text-white">Оформление заказа</span>
		</nav>

		<h1 class="text-white text-[32px] md:text-[40px] font-bold leading-tight mb-8 md:mb-10">Оформление заказа</h1>

		<?php if ( function_exists( 'wc_print_notices' ) ) : ?>
			<div class="woocommerce-notices-wrapper mb-6"><?php wc_print_notices(); ?></div>
		<?php endif; ?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

			<div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-8 lg:gap-10 items-start">
				<div class="flex flex-col gap-6">
					<?php if ( $checkout->get_checkout_fields() ) : ?>
						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

						<div id="customer_details" class="flex flex-col gap-6">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
							<?php get_template_part( 'template-parts/woocommerce/checkout/delivery', 'options' ); ?>
						</div>

						<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
					<?php endif; ?>
				</div>

				<div class="lg:sticky lg:top-[140px]">
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order bg-[#2A3038] border border-[#434C58]/50 rounded-[2px] p-6 md:p-8">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</div>
			</div>

		</form>
	</div>
</div>

<?php
do_action( 'woocommerce_after_checkout_form', $checkout );

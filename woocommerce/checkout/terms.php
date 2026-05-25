<?php
/**
 * Checkout terms checkbox styling.
 *
 * @package motorcycle-shop
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! apply_filters( 'woocommerce_checkout_show_terms', true ) ) {
	return;
}

do_action( 'woocommerce_checkout_before_terms_and_conditions' );
?>

<div class="woocommerce-terms-and-conditions-wrapper">
	<?php do_action( 'woocommerce_checkout_terms_and_conditions' ); ?>

	<?php if ( function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) && wc_terms_and_conditions_checkbox_enabled() ) : ?>
		<p class="form-row validate-required mb-0">
			<label class="inline-flex items-start gap-3 cursor-pointer" for="terms">
				<input
					type="checkbox"
					class="peer sr-only"
					name="terms"
					id="terms"
					<?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>
				/>
				<span class="relative w-[32px] h-[32px] shrink-0 rounded-[2px] bg-[#FF6B00] flex items-center justify-center hover:brightness-95 transition-[filter] peer-checked:[&_svg]:opacity-100">
					<svg
						class="w-6 h-6 text-white opacity-0 transition-opacity duration-150"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="3"
						stroke-linecap="round"
						stroke-linejoin="round"
						aria-hidden="true"
					>
						<path d="M20 6L9 17l-5-5" />
					</svg>
				</span>
				<span class="select-none text-[#B8C0CC] text-xs md:text-sm leading-[1.4] pt-1">
					<?php wc_terms_and_conditions_checkbox_text(); ?>
				</span>
			</label>
			<input type="hidden" name="terms-field" value="1" />
		</p>
	<?php else : ?>
		<label class="inline-flex items-start gap-3 cursor-pointer">
			<input type="checkbox" class="peer sr-only" checked disabled />
			<span class="relative w-[32px] h-[32px] shrink-0 rounded-[2px] bg-[#FF6B00] flex items-center justify-center">
				<svg
					class="w-6 h-6 text-white"
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					stroke-width="3"
					stroke-linecap="round"
					stroke-linejoin="round"
					aria-hidden="true"
				>
					<path d="M20 6L9 17l-5-5" />
				</svg>
			</span>
			<span class="select-none text-[#B8C0CC] text-xs md:text-sm leading-[1.4] pt-1">
				Продолжая, вы соглашаетесь с политикой конфиденциальности
			</span>
		</label>
	<?php endif; ?>
</div>

<?php
do_action( 'woocommerce_checkout_after_terms_and_conditions' );

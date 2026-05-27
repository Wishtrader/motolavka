<?php
/**
 * Lead request modal (homepage hero).
 *
 * @package motorcycle-shop
 */

$theme_uri          = get_template_directory_uri();
$privacy_policy_url = function_exists( 'motorcycle_shop_privacy_policy_url' )
	? motorcycle_shop_privacy_policy_url()
	: home_url( '/privacy-policy/' );
$lead_error         = isset( $_GET['lead_error'] ) ? sanitize_text_field( wp_unslash( $_GET['lead_error'] ) ) : '';
$is_inline_error    = ! empty( $_GET['lead_inline'] );
$lead_error_message = ( $lead_error && ! $is_inline_error ) ? motorcycle_shop_lead_get_error_message( $lead_error ) : '';
?>

<div
	id="lead-modal"
	class="fixed inset-0 z-[100] hidden items-center justify-center p-4 md:p-6"
	role="dialog"
	aria-modal="true"
	aria-labelledby="lead-modal-title"
	aria-hidden="true"
	data-lead-modal
	<?php echo $lead_error_message ? ' data-lead-open-on-load="1"' : ''; ?>
>
	<div class="absolute inset-0 bg-black/70" data-lead-modal-close tabindex="-1" aria-hidden="true"></div>

	<div class="relative w-full max-w-[560px] max-h-[90vh] overflow-y-auto">
		<div class="relative overflow-hidden rounded-[2px]">
			<div class="absolute inset-0 bg-[url('<?php echo esc_url( $theme_uri . '/img/moto3.png' ); ?>')] bg-cover bg-center"></div>
			<div class="absolute inset-0 bg-[#171A1F]/85"></div>

			<div class="relative px-6 py-8 md:px-10 md:py-10">
				<button
					type="button"
					class="absolute top-4 right-4 md:top-5 md:right-5 text-[#FF6B00] hover:text-[#FB8A3C] transition-colors p-2"
					data-lead-modal-close
					aria-label="<?php esc_attr_e( 'Закрыть', 'motorcycle-shop' ); ?>"
				>
					<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
					</svg>
				</button>

				<h2 id="lead-modal-title" class="text-white text-[28px] md:text-[32px] font-bold text-center mb-4 pr-10">
					Оставьте заявку
				</h2>
				<p class="text-white text-sm md:text-base text-center leading-relaxed mb-6 md:mb-8">
					Свяжемся с вами, подскажем по наличию, поможем с выбором техники, запчастей или аксессуаров и ответим на вопросы по заказу.
				</p>

				<?php if ( $lead_error_message ) : ?>
					<p class="text-[#FF6B00] text-sm text-center mb-4" data-lead-error role="alert">
						<?php echo esc_html( $lead_error_message ); ?>
					</p>
				<?php endif; ?>

				<form
					method="post"
					action=""
					class="flex flex-col gap-3"
					data-lead-form
				>
					<input type="hidden" name="motorcycle_shop_lead_submit" value="1">
					<?php wp_nonce_field( 'motorcycle_shop_submit_lead', 'motorcycle_shop_lead_nonce' ); ?>
					<input type="hidden" name="lead_source" value="hero">

					<input
						type="text"
						name="lead_name"
						required
						minlength="2"
						autocomplete="name"
						class="w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
						placeholder="Имя"
					/>

					<input
						type="tel"
						name="lead_phone"
						required
						autocomplete="tel"
						class="w-full text-white text-sm font-normal bg-[#2A3038] border border-[#434C58] p-[20px] rounded-[2px] placeholder:text-white focus:outline-none focus:ring-2 focus:ring-[#FF6B00]"
						placeholder="Телефон"
					/>

					<label class="inline-flex items-start gap-3 cursor-pointer mt-1">
						<input type="checkbox" name="lead_privacy" value="1" class="peer sr-only" required checked />
						<span class="relative w-[32px] h-[32px] shrink-0 rounded-[2px] bg-[#FF6B00] flex items-center justify-center hover:brightness-95 transition-[filter] peer-checked:[&_svg]:opacity-100">
							<svg
								class="w-6 h-6 text-white opacity-100 transition-opacity duration-150"
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
						<span class="select-none text-white text-sm leading-[1.4] pt-1">
							Продолжая, вы соглашаетесь с
							<a href="<?php echo esc_url( $privacy_policy_url ); ?>" class="text-[#FF6B00] hover:text-[#FB8A3C] underline underline-offset-2" target="_blank" rel="noopener noreferrer">политикой конфиденциальности</a>
						</span>
					</label>

					<button
						type="submit"
						class="flex w-full mt-3 items-center justify-center rounded-[2px] bg-[#FF6B00] text-white px-4 py-[16px] text-base font-semibold hover:bg-[#E55A00] transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
					>
						Отправить заявку
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

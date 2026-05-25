<?php
/**
 * Catalog ordering — custom Tailwind markup.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package motorcycle-shop
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mb-8 md:mb-10">
	<span class="text-[#B8C0CC] text-sm shrink-0">Сортировка:</span>
	<form class="woocommerce-ordering w-full sm:w-auto" method="get">
		<div class="relative w-full sm:w-auto sm:min-w-[240px]">
			<select
				name="orderby"
				class="orderby w-full bg-[#2A3038] border border-[#FF6B00] text-white text-sm rounded-[2px] pl-4 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-[#FF6B00]/50 appearance-none cursor-pointer"
				aria-label="<?php esc_attr_e( 'Сортировка товаров', 'motorcycle-shop' ); ?>"
				onchange="this.form.submit()"
			>
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#FF6B00]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
			</svg>
		</div>
		<input type="hidden" name="paged" value="1" />
		<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
	</form>
</div>

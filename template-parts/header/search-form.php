<?php
/**
 * Header product search form.
 *
 * @package motorcycle-shop
 *
 * @var string $variant desktop|mobile
 */

defined( 'ABSPATH' ) || exit;

$variant = isset( $args['variant'] ) ? $args['variant'] : 'desktop';
$is_mobile = 'mobile' === $variant;

$input_id    = $is_mobile ? 'header-search-mobile' : 'header-search-desktop';
$input_class = $is_mobile
	? 'w-full bg-white text-gray-800 px-4 py-3 pl-11 pr-4 rounded-[2px] text-sm focus:outline-none focus:ring-2 focus:ring-[#FF6B00]'
	: 'w-full bg-white text-[#1A1F26] px-4 py-2.5 h-[48px] pl-[54px] pr-4 rounded-[2px] text-sm focus:outline-none focus:ring-2 focus:ring-[#FF6B00]';

$search_query = get_search_query();
?>

<form
	role="search"
	method="get"
	class="relative w-full"
	action="<?php echo esc_url( motorcycle_shop_get_search_url() ); ?>"
>
	<label class="sr-only" for="<?php echo esc_attr( $input_id ); ?>">
		<?php esc_html_e( 'Поиск по каталогу', 'motorcycle-shop' ); ?>
	</label>

	<input
		type="search"
		id="<?php echo esc_attr( $input_id ); ?>"
		name="s"
		value="<?php echo esc_attr( $search_query ); ?>"
		placeholder="<?php esc_attr_e( 'Поиск', 'motorcycle-shop' ); ?>"
		class="<?php echo esc_attr( $input_class ); ?>"
		required
		minlength="2"
		autocomplete="off"
	/>

	<input type="hidden" name="post_type" value="product" />

	<button
		type="submit"
		class="absolute top-1/2 -translate-y-1/2 <?php echo $is_mobile ? 'left-3' : 'left-[18px]'; ?> p-1 hover:opacity-80 transition-opacity"
		aria-label="<?php esc_attr_e( 'Найти', 'motorcycle-shop' ); ?>"
	>
		<?php if ( $is_mobile ) : ?>
			<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
			</svg>
		<?php else : ?>
			<img src="<?php echo esc_url( get_template_directory_uri() . '/img/search-outline.svg' ); ?>" alt="" width="20" height="20" />
		<?php endif; ?>
	</button>
</form>

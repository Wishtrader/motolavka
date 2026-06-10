<?php
/**
 * Search results (products).
 *
 * @package motorcycle-shop
 */

get_header();

$search_query      = get_search_query();
$is_product_search = motorcycle_shop_is_product_search();
?>

<div class="w-full fluid-px fluid-pt-page pb-6 md:pb-8">
	<div class="max-w-[1200px] mx-auto">
		<nav class="flex flex-wrap items-center gap-2 text-sm mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'motorcycle-shop' ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-[#FB8A3C] transition-colors">Главная</a>
			<svg class="w-4 h-4 text-[#FB8A3C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
			</svg>
			<span class="text-white">Поиск</span>
		</nav>

		<h1 class="text-white fluid-h2 font-bold leading-tight mb-4">
			<?php if ( $search_query ) : ?>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Результаты по запросу «%s»', 'motorcycle-shop' ),
					esc_html( $search_query )
				);
				?>
			<?php else : ?>
				<?php esc_html_e( 'Поиск по каталогу', 'motorcycle-shop' ); ?>
			<?php endif; ?>
		</h1>

		<div class="max-w-[400px] mb-8">
			<?php get_template_part( 'template-parts/header/search-form', null, array( 'variant' => 'desktop' ) ); ?>
		</div>
	</div>
</div>

<section class="w-full py-6 md:py-10 fluid-px">
	<div class="max-w-[1200px] mx-auto">
		<?php if ( have_posts() && $is_product_search && class_exists( 'WooCommerce' ) ) : ?>

			<p class="text-[#B8C0CC] text-sm mb-6">
				<?php
				global $wp_query;
				printf(
					/* translators: %d: number of products found */
					esc_html( _n( 'Найден %d товар', 'Найдено %d товаров', (int) $wp_query->found_posts, 'motorcycle-shop' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
				<?php
				while ( have_posts() ) :
					the_post();
					$GLOBALS['product'] = wc_get_product( get_the_ID() );
					if ( $GLOBALS['product'] ) {
						wc_get_template_part( 'content', 'product' );
					}
				endwhile;
				?>
			</div>

			<?php
			$pagination = paginate_links(
				array(
					'type'      => 'list',
					'prev_next' => false,
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $GLOBALS['wp_query']->max_num_pages,
				)
			);
			if ( $pagination ) :
				?>
				<nav class="flex justify-center mt-10 [&_ul]:flex [&_ul]:gap-2 [&_ul]:list-none [&_li]:m-0 [&_a]:inline-flex [&_a]:min-w-[40px] [&_a]:h-[40px] [&_a]:items-center [&_a]:justify-center [&_a]:rounded-[2px] [&_a]:bg-[#2A3038] [&_a]:text-white [&_a]:border [&_a]:border-[#434C58] [&_a]:hover:bg-[#FF6B00] [&_.current]:bg-[#FF6B00] [&_.current]:border-[#FF6B00] [&_.current]:text-white [&_.current]:font-semibold" aria-label="<?php esc_attr_e( 'Навигация', 'motorcycle-shop' ); ?>">
					<?php echo wp_kses_post( $pagination ); ?>
				</nav>
			<?php endif; ?>

		<?php elseif ( have_posts() ) : ?>

			<div class="space-y-4">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'search' );
				endwhile;
				?>
			</div>

		<?php else : ?>

			<div class="bg-[#2A3038] border border-[#434C58] rounded-[2px] p-8 md:p-12 text-center">
				<p class="text-white text-xl font-bold mb-3">Ничего не найдено</p>
				<p class="text-[#B8C0CC] text-base mb-8">
					Попробуйте другой запрос или перейдите в каталог.
				</p>
				<a
					href="<?php echo esc_url( home_url( '/catalog/' ) ); ?>"
					class="inline-flex items-center justify-center rounded-[2px] bg-[#FF6B00] text-white px-8 py-4 text-base font-semibold hover:bg-[#E55A00] transition-colors"
				>
					Перейти в каталог
				</a>
			</div>

		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/home/form', 'form' );
get_footer();

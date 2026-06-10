<?php
/**
 * Description and full attributes table.
 *
 * @package motorcycle-shop
 */

defined( 'ABSPATH' ) || exit;

global $product;

$description = $product->get_short_description();
$attr_rows   = motorcycle_shop_get_product_attribute_rows( $product );
?>

<div class="flex md:max-w-[692px] flex-col gap-10 md:gap-12 min-w-0">
	<?php if ( $description ) : ?>
		<div>
			<h2 class="text-white text-[22px] md:text-[32px] font-normal mb-4 md:mb-6">Описание</h2>
			<div class="text-[#B8C0CC] text-[15px] md:text-base leading-relaxed space-y-4 [&_p]:mb-4 [&_p:last-child]:mb-0 [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
				<?php echo wp_kses_post( wpautop( $description ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $attr_rows ) ) : ?>
		<div>
			<h2 class="text-white text-[22px] md:text-[32px] font-normal mb-4 md:mb-6">Характеристики</h2>
			<div class="overflow-x-auto -mx-[10px] fluid-px md:mx-0">
				<table class="w-full min-w-[480px] border-collapse text-left text-sm md:text-base">
					<tbody>
						<?php foreach ( $attr_rows as $index => $row ) : ?>
							<tr class="<?php echo 0 === $index % 2 ? 'bg-[#2A3038]' : 'bg-[#232830]'; ?>">
								<th scope="row" class="text-[#B8C0CC] font-normal px-4 md:px-5 py-3 md:py-4 w-[45%] align-top">
									<?php echo esc_html( $row['label'] ); ?>
								</th>
								<td class="text-white font-medium px-4 md:px-5 py-3 md:py-4 align-top">
									<?php echo esc_html( $row['value'] ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>

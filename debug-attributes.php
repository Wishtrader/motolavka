<?php
/**
 * Debug product attributes.
 * Access via: yoursite.com/wp-content/themes/motorcycle-shop/debug-attributes.php
 */

defined( 'ABSPATH' ) || exit;

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( 'Access denied' );
}

// Get first product
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 1,
	'post_status'    => 'publish',
);

$products = new WP_Query( $args );

if ( ! $products->have_posts() ) {
	wp_die( 'No products found' );
}

$products->the_post();
$product = wc_get_product( get_the_ID() );

if ( ! $product ) {
	wp_die( 'Invalid product' );
}

echo '<h1>Product: ' . esc_html( $product->get_name() ) . '</h1>';
echo '<h2>Attributes:</h2>';
echo '<pre>';

foreach ( $product->get_attributes() as $attr ) {
	$slug = $attr->get_name();
	$value = $product->get_attribute( $slug );
	$type = $attr->is_taxonomy() ? 'taxonomy' : 'custom';
	$visible = $attr->get_visible() ? 'visible' : 'hidden';
	
	echo "Slug: {$slug}\n";
	echo "Type: {$type}\n";
	echo "Visible: {$visible}\n";
	echo "Value: {$value}\n";
	echo "---\n";
}

echo '</pre>';

echo '<h2>Product Terms:</h2>';
echo '<pre>';

// Check all possible volume attributes
$possible_slugs = array( 'pa_cc', 'pa_volume', 'pa_engine-volume', 'cc', 'volume', 'pa_engine_volume', 'pa_engine-volume' );
foreach ( $possible_slugs as $slug ) {
	$terms = wc_get_product_terms( $product->get_ID(), $slug, array( 'fields' => 'all' ) );
	if ( ! empty( $terms ) ) {
		echo "Found terms in {$slug}:\n";
		foreach ( $terms as $term ) {
			echo "  - {$term->name} (slug: {$term->slug})\n";
		}
	}
}

echo '</pre>';

<?php
/**
 * Debug page for brand thumbnails
 * Access via: yoursite.com/?debug-brands=1
 */

if ( ! isset( $_GET['debug-brands'] ) || $_GET['debug-brands'] !== '1' ) {
    wp_die( 'Access denied' );
}

if ( ! current_user_can( 'manage_woocommerce' ) ) {
    wp_die( 'Permission denied' );
}

$brands = get_terms( array(
    'taxonomy'   => 'product_brand',
    'hide_empty' => false,
) );

if ( empty( $brands ) || is_wp_error( $brands ) ) {
    echo '<p>Бренды не найдены</p>';
    exit;
}

echo '<h1>Debug: Product Brands (' . count( $brands ) . ')</h1>';
echo '<table border="1" cellpadding="10" style="border-collapse:collapse;width:100%;">';
echo '<tr><th>ID</th><th>Название</th><th>thumbnail_id</th><th>logo</th><th>Все мета-поля</th><th>URL изображения</th></tr>';

foreach ( $brands as $brand ) {
    $thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
    $logo_id      = get_term_meta( $brand->term_id, 'logo', true );
    $all_meta     = get_term_meta( $brand->term_id );
    
    $image_url = '';
    if ( $thumbnail_id ) {
        $image_url = wp_get_attachment_image_url( $thumbnail_id, 'medium' );
    } elseif ( $logo_id ) {
        $image_url = wp_get_attachment_image_url( $logo_id, 'medium' );
    }
    
    echo '<tr>';
    echo '<td>' . esc_html( $brand->term_id ) . '</td>';
    echo '<td>' . esc_html( $brand->name ) . '</td>';
    echo '<td>' . esc_html( $thumbnail_id ) . '</td>';
    echo '<td>' . esc_html( $logo_id ) . '</td>';
    echo '<td><pre>' . print_r( $all_meta, true ) . '</pre></td>';
    echo '<td>' . ( $image_url ? '<a href="' . esc_url( $image_url ) . '" target="_blank">' . basename( $image_url ) . '</a>' : 'Нет изображения' ) . '</td>';
    echo '</tr>';
}

echo '</table>';

<?php
/**
 * مسار التميز — مقارنة المنتجات (WooCommerce): لحد 4 منتجات، كوكي masar_cmp، وصفحة مقارنة بتتعمل تلقائي.
 * لو فيه كاش للصفحات استثني صفحة المقارنة منه.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_cmp_on() {
	return class_exists( 'WooCommerce' ) && (bool) get_theme_mod( 'masar_compare', 1 );
}

function masar_cmp_ids() {
	$raw = isset( $_COOKIE['masar_cmp'] ) ? wp_unslash( $_COOKIE['masar_cmp'] ) : ''; // phpcs:ignore
	$ids = array_filter( array_map( 'absint', explode( ',', substr( (string) $raw, 0, 100 ) ) ) );
	return array_slice( array_values( array_unique( $ids ) ), 0, 4 );
}

function masar_cmp_page_id() {
	$id = (int) get_option( 'masar_compare_page' );
	return ( $id && 'publish' === get_post_status( $id ) ) ? $id : 0;
}
function masar_cmp_maybe_create_page() {
	if ( ! masar_cmp_on() || ! current_user_can( 'manage_options' ) || masar_cmp_page_id() || get_option( 'masar_compare_page_tried' ) ) { return; }
	update_option( 'masar_compare_page_tried', 1 );
	$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => __( 'مقارنة المنتجات', 'masar-altamayuz' ), 'post_content' => '[masar_compare]' ) );
	if ( $id && ! is_wp_error( $id ) ) { update_option( 'masar_compare_page', (int) $id ); }
}
add_action( 'admin_init', 'masar_cmp_maybe_create_page' );

function masar_cmp_url() {
	$id = masar_cmp_page_id();
	return $id ? get_permalink( $id ) : '';
}

function masar_cmp_button( $product_id, $class = '' ) {
	if ( ! masar_cmp_on() || ! $product_id ) { return ''; }
	return '<button type="button" class="cmp-btn ' . esc_attr( $class ) . '" data-id="' . (int) $product_id . '" aria-pressed="false" data-add="' . esc_attr__( 'قارن', 'masar-altamayuz' ) . '" data-remove="' . esc_attr__( 'إزالة من المقارنة', 'masar-altamayuz' ) . '">' . esc_html__( 'قارن', 'masar-altamayuz' ) . '</button>';
}
add_action( 'woocommerce_after_shop_loop_item', function () {
	global $product;
	if ( $product ) { echo masar_cmp_button( $product->get_id(), 'cmp-loop' ); } // phpcs:ignore
}, 12 );
add_action( 'woocommerce_after_add_to_cart_button', function () {
	global $product;
	if ( $product ) { echo masar_cmp_button( $product->get_id(), 'cmp-single' ); } // phpcs:ignore
}, 20 );

/** شريط المقارنة السفلي */
add_action( 'wp_footer', function () {
	$url = masar_cmp_url();
	if ( ! masar_cmp_on() || ! $url || is_page( masar_cmp_page_id() ) ) { return; }
	echo '<div class="cmp-tray" hidden><span><b class="cmp-n">0</b> ' . esc_html__( 'منتجات للمقارنة', 'masar-altamayuz' ) . '</span> <a class="cmp-go" href="' . esc_url( $url ) . '">' . esc_html__( 'قارن الآن', 'masar-altamayuz' ) . '</a> <button type="button" class="cmp-clear" aria-label="' . esc_attr__( 'مسح المقارنة', 'masar-altamayuz' ) . '">&times;</button></div>';
} );

/** صفحة المقارنة */
function masar_cmp_shortcode() {
	if ( ! class_exists( 'WooCommerce' ) ) { return ''; }
	$products = array();
	foreach ( masar_cmp_ids() as $id ) {
		$p = wc_get_product( $id );
		if ( $p && 'publish' === $p->get_status() && $p->is_visible() ) { $products[] = $p; }
	}
	$empty = esc_html__( 'مفيش منتجات للمقارنة. اضغطي «قارن» على منتجين أو أكتر.', 'masar-altamayuz' );
	if ( count( $products ) < 1 ) { return '<div class="cmp-page woocommerce"><p class="wl-empty">' . $empty . '</p></div>'; }

	$attr_names = array();
	foreach ( $products as $p ) {
		foreach ( $p->get_attributes() as $key => $a ) {
			if ( is_object( $a ) && $a->get_visible() ) { $attr_names[ $key ] = wc_attribute_label( $a->get_name(), $p ); }
		}
	}
	$rows = array();
	$rows[ __( 'السعر', 'masar-altamayuz' ) ] = function ( $p ) { return $p->get_price_html(); };
	$rows[ __( 'التقييم', 'masar-altamayuz' ) ] = function ( $p ) { return $p->get_review_count() ? esc_html( number_format_i18n( (float) $p->get_average_rating(), 1 ) ) . ' / 5 (' . (int) $p->get_review_count() . ')' : '—'; };
	$rows[ __( 'التوفر', 'masar-altamayuz' ) ] = function ( $p ) { return $p->is_in_stock() ? esc_html__( 'متوفر', 'masar-altamayuz' ) : esc_html__( 'غير متوفر', 'masar-altamayuz' ); };
	$rows[ __( 'كود المنتج', 'masar-altamayuz' ) ] = function ( $p ) { return $p->get_sku() ? esc_html( $p->get_sku() ) : '—'; };
	$rows[ __( 'نبذة', 'masar-altamayuz' ) ] = function ( $p ) { $t = wp_strip_all_tags( $p->get_short_description() ); return $t ? esc_html( wp_trim_words( $t, 24 ) ) : '—'; };
	foreach ( $attr_names as $key => $label ) {
		$rows[ $label ] = function ( $p ) use ( $key ) {
			$a = $p->get_attributes();
			if ( ! isset( $a[ $key ] ) ) { return '—'; }
			$v = $p->get_attribute( $key );
			return $v ? esc_html( $v ) : '—';
		};
	}

	ob_start();
	echo '<div class="cmp-page woocommerce"><div class="cmp-scroll"><table class="cmp-table"><thead><tr><th scope="col"><span class="screen-reader-text">' . esc_html__( 'المنتج', 'masar-altamayuz' ) . '</span></th>';
	foreach ( $products as $p ) {
		echo '<th scope="col" class="cmp-prod"><button type="button" class="cmp-btn cmp-x" data-id="' . (int) $p->get_id() . '" aria-label="' . esc_attr__( 'إزالة من المقارنة', 'masar-altamayuz' ) . '">&times;</button>';
		echo '<a href="' . esc_url( $p->get_permalink() ) . '">' . $p->get_image( 'woocommerce_thumbnail' ) . '<span class="cmp-name">' . esc_html( $p->get_name() ) . '</span></a></th>'; // phpcs:ignore
	}
	echo '</tr></thead><tbody>';
	foreach ( $rows as $label => $cb ) {
		echo '<tr><th scope="row">' . esc_html( $label ) . '</th>';
		foreach ( $products as $p ) { echo '<td>' . wp_kses_post( $cb( $p ) ) . '</td>'; }
		echo '</tr>';
	}
	echo '<tr><th scope="row"><span class="screen-reader-text">' . esc_html__( 'الشراء', 'masar-altamayuz' ) . '</span></th>';
	foreach ( $products as $p ) {
		echo '<td><a class="button" href="' . esc_url( $p->add_to_cart_url() ) . '" data-product_id="' . (int) $p->get_id() . '">' . esc_html( $p->add_to_cart_text() ) . '</a></td>';
	}
	echo '</tr></tbody></table></div></div>';
	return ob_get_clean();
}
add_shortcode( 'masar_compare', 'masar_cmp_shortcode' );

function masar_cmp_scripts() {
	if ( ! masar_cmp_on() ) { return; }
	wp_enqueue_script( 'masar-compare', get_template_directory_uri() . '/assets/js/compare.js', array(), MASAR_VER, true );
	wp_localize_script( 'masar-compare', 'MasarCmp', array(
		'max'   => 4,
		'full'  => __( 'تقدري تقارني 4 منتجات كحد أقصى.', 'masar-altamayuz' ),
		'empty' => __( 'مفيش منتجات للمقارنة. اضغطي «قارن» على منتجين أو أكتر.', 'masar-altamayuz' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'masar_cmp_scripts', 27 );

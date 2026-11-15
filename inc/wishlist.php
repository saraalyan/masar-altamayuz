<?php
/**
 * مسار التميز — قائمة الأمنيات (WooCommerce).
 * بدون تسجيل دخول: الأرقام بتتخزن في كوكي المتصفح (masar_wl)، وصفحة القائمة بتتعرض من السيرفر.
 * ملحوظة: لو فيه كاش للصفحات، استثني صفحة قائمة الأمنيات منه لأن محتواها بيتغير من زائر لزائر.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_wl_on() {
	return class_exists( 'WooCommerce' ) && (bool) get_theme_mod( 'masar_wishlist', 1 );
}

/** أرقام المنتجات المحفوظة في الكوكي (منقّاة) */
function masar_wl_ids() {
	$raw = isset( $_COOKIE['masar_wl'] ) ? wp_unslash( $_COOKIE['masar_wl'] ) : ''; // phpcs:ignore
	$ids = array_filter( array_map( 'absint', explode( ',', substr( (string) $raw, 0, 600 ) ) ) );
	return array_slice( array_values( array_unique( $ids ) ), 0, 100 );
}

/** الصفحة بتتعمل مرة واحدة أوتوماتيك */
function masar_wl_page_id() {
	$id = (int) get_option( 'masar_wishlist_page' );
	if ( $id && 'publish' === get_post_status( $id ) ) { return $id; }
	return 0;
}
function masar_wl_maybe_create_page() {
	if ( ! masar_wl_on() || ! current_user_can( 'manage_options' ) || masar_wl_page_id() ) { return; }
	if ( get_option( 'masar_wishlist_page_tried' ) ) { return; }
	update_option( 'masar_wishlist_page_tried', 1 );
	$id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => __( 'قائمة الأمنيات', 'masar-altamayuz' ),
		'post_content' => '[masar_wishlist]',
	) );
	if ( $id && ! is_wp_error( $id ) ) { update_option( 'masar_wishlist_page', (int) $id ); }
}
add_action( 'admin_init', 'masar_wl_maybe_create_page' );

function masar_wl_url() {
	$id = masar_wl_page_id();
	return $id ? get_permalink( $id ) : '';
}

/** زر القلب */
function masar_wl_button( $product_id, $class = '' ) {
	if ( ! masar_wl_on() || ! $product_id ) { return ''; }
	return '<button type="button" class="wl-btn ' . esc_attr( $class ) . '" data-id="' . (int) $product_id . '" aria-pressed="false" aria-label="' . esc_attr__( 'إضافة لقائمة الأمنيات', 'masar-altamayuz' ) . '" data-add="' . esc_attr__( 'إضافة لقائمة الأمنيات', 'masar-altamayuz' ) . '" data-remove="' . esc_attr__( 'إزالة من قائمة الأمنيات', 'masar-altamayuz' ) . '">' . masar_icon( 'heart' ) . '</button>';
}
add_action( 'woocommerce_before_shop_loop_item', function () {
	global $product;
	if ( $product ) { echo masar_wl_button( $product->get_id(), 'wl-loop' ); } // phpcs:ignore
}, 5 );
add_action( 'woocommerce_after_add_to_cart_button', function () {
	global $product;
	if ( $product ) { echo masar_wl_button( $product->get_id(), 'wl-single' ); } // phpcs:ignore
} );

/** أيقونة الهيدر */
function masar_wl_header_link() {
	$url = masar_wl_url();
	if ( ! masar_wl_on() || ! $url ) { return ''; }
	return '<a class="icon-btn wl-link" href="' . esc_url( $url ) . '" aria-label="' . esc_attr__( 'قائمة الأمنيات', 'masar-altamayuz' ) . '">' . masar_icon( 'heart' ) . '<span class="cart-count wl-count" hidden>0</span></a>';
}

/** شورتكود صفحة القائمة */
function masar_wl_shortcode() {
	if ( ! class_exists( 'WooCommerce' ) ) { return ''; }
	$ids = masar_wl_ids();
	ob_start();
	echo '<div class="wl-page woocommerce" data-empty="' . esc_attr__( 'قائمة الأمنيات فاضية. اضغطي على القلب في أي منتج لحفظه هنا.', 'masar-altamayuz' ) . '">';
	if ( $ids ) {
		$q = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'post__in' => $ids, 'orderby' => 'post__in', 'posts_per_page' => 100, 'no_found_rows' => true ) );
		if ( $q->have_posts() ) {
			wc_set_loop_prop( 'columns', 4 );
			woocommerce_product_loop_start();
			while ( $q->have_posts() ) { $q->the_post(); wc_get_template_part( 'content', 'product' ); }
			woocommerce_product_loop_end();
			wp_reset_postdata();
		}
	}
	if ( ! $ids || ! ( isset( $q ) && $q->post_count ) ) {
		echo '<p class="wl-empty">' . esc_html__( 'قائمة الأمنيات فاضية. اضغطي على القلب في أي منتج لحفظه هنا.', 'masar-altamayuz' ) . '</p>';
	}
	echo '</div>';
	return ob_get_clean();
}
add_shortcode( 'masar_wishlist', 'masar_wl_shortcode' );

function masar_wl_scripts() {
	if ( ! masar_wl_on() ) { return; }
	wp_enqueue_script( 'masar-wishlist', get_template_directory_uri() . '/assets/js/wishlist.js', array(), MASAR_VER, true );
	wp_localize_script( 'masar-wishlist', 'MasarWL', array(
		'empty' => __( 'قائمة الأمنيات فاضية. اضغطي على القلب في أي منتج لحفظه هنا.', 'masar-altamayuz' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'masar_wl_scripts', 26 );

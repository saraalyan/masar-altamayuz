<?php
/**
 * مسار التميز — ميزات المتجر: نظرة سريعة، إضافة للسلة بدون تحميل الصفحة (صفحة المنتج)، وشريط إضافة ثابت.
 * كلها بتشتغل مع WooCommerce بس، وكل واحدة ليها مفتاح في التخصيص ← المتجر.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_shop_on( $key ) {
	return class_exists( 'WooCommerce' ) && (bool) get_theme_mod( 'masar_' . $key, 1 );
}

/** زر النظرة السريعة */
function masar_quickview_button( $product_id ) {
	if ( ! masar_shop_on( 'quick_view' ) || ! $product_id ) { return ''; }
	return '<button type="button" class="qv-open" data-product-id="' . (int) $product_id . '">' . esc_html__( 'نظرة سريعة', 'masar-altamayuz' ) . '</button>';
}
add_action( 'woocommerce_after_shop_loop_item', function () {
	global $product;
	if ( $product ) { echo masar_quickview_button( $product->get_id() ); } // phpcs:ignore
}, 11 );

/** محتوى النافذة (AJAX) — منتجات منشورة ومعروضة بس */
function masar_quickview_ajax() {
	if ( ! class_exists( 'WooCommerce' ) ) { wp_send_json_error(); }
	$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
	$p  = $id ? wc_get_product( $id ) : false;
	if ( ! $p || ! $p->is_visible() ) { wp_send_json_error(); }

	$html  = '<div class="qv-grid"><div class="qv-img">' . $p->get_image( 'large' ) . '</div><div class="qv-info">';
	$html .= '<h2 class="qv-title" id="qv-title">' . esc_html( $p->get_name() ) . '</h2>';
	if ( wc_review_ratings_enabled() && $p->get_average_rating() ) { $html .= wc_get_rating_html( $p->get_average_rating(), $p->get_rating_count() ); }
	$html .= '<div class="price">' . wp_kses_post( $p->get_price_html() ) . '</div>';
	$desc  = $p->get_short_description() ? $p->get_short_description() : wp_trim_words( $p->get_description(), 40 );
	if ( $desc ) { $html .= '<div class="qv-desc">' . wp_kses_post( wpautop( $desc ) ) . '</div>'; }
	$html .= '<div class="qv-actions">';
	if ( $p->is_type( 'simple' ) && $p->is_purchasable() && $p->is_in_stock() ) {
		$html .= '<button type="button" class="btn qv-add" data-product-id="' . (int) $p->get_id() . '">' . esc_html__( 'أضف إلى السلة', 'masar-altamayuz' ) . '</button>';
	} elseif ( ! $p->is_in_stock() ) {
		$html .= '<span class="qv-oos">' . esc_html__( 'غير متوفر حالياً', 'masar-altamayuz' ) . '</span>';
	} else {
		$html .= '<a class="btn" href="' . esc_url( $p->get_permalink() ) . '">' . esc_html__( 'اختيار الخيارات', 'masar-altamayuz' ) . '</a>';
	}
	$html .= '<a class="btn btn-ghost" href="' . esc_url( $p->get_permalink() ) . '">' . esc_html__( 'عرض المنتج كاملاً', 'masar-altamayuz' ) . '</a>';
	$html .= '</div></div></div>';
	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_masar_quickview', 'masar_quickview_ajax' );
add_action( 'wp_ajax_nopriv_masar_quickview', 'masar_quickview_ajax' );

/** شريط الإضافة الثابت في صفحة المنتج */
function masar_sticky_atc() {
	if ( ! masar_shop_on( 'sticky_atc' ) || ! function_exists( 'is_product' ) || ! is_product() ) { return; }
	global $product;
	if ( ! $product || ! is_object( $product ) ) { $product = wc_get_product( get_the_ID() ); }
	if ( ! $product || ! $product->is_in_stock() ) { return; }
	$simple = $product->is_type( 'simple' ) && $product->is_purchasable();
	echo '<div class="sticky-atc" hidden data-simple="' . ( $simple ? '1' : '0' ) . '"><div class="sticky-atc-in"><div class="sticky-atc-t"><b>' . esc_html( $product->get_name() ) . '</b><span class="price">' . wp_kses_post( $product->get_price_html() ) . '</span></div>';
	echo '<button type="button" class="btn sticky-atc-b">' . esc_html( $simple ? __( 'أضف إلى السلة', 'masar-altamayuz' ) : __( 'اختيار الخيارات', 'masar-altamayuz' ) ) . '</button></div></div>';
}
add_action( 'wp_footer', 'masar_sticky_atc' );

/** سكربت المتجر */
function masar_shop_scripts() {
	if ( ! class_exists( 'WooCommerce' ) || is_cart() || is_checkout() ) { return; }
	if ( ! masar_shop_on( 'quick_view' ) && ! masar_shop_on( 'ajax_single' ) && ! masar_shop_on( 'sticky_atc' ) ) { return; }
	wp_enqueue_script( 'masar-shop', get_template_directory_uri() . '/assets/js/shop.js', array(), MASAR_VER, true );
	wp_localize_script( 'masar-shop', 'MasarShop', array(
		'ajax'      => admin_url( 'admin-ajax.php' ),
		'wcAjax'    => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( 'add_to_cart' ) : '',
		'cartUrl'   => wc_get_cart_url(),
		'quickView' => masar_shop_on( 'quick_view' ) ? 1 : 0,
		'ajaxSingle'=> masar_shop_on( 'ajax_single' ) ? 1 : 0,
		'i18n'      => array(
			'close'   => __( 'إغلاق', 'masar-altamayuz' ),
			'loading' => __( 'جاري التحميل…', 'masar-altamayuz' ),
			'error'   => __( 'حصلت مشكلة، جرّبي تاني.', 'masar-altamayuz' ),
			'added'   => __( 'تمت الإضافة للسلة ✓', 'masar-altamayuz' ),
			'viewCart'=> __( 'عرض السلة', 'masar-altamayuz' ),
			'adding'  => __( 'جاري الإضافة…', 'masar-altamayuz' ),
		),
	) );
}
add_action( 'wp_enqueue_scripts', 'masar_shop_scripts', 25 );

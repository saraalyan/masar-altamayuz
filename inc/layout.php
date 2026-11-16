<?php
/**
 * مسار التميز — مكان السايدبار لكل نوع صفحة (المدونة، المقال، الصفحة، المتجر).
 * من التخصيص ← الشكل ← السايدبار. السايدبار بيظهر بس لو فيه ودجتس جواه.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** نوع الصفحة الحالية: blog | single | page | shop */
function masar_ctx() {
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) { return 'shop'; }
	if ( is_singular( 'post' ) ) { return 'single'; }
	if ( is_page() ) { return 'page'; }
	return 'blog';
}

/** رقم السايدبار اللي هيتعرض: سايدبار المتجر لو فيه ودجتس، وإلا السايدبار العام */
function masar_sidebar_id( $ctx = null ) {
	$ctx = $ctx ? $ctx : masar_ctx();
	if ( 'shop' === $ctx && is_active_sidebar( 'sidebar-shop' ) ) { return 'sidebar-shop'; }
	return is_active_sidebar( 'sidebar-1' ) ? 'sidebar-1' : '';
}

/** none | start (يمين) | end (يسار) */
function masar_sidebar_pos( $ctx = null ) {
	$ctx = $ctx ? $ctx : masar_ctx();
	if ( ! masar_sidebar_id( $ctx ) ) { return 'none'; }
	$def = ( 'blog' === $ctx ) ? 'end' : 'none';
	$pos = get_theme_mod( 'masar_side_' . $ctx, $def );
	return in_array( $pos, array( 'none', 'start', 'end' ), true ) ? $pos : $def;
}

/** كلاسات صندوق التخطيط (فاضية لو من غير سايدبار) */
function masar_layout_class( $ctx = null ) {
	$pos = masar_sidebar_pos( $ctx );
	return 'none' === $pos ? '' : ' has-side side-' . $pos;
}

/** فتح وقفل محتوى المقال/الصفحة: ضيّق من غير سايدبار، وبالتخطيط معاه */
function masar_entry_open( $ctx ) {
	if ( function_exists( 'masar_is_elementor_page' ) && is_singular() && masar_is_elementor_page() ) { echo '<div class="entry-el">'; return; }
	$pos = masar_sidebar_pos( $ctx );
	if ( 'none' === $pos ) { echo '<div class="wrap narrow entry">'; return; }
	echo '<div class="wrap layout has-side side-' . esc_attr( $pos ) . '"><div class="entry content">';
}
function masar_entry_close( $ctx ) {
	if ( function_exists( 'masar_is_elementor_page' ) && is_singular() && masar_is_elementor_page() ) { echo '</div>'; return; }
	if ( 'none' === masar_sidebar_pos( $ctx ) ) { echo '</div>'; return; }
	echo '</div>';
	get_sidebar();
	echo '</div>';
}
/** كلاس غلاف الصورة البارزة */
function masar_wrap_class( $ctx ) {
	return 'none' === masar_sidebar_pos( $ctx ) ? 'wrap narrow' : 'wrap';
}

add_action( 'widgets_init', function () {
	register_sidebar( array(
		'name' => __( 'سايدبار المتجر', 'masar-altamayuz' ), 'id' => 'sidebar-shop',
		'description' => __( 'بيظهر في الشوب وصفحة المنتج. لو فاضي بيتعرض السايدبار العام.', 'masar-altamayuz' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
	) );
} );

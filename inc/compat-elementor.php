<?php
/**
 * مسار التميز — توافق Elementor (و Elementor Pro Theme Builder).
 * - لو فيه قالب Elementor للهيدر/الفوتر/الصفحة/المقال/الأرشيف بيتعرض بدل قالب الثيم، ولو مفيش بيرجع للثيم عادي.
 * - الصفحات المبنية بـ Elementor بتتعرض بدون عنوان الثيم وبدون الحشوة (عشان Elementor يتحكم في كل حاجة).
 * - Elementor مش لازم يكون منصّب: كل الدوال هنا آمنة.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** يعرض مكان Elementor (header/footer/single/archive). بيرجع true لو اتعرض قالب من Elementor. */
function masar_elementor_location( $location ) {
	if ( function_exists( 'elementor_theme_do_location' ) ) {
		return (bool) elementor_theme_do_location( $location );
	}
	return false;
}

/** هل الصفحة الحالية مبنية بـ Elementor؟ */
function masar_is_elementor_page( $post_id = 0 ) {
	if ( ! class_exists( '\Elementor\Plugin' ) ) { return false; }
	$post_id = $post_id ? $post_id : get_the_ID();
	if ( ! $post_id ) { return false; }
	$plugin = \Elementor\Plugin::$instance;
	if ( ! isset( $plugin->documents ) ) { return false; }
	$doc = $plugin->documents->get( $post_id );
	return $doc && $doc->is_built_with_elementor();
}

/** تسجيل أماكن Elementor Pro */
add_action( 'elementor/theme/register_locations', function ( $manager ) {
	if ( is_object( $manager ) && method_exists( $manager, 'register_all_core_location' ) ) { $manager->register_all_core_location(); }
} );

/** كلاس للـ body عشان الـCSS */
add_filter( 'body_class', function ( $c ) {
	if ( is_singular() && masar_is_elementor_page() ) { $c[] = 'is-elementor-page'; }
	return $c;
} );

/** Elementor بيدير الألوان والخطوط بتاعته: منسيبش ألوان الثيم الافتراضية تتداخل مع إعداداته */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'align-wide' );
} );

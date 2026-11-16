<?php
/**
 * مسار التميز — توافق الترجمة (Polylang و WPML).
 * - نصوص التخصيص (theme mods) ونصوص Studio (عناوين/نصوص/عناصر الأقسام) بتتسجّل للترجمة وبتتعرض مترجمة حسب لغة الزائر.
 * - مبدّل اللغات في الشريط العلوي (أو جنب أيقونات الهيدر لو الشريط العلوي مقفول).
 * ملحوظة: الثيم RTL بالتصميم، فاللغات اللي بتتكتب من الشمال لليمين هتتعرض بنفس الاتجاه.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** 'pll' | 'wpml' | '' */
function masar_i18n_plugin() {
	if ( function_exists( 'pll__' ) && function_exists( 'pll_register_string' ) ) { return 'pll'; }
	if ( defined( 'ICL_SITEPRESS_VERSION' ) ) { return 'wpml'; }
	return '';
}

/** هل النص ده نص مستخدم يستاهل الترجمة (مش رابط/لون/رقم/كود اختيار)؟ */
function masar_i18n_is_text( $v ) {
	if ( ! is_string( $v ) ) { return false; }
	$v = trim( $v );
	if ( '' === $v || strlen( $v ) > 2000 ) { return false; }
	if ( preg_match( '#^(https?:)?//|^/|^mailto:|^tel:|^\#[0-9a-f]{3,8}$#i', $v ) ) { return false; }
	if ( preg_match( '/^[a-z0-9_\-:.,|\/ ]+$/', $v ) ) { return false; }   // اختيارات وأكواد صغيرة
	if ( is_numeric( $v ) ) { return false; }
	return true;
}

function masar_i18n_tr( $v ) {
	static $on = null;
	if ( null === $on ) { $on = masar_i18n_plugin(); }
	if ( ! $on || ! masar_i18n_is_text( $v ) ) { return $v; }
	if ( 'pll' === $on ) { return pll__( $v ); }
	return apply_filters( 'wpml_translate_single_string', $v, 'masar-altamayuz', 'str-' . substr( md5( $v ), 0, 12 ) );
}

/** ترجمة قيم مصفوفة (متداخلة) */
function masar_i18n_tr_deep( $data ) {
	if ( is_array( $data ) ) {
		foreach ( $data as $k => $v ) { $data[ $k ] = masar_i18n_tr_deep( $v ); }
		return $data;
	}
	return masar_i18n_tr( $data );
}

/** استخراج كل النصوص من مصفوفة */
function masar_i18n_collect( $data, &$out ) {
	if ( is_array( $data ) ) { foreach ( $data as $v ) { masar_i18n_collect( $v, $out ); } return; }
	if ( masar_i18n_is_text( $data ) ) { $out[ md5( $data ) ] = $data; }
}

/** مفاتيح theme_mods اللي مش نصوص */
function masar_i18n_skip_key( $k ) {
	return 0 !== strpos( $k, 'masar_' ) || preg_match( '/(url|color|image|logo|font|_id|_bg|layout|style|pos|type)$/', $k );
}

if ( masar_i18n_plugin() ) {
	/* نصوص التخصيص */
	add_filter( 'option_theme_mods_' . get_option( 'stylesheet' ), function ( $mods ) {
		if ( ! is_array( $mods ) || is_admin() && ! wp_doing_ajax() ) { return $mods; }
		foreach ( $mods as $k => $v ) {
			if ( is_string( $v ) && ! masar_i18n_skip_key( $k ) ) { $mods[ $k ] = masar_i18n_tr( $v ); }
		}
		return $mods;
	} );

	/* نصوص Studio */
	add_filter( 'masar_section_args', function ( $args ) { return masar_i18n_tr_deep( $args ); }, 99 );

	/* تسجيل النصوص (Polylang بيحتاج تسجيل صريح) */
	add_action( 'admin_init', 'masar_i18n_register_strings' );
}

function masar_i18n_register_strings() {
	if ( 'pll' !== masar_i18n_plugin() ) { return; }
	$found = array();
	$mods  = get_option( 'theme_mods_' . get_option( 'stylesheet' ) );
	if ( is_array( $mods ) ) {
		foreach ( $mods as $k => $v ) { if ( is_string( $v ) && ! masar_i18n_skip_key( $k ) && masar_i18n_is_text( $v ) ) { $found[ md5( $v ) ] = $v; } }
	}
	foreach ( array_keys( masar_presets() ) as $key ) { masar_i18n_collect( get_option( 'masar_layout_' . $key ), $found ); }
	foreach ( $found as $v ) { pll_register_string( 'str-' . substr( md5( $v ), 0, 12 ), $v, 'مسار التميز', strlen( $v ) > 80 ); }
}

/** مبدّل اللغات: مصفوفة [ [url, label, active, code] ] */
function masar_lang_list() {
	$p = masar_i18n_plugin();
	$out = array();
	if ( 'pll' === $p && function_exists( 'pll_the_languages' ) ) {
		$l = pll_the_languages( array( 'raw' => 1, 'hide_if_no_translation' => 0 ) );
		foreach ( (array) $l as $x ) { $out[] = array( 'url' => $x['url'], 'label' => $x['name'], 'active' => ! empty( $x['current_lang'] ), 'code' => $x['slug'] ); }
	} elseif ( 'wpml' === $p ) {
		$l = apply_filters( 'wpml_active_languages', null, 'skip_missing=0&orderby=code' );
		foreach ( (array) $l as $code => $x ) { $out[] = array( 'url' => $x['url'], 'label' => isset( $x['native_name'] ) ? $x['native_name'] : $code, 'active' => ! empty( $x['active'] ), 'code' => $code ); }
	}
	return $out;
}
function masar_lang_switcher( $class = '' ) {
	if ( ! get_theme_mod( 'masar_lang_switch', 1 ) ) { return ''; }
	$l = masar_lang_list();
	if ( count( $l ) < 2 ) { return ''; }
	$h = '<span class="lang-sw ' . esc_attr( $class ) . '" aria-label="' . esc_attr__( 'اللغة', 'masar-altamayuz' ) . '">';
	foreach ( $l as $x ) {
		$h .= '<a href="' . esc_url( $x['url'] ) . '" hreflang="' . esc_attr( $x['code'] ) . '" lang="' . esc_attr( $x['code'] ) . '"' . ( $x['active'] ? ' aria-current="true" class="is-cur"' : '' ) . '>' . esc_html( $x['label'] ) . '</a>';
	}
	return $h . '</span>';
}

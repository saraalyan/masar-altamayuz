<?php
/**
 * مسار التميز — رفع خط خاص (woff2 / woff / ttf / otf) + تحكم في أحجام الخط.
 * من التخصيص ← الألوان والشكل ← الخطوط.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** امتدادات الخطوط المسموحة (للمدير بس) */
function masar_font_exts() {
	return array(
		'woff2' => 'font/woff2',
		'woff'  => 'font/woff',
		'ttf'   => 'font/ttf',
		'otf'   => 'font/otf',
	);
}

/** السماح برفع ملفات الخطوط لمكتبة الوسائط لمن يملك manage_options فقط */
add_filter( 'upload_mimes', function ( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		foreach ( masar_font_exts() as $ext => $mime ) { $mimes[ $ext ] = $mime; }
	}
	return $mimes;
} );
/** فحص الملف بيرجّع أحياناً نوع تاني للخطوط، فنثبّت النوع حسب الامتداد (للمدير بس) */
add_filter( 'wp_check_filetype_and_ext', function ( $data, $file, $filename, $mimes ) {
	if ( ! current_user_can( 'manage_options' ) ) { return $data; }
	$ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
	$all = masar_font_exts();
	if ( isset( $all[ $ext ] ) ) { $data = array( 'ext' => $ext, 'type' => $all[ $ext ], 'proper_filename' => false ); }
	return $data;
}, 10, 4 );

/** تنظيف رابط ملف الخط: لازم ينتهي بامتداد خط مسموح */
function masar_sanitize_font_url( $url ) {
	$url = esc_url_raw( (string) $url );
	if ( '' === $url ) { return ''; }
	$ext = strtolower( pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );
	return isset( masar_font_exts()[ $ext ] ) ? $url : '';
}
function masar_sanitize_font_name( $name ) {
	return trim( preg_replace( '/[^\p{L}\p{N} _-]/u', '', (string) $name ) );
}

/** الخط المرفوع: [ 'name' => ..., 'files' => [ 400 => url, 700 => url ] ] أو null */
function masar_custom_font() {
	$reg = masar_sanitize_font_url( get_theme_mod( 'masar_cf_regular', '' ) );
	if ( ! $reg ) { return null; }
	$name  = masar_sanitize_font_name( get_theme_mod( 'masar_cf_name', '' ) );
	$files = array( 400 => $reg );
	$bold  = masar_sanitize_font_url( get_theme_mod( 'masar_cf_bold', '' ) );
	if ( $bold ) { $files[700] = $bold; }
	return array( 'name' => $name ? $name : 'Masar Custom', 'files' => $files );
}

/** @font-face للخط المرفوع */
function masar_custom_font_css() {
	$f = masar_custom_font();
	if ( ! $f ) { return ''; }
	$fmt = array( 'woff2' => 'woff2', 'woff' => 'woff', 'ttf' => 'truetype', 'otf' => 'opentype' );
	$css = '';
	foreach ( $f['files'] as $weight => $url ) {
		$ext  = strtolower( pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );
		$css .= '@font-face{font-family:"' . esc_attr( $f['name'] ) . '";font-style:normal;font-display:swap;font-weight:' . (int) $weight . ';src:url("' . esc_url( $url ) . '") format("' . $fmt[ $ext ] . '")}';
	}
	return $css;
}

/** اسم عائلة الخط اللي فعلاً هيتعرض لقيمة اختيار (@upload = الخط المرفوع) */
function masar_resolve_font( $value, $fallback ) {
	if ( '@upload' === $value ) {
		$f = masar_custom_font();
		return $f ? $f['name'] : $fallback;
	}
	return $value;
}
function masar_is_uploaded_font( $family ) {
	$f = masar_custom_font();
	return $f && $f['name'] === $family;
}

/** متغيرات تحكم الخط في CSS */
function masar_typography_css() {
	$fs = max( 14, min( 22, (int) get_theme_mod( 'masar_fs_base', 17 ) ) );
	$hs = max( 80, min( 140, (int) get_theme_mod( 'masar_fs_head', 100 ) ) );
	$lh = max( 150, min( 220, (int) get_theme_mod( 'masar_lh', 185 ) ) );
	$fw = (int) get_theme_mod( 'masar_fw_head', 700 );
	$fw = in_array( $fw, array( 400, 500, 600, 700, 800 ), true ) ? $fw : 700;
	return ':root{--fs-base:' . $fs . 'px;--hs:' . ( $hs / 100 ) . ';--lh:' . ( $lh / 100 ) . ';--fw-head:' . $fw . ';}';
}

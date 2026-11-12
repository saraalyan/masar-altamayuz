<?php
/**
 * مجموعة أيقونات SVG خطية (24×24) بدل الإيموجي. تتلوّن بلون النص (currentColor).
 * الاستخدام: echo masar_icon( 'truck' ); — وأي اسم مش موجود بيتعرض كنص (يعني الإيموجي لسه شغّال).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function masar_icon_set() {
	static $set = null;
	if ( null !== $set ) { return $set; }
	$set = array(
		/* واجهة */
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/>',
		'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>',
		'cart'     => '<path d="M5 8h14l-1.2 12H6.2z"/><path d="M9 8V6.5a3 3 0 0 1 6 0V8"/>',
		'heart'    => '<path d="M12 20s-7.5-4.6-7.5-10.2A4.2 4.2 0 0 1 12 7.4a4.2 4.2 0 0 1 7.5 2.4C19.500 15.400 12 20 12 20z"/>',
		'moon'     => '<path d="M20 14.5A8 8 0 1 1 9.500 4a6.500 6.500 0 0 0 10.500 10.500z"/>',
		'sun'      => '<circle cx="12" cy="12" r="4"/><path d="M12 2.500v2M12 19.500v2M4.600 4.600 6 6M18 18l1.400 1.400M2.500 12h2M19.500 12h2M4.600 19.400 6 18M18 6l1.400-1.400"/>',
		'menu'     => '<path d="M4 7h16M4 12h16M4 17h16"/>',
		'arrow'    => '<path d="M20 12H4M10 6l-6 6 6 6"/>',
		'check'    => '<path d="m5 12.500 4.500 4.500L19 7.500"/>',
		'star'     => '<path d="m12 3.500 2.600 5.400 5.900.8-4.300 4.100 1 5.900L12 16.900l-5.200 2.800 1-5.900L3.500 9.700l5.900-.8z"/>',
		'sparkle'  => '<path d="M11 3.500 12.900 9l5.600 1.900-5.600 1.900L11 18.500 9.100 12.800 3.500 10.900 9.100 9z"/><path d="M19 15.500v4M17 17.500h4"/>',
		/* خدمات */
		'truck'    => '<path d="M2.500 6.500h10.500v9.500H2.500z"/><path d="M13 9.500h4l3.500 3v3.500H13"/><circle cx="6.500" cy="17.500" r="1.800"/><circle cx="16.500" cy="17.500" r="1.800"/>',
		'refresh'  => '<path d="M4 12a8 8 0 0 1 14-5.300L20 9"/><path d="M20 4v5h-5"/><path d="M20 12a8 8 0 0 1-14 5.300L4 15"/><path d="M4 20v-5h5"/>',
		'lock'     => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7.500a4 4 0 0 1 8 0V11"/>',
		'shield'   => '<path d="M12 3 20 6v6c0 5-3.500 8-8 9-4.500-1-8-4-8-9V6z"/><path d="m8.500 12 2.500 2.500 4.500-5"/>',
		'chat'     => '<path d="M21 11.500a8.500 8.500 0 0 1-12.300 7.600L3.500 20.500l1.400-4.900A8.500 8.500 0 1 1 21 11.500z"/>',
		'gift'     => '<rect x="3.500" y="8.500" width="17" height="4" rx="1"/><path d="M5 12.500V20h14v-7.500M12 8.500V20"/><path d="M12 8.500C9.500 8.500 7.500 7.500 7.500 6s1.500-2 2.500-1.500c1.200.6 2 4 2 4zM12 8.500c2.500 0 4.500-1 4.500-2.500s-1.500-2-2.500-1.500c-1.200.6-2 4-2 4z"/>',
		'phone'    => '<path d="M5 4h3.500l1.800 4.800-2.300 1.500a11 11 0 0 0 5.700 5.700l1.500-2.300 4.800 1.800V19a2 2 0 0 1-2.200 2A16.500 16.500 0 0 1 3 6.200 2 2 0 0 1 5 4z"/>',
		'mail'     => '<rect x="3" y="5.500" width="18" height="13" rx="2"/><path d="m3.500 7.500 8.500 6 8.500-6"/>',
		'pin'      => '<path d="M12 21s-7-6.200-7-11.500a7 7 0 0 1 14 0C19 14.800 12 21 12 21z"/><circle cx="12" cy="9.500" r="2.500"/>',
		'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.500 2"/>',
		'award'    => '<circle cx="12" cy="9" r="5.500"/><path d="m8.700 13.500-1.700 7 5-2.800 5 2.800-1.700-7"/>',
		'leaf'     => '<path d="M5 19c0-8.500 5-14 15-14 0 10.500-5.500 15-13.500 15"/><path d="M5 19c2.500-4.500 6-8 10-9.500"/>',
		'flower'   => '<circle cx="12" cy="12" r="2.200"/><path d="M12 9.800c-2-3-1-5.800 0-6.800 1 1 2 3.800 0 6.800zM12 14.200c2 3 1 5.800 0 6.800-1-1-2-3.800 0-6.800zM9.800 12c-3-2-5.800-1-6.800 0 1 1 3.800 2 6.800 0zM14.200 12c3 2 5.800 1 6.800 0-1-1-3.800-2-6.800 0z"/>',
		/* منتجات وفئات */
		'hanger'   => '<path d="M12 8V6.500a2 2 0 1 0-2-2"/><path d="m12 8-8.500 6.800c-.9.700-.4 1.700.7 1.700h15.600c1.100 0 1.600-1 .7-1.700z"/>',
		'dress'    => '<path d="M9 3.500 10 7h4l1-3.500"/><path d="M10 7 8.700 12 5 20.500h14L15.300 12 14 7"/><path d="M8.700 12h6.600"/>',
		'shirt'    => '<path d="M8.500 3.500 3.500 6l2 4 2.500-1V20.500h8V9l2.500 1 2-4-5-2.500a3.500 3.500 0 0 1-7 0z"/>',
		'pants'    => '<path d="M7 3.500h10l1.200 17h-4.500L12 9.500l-1.700 11H5.800z"/><path d="M7 7h10"/>',
		'jacket'   => '<path d="M9 3.500 4.500 5.500V20.500H10V10l2 3 2-3v10.500h5.500V5.500L15 3.500 12 7z"/><path d="M12 13v7.500"/>',
		'bag'      => '<rect x="4" y="9" width="16" height="11.500" rx="2.500"/><path d="M8 9V7a4 4 0 0 1 8 0v2"/><path d="M4 13.500h16"/><path d="M11 13.500h2v2.200h-2z"/>',
		'watch'    => '<rect x="7" y="6.500" width="10" height="11" rx="3"/><path d="m9 6.500.8-3h4.400l.8 3M9 17.500l.8 3h4.400l.8-3"/><path d="M12 10v2.500l1.800 1"/>',
		'glasses'  => '<circle cx="6.800" cy="14.500" r="3.500"/><circle cx="17.200" cy="14.500" r="3.500"/><path d="M10.300 14.500h3.400M3.400 13.800 5 8.500M20.600 13.800 19 8.500"/>',
		'gem'      => '<path d="M6.500 4h11l3 5L12 20.500 3.500 9z"/><path d="M3.500 9h17M9.500 4 8 9l4 11.500L16 9l-1.500-5"/>',
		'shoe'     => '<path d="M3 16.500v-4.200c0-.6.500-1 1-.8l3.200 1.100c.8.300 1.800.1 2.400-.5l1.500-1.600 2.300 1.500c1 .7 2.200 1.100 3.400 1.200 2.500.3 4.200 1.400 4.200 3.300z"/><path d="M3 16.500v2h18v-2"/>',
		'perfume'  => '<rect x="6" y="10" width="12" height="11" rx="3"/><path d="M10 10V7.500h4V10M11 7.500v-4h2v4"/><path d="M9.500 15.500h5"/>',
		'lamp'     => '<path d="M8 3.500h8L19 12H5z"/><path d="M12 12v7.500M8.500 20.500h7"/>',
		'vase'     => '<path d="M9 3.500h6M10 3.500v3c0 2.200-3 3.200-3 7 0 4.200 1.200 7.500 5 7.500s5-3.300 5-7.500c0-3.800-3-4.800-3-7v-3"/>',
		'candle'   => '<rect x="7" y="11.500" width="10" height="9.500" rx="1.800"/><path d="M12 3.500c2.200 2.200 2.500 3.800 0 5.500-2.500-1.700-2.200-3.300 0-5.500z"/><path d="M12 9v2.500"/>',
		'sofa'     => '<path d="M5.500 11.500V8.500a3 3 0 0 1 3-3h7a3 3 0 0 1 3 3v3"/><path d="M3 12.500a2 2 0 0 1 4 0v2.500h10v-2.500a2 2 0 0 1 4 0V18H3z"/><path d="M6 21v-3M18 21v-3"/>',
		'bed'      => '<path d="M3 18.500V6.500M3 14h18v4.500M21 14v-2a3 3 0 0 0-3-3h-7v5"/><circle cx="7" cy="11" r="1.800"/>',
		'home'     => '<path d="m3 11 9-7 9 7"/><path d="M5.500 9.500V20h4.500v-6h4v6h4.500V9.500"/>',
		'utensils' => '<path d="M7 3.500v7.500M4.500 3.500v4.500a2.500 2.500 0 0 0 5 0V3.500M7 11v9.500M17.500 20.500v-17c-2.500 1.500-3.500 4.500-3.500 8h3.500"/>',
		'monitor'  => '<rect x="3" y="4.500" width="18" height="12" rx="2"/><path d="M8 20.500h8M12 16.500v4"/>',
		'bath'     => '<path d="M4 12h16v2.500a4.500 4.500 0 0 1-4.500 4.500h-7A4.500 4.500 0 0 1 4 14.500z"/><path d="M6 12V6.500a2 2 0 0 1 4 0M7 19l-1 2M17 19l1 2"/>',
		/* سوشيال */
		'instagram' => '<rect x="3.500" y="3.500" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.200" cy="6.800" r=".7" fill="currentColor"/>',
		'facebook'  => '<path d="M14 8.500h3V4.500h-3a4 4 0 0 0-4 4V11H7v4h3v6h4v-6h3l1-4h-4V8.500z"/>',
		'youtube'   => '<rect x="2.500" y="5.500" width="19" height="13" rx="4"/><path d="m10 9.500 5 2.500-5 2.500z"/>',
		'tiktok'    => '<path d="M14 3.500v11a3.500 3.500 0 1 1-3.500-3.500"/><path d="M14 3.500c.4 2.500 2 4 4.500 4.200"/>',
		'pinterest' => '<circle cx="12" cy="12" r="9"/><path d="m11 16 1.600-7M9.500 13c-.6-2 .7-4.500 3-4.500 1.800 0 2.700 1.200 2.700 2.700 0 2-1.200 3.700-2.900 3.700-1 0-1.700-.7-1.500-1.500"/>',
	);
	return $set;
}


/** أسماء بديلة (Lucide وغيرها) + إيموجي شائع → اسم أيقونة في المجموعة */
function masar_icon_alias() {
	return array(
		'bed-double' => 'bed', 'cooking-pot' => 'utensils', 'flame' => 'candle', 'footprints' => 'shoe', 'handbag' => 'bag',
		'house' => 'home', 'laptop' => 'monitor', 'message-circle' => 'chat', 'ribbon' => 'gift', 'ruler' => 'pants',
		'shield-check' => 'shield', 'spray-can' => 'perfume', 'undo-2' => 'refresh', 'briefcase' => 'jacket', 'frame' => 'vase',
		'shopping-bag' => 'cart', 'whatsapp' => 'chat', 'sparkles' => 'sparkle', 'phone-call' => 'phone', 'map-pin' => 'pin',
		'🌿' => 'leaf', '🌸' => 'flower', '🥀' => 'flower', '✦' => 'sparkle', '✨' => 'sparkle', '🎁' => 'gift', '🛍️' => 'cart', '🛍' => 'cart',
		'👗' => 'dress', '👒' => 'hanger', '👜' => 'bag', '🧥' => 'jacket', '👠' => 'shoe', '💍' => 'gem', '🧣' => 'gift', '🕶️' => 'glasses', '🕶' => 'glasses',
		'🛋️' => 'sofa', '🛋' => 'sofa', '🍳' => 'utensils', '🏡' => 'home', '🛁' => 'bath', '🪴' => 'leaf', '🛏️' => 'bed', '🛏' => 'bed', '🏺' => 'vase', '🕯️' => 'candle', '🕯' => 'candle',
		'👟' => 'shoe', '⌚' => 'watch', '📞' => 'phone', '✉️' => 'mail', '✉' => 'mail', '📍' => 'pin', '💬' => 'chat', '🔍' => 'search', '👤' => 'user', '🛒' => 'cart', '🌙' => 'moon', '☀️' => 'sun', '💌' => 'mail',
	);
}

/** رسم أيقونة (أو نص/إيموجي لو الاسم مش موجود) */
function masar_icon( $name, $class = '' ) {
	$set = masar_icon_set();
	$al  = masar_icon_alias();
	if ( ! isset( $set[ $name ] ) && isset( $al[ $name ] ) ) { $name = $al[ $name ]; }
	if ( ! isset( $set[ $name ] ) ) { return '<span class="ico-txt">' . esc_html( $name ) . '</span>'; }
	return '<svg class="ico ico-' . esc_attr( $name ) . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $set[ $name ] . '</svg>';
}

<?php
/**
 * مسار التميز — functions.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MASAR_VER', '2.2.0' );

require get_template_directory() . '/inc/icons.php';
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/presets.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/studio.php';
require get_template_directory() . '/inc/demo.php';

function masar_setup() {
	load_theme_textdomain( 'masar-altamayuz', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_image_size( 'masar-card', 640, 480, true );
	add_image_size( 'masar-tall', 600, 760, true );
	register_nav_menus( array(
		'primary'      => __( 'القائمة الرئيسية', 'masar-altamayuz' ),
		'footer'       => __( 'قائمة الفوتر', 'masar-altamayuz' ),
	) );
}
add_action( 'after_setup_theme', 'masar_setup' );

function masar_widgets() {
	register_sidebar( array(
		'name' => __( 'السايدبار', 'masar-altamayuz' ), 'id' => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
	) );
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name' => sprintf( __( 'الفوتر %d', 'masar-altamayuz' ), $i ), 'id' => 'footer-' . $i,
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'masar_widgets' );

/** الخطوط المضمّنة داخل الثيم (woff2 محلية، بدون Google Fonts) */
function masar_fonts_map() {
	// الخطوط مضمّنة داخل الثيم (assets/fonts) — اسم الخط => اسم الملف
	return array(
		'Cairo'                => 'cairo',
		'Tajawal'              => 'tajawal',
		'Almarai'              => 'almarai',
		'IBM Plex Sans Arabic' => 'ibm-plex-sans-arabic',
		'Amiri'                => 'amiri',
		'Noto Naskh Arabic'    => 'noto-naskh-arabic',
		'Reem Kufi'            => 'reem-kufi',
		'El Messiri'           => 'el-messiri',
		'Aref Ruqaa'           => 'aref-ruqaa',
		'Lalezar'              => 'lalezar',
		'Readex Pro'           => 'readex-pro',
		'Markazi Text'         => 'markazi-text',
	);
}

/** تنسيقات خطوط جاهزة: عناوين + نصوص */
function masar_font_pairs() {
	return array(
		'elegant' => array( 'label' => 'أنيق: عناوين أميري + نصوص القاهرة', 'head' => 'Amiri', 'body' => 'Cairo' ),
		'modern'  => array( 'label' => 'عصري: تجوال', 'head' => 'Tajawal', 'body' => 'Tajawal' ),
		'classic' => array( 'label' => 'كلاسيك: نسخ + IBM بلكس', 'head' => 'Noto Naskh Arabic', 'body' => 'IBM Plex Sans Arabic' ),
		'bold'    => array( 'label' => 'جريء: ريم كوفي + المراعي', 'head' => 'Reem Kufi', 'body' => 'Almarai' ),
		'messiri' => array( 'label' => 'مميز: المسيري (عناوين وجسم)', 'head' => 'El Messiri', 'body' => 'El Messiri' ),
		'ruqaa'   => array( 'label' => 'خط يد: عارف رقعة + ريدكس', 'head' => 'Aref Ruqaa', 'body' => 'Readex Pro' ),
		'display' => array( 'label' => 'عناوين ضخمة: لاليزار + القاهرة', 'head' => 'Lalezar', 'body' => 'Cairo' ),
		'literary' => array( 'label' => 'أدبي: مركزي', 'head' => 'Markazi Text', 'body' => 'Markazi Text' ),
		'clean'   => array( 'label' => 'نظيف: القاهرة', 'head' => 'Cairo', 'body' => 'Cairo' ),
		'custom'  => array( 'label' => 'مخصص (اختاري الخطين بنفسك)', 'head' => '', 'body' => '' ),
	);
}

/** الخطين الفعليين (عناوين / نصوص) */
function masar_fonts_in_use() {
	$pairs = masar_font_pairs();
	$k     = get_theme_mod( 'masar_font_pair', 'messiri' );
	if ( isset( $pairs[ $k ] ) && 'custom' !== $k ) { return array( $pairs[ $k ]['head'], $pairs[ $k ]['body'] ); }
	$fonts = masar_fonts_map();
	$head  = get_theme_mod( 'masar_font_head', 'Amiri' );
	$body  = get_theme_mod( 'masar_font_body', 'Cairo' );
	return array( isset( $fonts[ $head ] ) ? $head : 'Amiri', isset( $fonts[ $body ] ) ? $body : 'Cairo' );
}

function masar_palettes() {
	return array(
		'beige'  => array( 'label' => 'بيج أنيق',        'primary' => '#3b2f27', 'accent' => '#c9ad8f', 'soft' => '#f6f0e8', 'ink' => '#2a211c' ),
		'terra'  => array( 'label' => 'تيراكوتا دافئ',   'primary' => '#e0592a', 'accent' => '#f2a37f', 'soft' => '#fbf1ea', 'ink' => '#231a15' ),
		'luxe'   => array( 'label' => 'ذهبي داكن فاخر',  'primary' => '#c9a063', 'accent' => '#e3c590', 'soft' => '#1f1913', 'ink' => '#f3e9da', 'dark' => true ),
		'olive'  => array( 'label' => 'زيتوني طبيعي',    'primary' => '#5b6b3a', 'accent' => '#a9b57e', 'soft' => '#f4efe4', 'ink' => '#2b2a1c' ),
		'autumn' => array( 'label' => 'خريفي بني',       'primary' => '#a8612f', 'accent' => '#d9a679', 'soft' => '#f5ede6', 'ink' => '#2a1b12' ),
		'rose'   => array( 'label' => 'وردي رومانسي',    'primary' => '#d6336c', 'accent' => '#f783ac', 'soft' => '#fff0f5', 'ink' => '#3b1a2b' ),
		'royal'  => array( 'label' => 'أحمر ملكي',       'primary' => '#b0132b', 'accent' => '#e8a0a8', 'soft' => '#fff4f4', 'ink' => '#2a0f14' ),
		'lilac'  => array( 'label' => 'ليلكي حالم',      'primary' => '#7c4dbb', 'accent' => '#c8a8ef', 'soft' => '#f6f0ff', 'ink' => '#24153a' ),
		'gold'   => array( 'label' => 'ذهبي مشرق',       'primary' => '#b8893b', 'accent' => '#e9c98a', 'soft' => '#fffaf0', 'ink' => '#2e2410' ),
		'sage'   => array( 'label' => 'أخضر ناعم',       'primary' => '#3f7d5c', 'accent' => '#a8d5b9', 'soft' => '#f2faf5', 'ink' => '#14291f' ),
		'ocean'  => array( 'label' => 'أزرق هادئ',       'primary' => '#2b6a8f', 'accent' => '#9cc9de', 'soft' => '#eff7fb', 'ink' => '#10232e' ),
	);
}

function masar_palette_data() {
	$pal = masar_palettes();
	$key = get_theme_mod( 'masar_palette', 'beige' );
	return isset( $pal[ $key ] ) ? $pal[ $key ] : $pal['beige'];
}

function masar_enqueue() {
	$fonts = masar_fonts_map();
	list( $head, $body ) = masar_fonts_in_use();
	foreach ( array_unique( array( $head, $body ) ) as $fam ) {
		wp_enqueue_style( 'masar-font-' . $fonts[ $fam ], get_template_directory_uri() . '/assets/fonts/' . $fonts[ $fam ] . '.css', array(), MASAR_VER );
	}
	// خط لاتيني أنيق للعناوين والأرقام والأسماء الإنجليزية
	wp_enqueue_style( 'masar-font-playfair', get_template_directory_uri() . '/assets/fonts/playfair-display.css', array(), MASAR_VER );
	wp_enqueue_style( 'masar-main', get_template_directory_uri() . '/assets/css/main.css', array(), MASAR_VER );
	wp_enqueue_style( 'masar-style', get_stylesheet_uri(), array( 'masar-main' ), MASAR_VER );
	wp_add_inline_style( 'masar-main', masar_dynamic_css() );
	wp_enqueue_script( 'masar-main', get_template_directory_uri() . '/assets/js/main.js', array(), MASAR_VER, true );
	wp_localize_script( 'masar-main', 'MasarCfg', array(
		'petals'   => (int) get_theme_mod( 'masar_petals', 0 ),
		'petalCnt' => (int) get_theme_mod( 'masar_petals_count', 14 ),
		'thanks'   => __( 'شكراً لاشتراكك 💌', 'masar-altamayuz' ),
	) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'masar_enqueue' );

function masar_dynamic_css() {
	$p    = masar_palette_data();
	$prim = get_theme_mod( 'masar_custom_primary', '' ) ?: $p['primary'];
	$acc  = get_theme_mod( 'masar_custom_accent', '' ) ?: $p['accent'];
	list( $head, $body ) = masar_fonts_in_use();
	$rad  = (int) get_theme_mod( 'masar_radius', 18 );
	$wid  = (int) get_theme_mod( 'masar_width', 1180 );
	$hh   = (int) get_theme_mod( 'masar_hero_height', 78 );
	$ov   = (int) get_theme_mod( 'masar_hero_overlay', 35 );
	$css  = ':root{--primary:' . esc_attr( $prim ) . ';--accent:' . esc_attr( $acc ) . ';--soft:' . esc_attr( $p['soft'] ) . ';--ink:' . esc_attr( $p['ink'] ) . ';';
	$css .= '--radius:' . $rad . 'px;--wrap:' . $wid . 'px;--hero-h:' . $hh . 'vh;--overlay:' . ( $ov / 100 ) . ';';
	$css .= '--font-body:"' . esc_attr( $body ) . '",system-ui,sans-serif;--font-head:"Playfair Display","' . esc_attr( $head ) . '",serif;}';
	return $css;
}

function masar_body_classes( $c ) {
	$p = masar_palette_data();
	$preset = masar_current_preset();
	$presets = masar_presets();
	$dark = ! empty( $p['dark'] ) || ( $preset && ! empty( $presets[ $preset ]['skin'] ) && 'dark' === $presets[ $preset ]['skin'] );
	if ( $dark ) { $c[] = 'skin-dark'; }
	if ( $preset ) {
		$c[] = 'preset-' . $preset;
		$first = isset( $presets[ $preset ]['sections'][0] ) ? $presets[ $preset ]['sections'][0] : array();
		$hero  = ( $first && 'hero' === $first[0] ) ? masar_override( 'hero_style', masar_arg( isset( $first[1] ) ? $first[1] : array(), 'style', 'split' ) ) : '';
		// الهيدر الشفاف يناسب هيرو الصورة الخلفية الداكنة فقط
		if ( get_theme_mod( 'masar_header_overlay', 0 ) && 'center' === $hero ) { $c[] = 'hdr-over'; }
	}
	$c[] = 'card-' . get_theme_mod( 'masar_card_style', 'soft' );
	$c[] = 'btn-' . get_theme_mod( 'masar_btn_style', 'pill' );
	$c[] = 'blog-' . get_theme_mod( 'masar_blog_layout', 'grid' );
	$c[] = 'hdr-' . get_theme_mod( 'masar_header_style', 'split' );
	$c[] = 'ftr-' . get_theme_mod( 'masar_footer_style', 'columns' );
	return $c;
}
add_filter( 'body_class', 'masar_body_classes' );

function masar_excerpt_more() { return '…'; }
add_filter( 'excerpt_more', 'masar_excerpt_more' );
add_filter( 'excerpt_length', function () { return 24; } );

/* زر واتساب + زر للأعلى */
function masar_footer_extras() {
	$wa = preg_replace( '/\D/', '', (string) get_theme_mod( 'masar_whatsapp', '' ) );
	if ( $wa ) {
		$msg = rawurlencode( get_theme_mod( 'masar_whatsapp_msg', 'أهلاً، عايز أستفسر عن المنتجات' ) );
		echo '<a class="wa-float" href="https://wa.me/' . esc_attr( $wa ) . '?text=' . $msg . '" target="_blank" rel="noopener" aria-label="واتساب"><svg viewBox="0 0 32 32" width="28" height="28" fill="#fff"><path d="M16 3C8.8 3 3 8.7 3 15.8c0 2.5.7 4.8 2 6.8L3 29l6.6-2c1.9 1 4 1.6 6.4 1.6 7.2 0 13-5.7 13-12.8S23.200 3 16 3zm0 23.200c-2.100 0-4.100-.6-5.800-1.700l-.4-.2-3.900 1.200 1.200-3.800-.3-.4A10.200 10.200 0 0 1 5.800 15.800C5.800 10.200 10.400 5.700 16 5.700s10.200 4.500 10.200 10.100S21.600 26.200 16 26.200zm5.600-7.600c-.3-.2-1.800-.9-2.100-1-.3-.1-.5-.2-.7.200s-.8 1-1 1.200c-.2.200-.4.200-.7.100-.3-.2-1.300-.5-2.500-1.500-.9-.8-1.500-1.800-1.700-2.100-.2-.3 0-.5.100-.6l.5-.5c.1-.2.200-.3.300-.5.100-.2 0-.4 0-.5l-1-2.300c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.100-.8.400-.3.300-1.100 1.100-1.100 2.600s1.100 3 1.300 3.200c.2.200 2.200 3.400 5.400 4.700 3.200 1.300 3.200.9 3.800.8.600-.1 1.800-.7 2-1.400.3-.7.300-1.300.2-1.400-.1-.2-.3-.2-.6-.4z"/></svg></a>';
	}
	echo '<button class="to-top" aria-label="للأعلى" hidden>↑</button>';
}
add_action( 'wp_footer', 'masar_footer_extras' );

/* تعديلات WooCommerce */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'loop_shop_columns', function () { return 3; } );
add_filter( 'woocommerce_add_to_cart_fragments', function ( $f ) {
	if ( function_exists( 'WC' ) ) {
		$f['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	}
	return $f;
} );

function masar_reading_time() {
	$w = str_word_count( wp_strip_all_tags( get_the_content() ) );
	return max( 1, (int) ceil( $w / 180 ) );
}

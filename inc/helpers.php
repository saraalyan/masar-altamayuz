<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** قيمة من مصفوفة الإعدادات مع افتراضي */
function masar_arg( $a, $k, $d = '' ) {
	return ( isset( $a[ $k ] ) && '' !== $a[ $k ] ) ? $a[ $k ] : $d;
}

/** قيمة من الـ Customizer تتجاوز الافتراضي لو المستخدم كتب حاجة */
function masar_override( $mod, $default = '' ) {
	$v = get_theme_mod( 'masar_' . $mod, '' );
	return ( '' !== $v && null !== $v ) ? $v : $default;
}

/** صورة أو مكان صورة جميل لو مفيش صورة */
function masar_media( $src, $emoji = '✦', $cls = '', $alt = '' ) {
	if ( is_numeric( $src ) ) { $src = wp_get_attachment_image_url( (int) $src, 'large' ); }
	if ( $src ) {
		return '<img class="' . esc_attr( $cls ) . '" src="' . esc_url( $src ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">';
	}
	static $n = 0;
	$n++;
	$tone = ( $n - 1 ) % 8 + 1;
	return '<span class="ph-box tone-' . $tone . ' ' . esc_attr( $cls ) . '" aria-hidden="true">' . masar_icon( $emoji ) . '</span>';
}

/** عرض سكشن من template-parts/sections */
function masar_section( $name, $args = array() ) {
	$name = sanitize_file_name( $name );
	$file = get_template_directory() . '/template-parts/sections/' . $name . '.php';
	if ( ! file_exists( $file ) ) { return; }
	$args = apply_filters( 'masar_section_args', $args, $name );
	include $file;
}

/** شورت كود: [masar_section name="faq" title="أسئلة" variant="dark"] */
function masar_section_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'name' => '', 'title' => '', 'subtitle' => '', 'count' => '', 'variant' => '' ), $atts, 'masar_section' );
	$name = $atts['name'];
	unset( $atts['name'] );
	ob_start();
	masar_section( $name, array_filter( $atts ) );
	return ob_get_clean();
}
add_shortcode( 'masar_section', 'masar_section_shortcode' );

/** أي قالب رئيسي نعرضه الآن؟ (fashion | luxe | services | decor | '') */
function masar_current_preset() {
	static $p = null;
	if ( null !== $p ) { return $p; }
	$p = '';
	$presets = masar_presets();
	if ( is_front_page() && ! is_paged() ) {
		$k = get_theme_mod( 'masar_home_preset', 'fashion' );
		$p = isset( $presets[ $k ] ) ? $k : 'fashion';
	} elseif ( is_page() ) {
		$t = (string) get_page_template_slug();
		if ( preg_match( '#templates/home-([a-z]+)\.php$#', $t, $m ) && isset( $presets[ $m[1] ] ) ) { $p = $m[1]; }
	}
	return $p;
}

/** رسم قالب كامل */
function masar_render_preset( $key ) {
	$presets = masar_presets();
	if ( ! isset( $presets[ $key ] ) ) { $key = 'fashion'; }
	$list = apply_filters( 'masar_preset_sections', $presets[ $key ]['sections'], $key );
	foreach ( $list as $row ) {
		$name = $row[0];
		$args = isset( $row[1] ) ? $row[1] : array();
		masar_section( $name, $args );
	}
}

/** عنوان السكشن */
function masar_sec_head( $args, $default_title = '', $default_sub = '' ) {
	$t = masar_arg( $args, 'title', $default_title );
	$s = masar_arg( $args, 'subtitle', $default_sub );
	if ( ! $t && ! $s ) { return; }
	echo '<div class="sec-head">';
	if ( ! empty( $args['kicker'] ) ) { echo '<span class="kicker">' . esc_html( $args['kicker'] ) . '</span>'; }
	if ( $t ) { echo '<h2 class="sec-title">' . esc_html( $t ) . '</h2>'; }
	if ( $s ) { echo '<p class="sec-sub">' . esc_html( $s ) . '</p>'; }
	echo '</div>';
}

/** منتجات WooCommerce الحقيقية، أو null لو الإضافة مش مفعّلة */
function masar_query_items( $n = 6 ) {
	if ( ! post_type_exists( 'product' ) ) { return null; }
	return new WP_Query( array( 'post_type' => 'product', 'posts_per_page' => max( 1, (int) $n ), 'ignore_sticky_posts' => true ) );
}

/** تصنيفات منتجات WooCommerce الحقيقية، أو مصفوفة فاضية (بنستخدم تصنيفات القالب الافتراضية) */
function masar_real_terms( $n = 8 ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) { return array(); }
	$args = array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'number' => (int) $n );
	$def = (int) get_option( 'default_product_cat', 0 );
	if ( $def ) { $args['exclude'] = array( $def ); }
	$terms = get_terms( $args );
	if ( is_wp_error( $terms ) || ! $terms ) { return array(); }
	$out = array();
	foreach ( $terms as $t ) {
		$img = '';
		$tid = (int) get_term_meta( $t->term_id, 'thumbnail_id', true );
		if ( $tid ) { $img = wp_get_attachment_image_url( $tid, 'medium' ); }
		$link = get_term_link( $t );
		$out[] = array( 'label' => $t->name, 'image' => $img, 'url' => is_wp_error( $link ) ? '#' : $link, 'count' => (int) $t->count );
	}
	return $out;
}

/** روابط السوشيال */
function masar_social_links( $class = 'socials' ) {
	$soc = array( 'facebook' => 'فيسبوك', 'instagram' => 'إنستجرام', 'tiktok' => 'تيك توك', 'youtube' => 'يوتيوب', 'pinterest' => 'بنترست' );
	$out = '';
	foreach ( $soc as $k => $l ) {
		$u = get_theme_mod( 'masar_social_' . $k, '' );
		if ( $u ) { $out .= '<a href="' . esc_url( $u ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr( $l ) . '" title="' . esc_attr( $l ) . '">' . masar_icon( $k ) . '</a>'; }
	}
	if ( $out ) { echo '<div class="' . esc_attr( $class ) . '">' . $out . '</div>'; } // phpcs:ignore WordPress.Security.EscapeOutput
}

/** رابط حساب المستخدم */
function masar_account_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
}

/** هل القالب الحالي فيه سكشن نشرة بريدية؟ */
function masar_preset_has( $section ) {
	$k = masar_current_preset();
	if ( ! $k ) { return false; }
	$p = masar_presets();
	foreach ( $p[ $k ]['sections'] as $row ) { if ( $row[0] === $section ) { return true; } }
	return false;
}

/** أسئلة شائعة افتراضية */
function masar_faq_defaults() {
	return array(
		array( 'كم يستغرق التوصيل؟', 'من 1 إلى 3 أيام عمل داخل المدن الكبرى، وحتى 5 أيام للمحافظات.' ),
		array( 'هل يمكنني استرجاع المنتج؟', 'نعم، خلال 14 يوم من الاستلام بشرط أن يكون بحالته الأصلية.' ),
		array( 'ما وسائل الدفع المتاحة؟', 'الدفع عند الاستلام، بطاقات الائتمان، والمحافظ الإلكترونية.' ),
		array( 'كيف أتواصل معكم؟', 'عبر واتساب أو الهاتف أو البريد، وبنرد خلال ساعات العمل.' ),
	);
}

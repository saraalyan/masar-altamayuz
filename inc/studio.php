<?php
/**
 * استوديو مسار: تعديل السكاشن (إظهار/إخفاء، ترتيب، نصوص) من لوحة التحكم.
 * التعديلات تتخزن في option لكل قالب وتتطبّق فوق الإعدادات الافتراضية في presets.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** مواصفات الحقول القابلة للتعديل لكل سكشن */
function masar_section_specs() {
	$t = function ( $n, $hint ) { return array( 'type' => 'tuple', 'n' => $n, 'hint' => $hint ); };
	return array(
		'hero'           => array( 'label' => 'الهيرو (الواجهة الرئيسية)', 'fields' => array( 'eyebrow' => 'عبارة صغيرة', 'title' => 'العنوان', 'subtitle' => 'النص الفرعي', 'btn1' => 'نص الزر 1', 'btn1_url' => 'رابط الزر 1', 'btn2' => 'نص الزر 2', 'btn2_url' => 'رابط الزر 2', 'image' => 'رابط الصورة' ) ),
		'features'       => array( 'label' => 'شريط المميزات', 'fields' => array(), 'items' => $t( 3, 'إيموجي | العنوان | الوصف' ) ),
		'cats-circles'   => array( 'label' => 'تصنيفات دائرية', 'fields' => array( 'title' => 'العنوان' ), 'items' => array( 'type' => 'assoc', 'keys' => array( 'label', 'emoji' ), 'hint' => 'الاسم | إيموجي (يتجاهل لو عندك تصنيفات حقيقية)' ) ),
		'cats-cards'     => array( 'label' => 'تصنيفات ككروت', 'fields' => array( 'title' => 'العنوان' ), 'items' => array( 'type' => 'assoc', 'keys' => array( 'label', 'emoji' ), 'hint' => 'الاسم | إيموجي' ) ),
		'products'       => array( 'label' => 'المنتجات', 'fields' => array( 'title' => 'العنوان', 'subtitle' => 'النص الفرعي', 'btn' => 'نص الزر', 'count' => 'عدد المنتجات' ) ),
		'promo-banners'  => array( 'label' => 'بانرات ترويجية', 'fields' => array(), 'items' => array( 'type' => 'assoc', 'keys' => array( 'kicker', 'title', 'text', 'badge', 'btn', 'tone', 'emoji', 'image' ), 'hint' => 'عنوان صغير | العنوان | الوصف | شارة | نص الزر | اللون (dark/mocha/sand) | إيموجي | رابط صورة' ) ),
		'feature-banner' => array( 'label' => 'بانر المجموعة الكبير', 'fields' => array( 'kicker' => 'عنوان صغير', 'title' => 'العنوان', 'text' => 'الوصف', 'btn' => 'نص الزر', 'url' => 'رابط الزر', 'image' => 'رابط صورة الخلفية' ) ),
		'testimonials'   => array( 'label' => 'آراء العملاء', 'fields' => array( 'title' => 'العنوان', 'kicker' => 'عنوان صغير' ), 'items' => $t( 2, 'الاسم | الرأي' ) ),
		'gallery'        => array( 'label' => 'معرض (إنستجرام/مشاريع)', 'fields' => array( 'title' => 'العنوان', 'kicker' => 'عنوان صغير', 'handle' => 'حساب إنستجرام' ) ),
		'newsletter'     => array( 'label' => 'النشرة البريدية', 'fields' => array( 'title' => 'العنوان', 'text' => 'النص' ) ),
		'brands'         => array( 'label' => 'شريط العلامات', 'fields' => array( 'title' => 'العنوان' ), 'items' => array( 'type' => 'strings', 'hint' => 'اسم في كل سطر' ) ),
		'services'       => array( 'label' => 'الخدمات', 'fields' => array( 'title' => 'العنوان', 'kicker' => 'عنوان صغير' ), 'items' => $t( 3, 'إيموجي | الخدمة | الوصف' ) ),
		'process'        => array( 'label' => 'خطوات العمل', 'fields' => array( 'title' => 'العنوان', 'kicker' => 'عنوان صغير' ), 'items' => $t( 2, 'الخطوة | الوصف' ) ),
		'about'          => array( 'label' => 'من نحن', 'fields' => array( 'kicker' => 'عنوان صغير', 'title' => 'العنوان', 'text' => 'النص', 'btn' => 'نص الرابط', 'url' => 'رابط', 'image' => 'رابط الصورة' ) ),
		'stats'          => array( 'label' => 'الإحصائيات', 'fields' => array(), 'items' => $t( 2, 'الرقم | الوصف' ) ),
		'faq'            => array( 'label' => 'الأسئلة الشائعة', 'fields' => array( 'title' => 'العنوان' ), 'items' => $t( 2, 'السؤال | الجواب' ), 'default_items' => 'faq' ),
		'cta'            => array( 'label' => 'دعوة للتواصل', 'fields' => array( 'title' => 'العنوان', 'text' => 'النص', 'btn' => 'نص الزر', 'url' => 'رابط الزر' ) ),
		'journal'        => array( 'label' => 'المدونة', 'fields' => array( 'title' => 'العنوان', 'subtitle' => 'النص' ) ),
		'contact'        => array( 'label' => 'وسائل التواصل', 'fields' => array( 'title' => 'العنوان', 'subtitle' => 'النص' ) ),
	);
}

function masar_items_to_text( $items, $spec ) {
	$lines = array();
	foreach ( (array) $items as $it ) {
		if ( 'strings' === $spec['type'] ) { $lines[] = (string) $it; continue; }
		if ( 'assoc' === $spec['type'] ) {
			$row = array();
			foreach ( $spec['keys'] as $k ) { $row[] = isset( $it[ $k ] ) ? $it[ $k ] : ''; }
			$lines[] = rtrim( implode( ' | ', $row ), ' |' );
			continue;
		}
		$lines[] = implode( ' | ', array_values( (array) $it ) );
	}
	return implode( "\n", $lines );
}

function masar_items_from_text( $text, $spec ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) { continue; }
		if ( 'strings' === $spec['type'] ) { $out[] = $line; continue; }
		$parts = array_map( 'trim', explode( '|', $line ) );
		if ( 'assoc' === $spec['type'] ) {
			$row = array();
			foreach ( $spec['keys'] as $i => $k ) { $row[ $k ] = isset( $parts[ $i ] ) ? $parts[ $i ] : ''; }
			$out[] = $row;
		} else {
			$out[] = array_pad( $parts, (int) $spec['n'], '' );
		}
	}
	return $out;
}

/** تطبيق التعديلات المحفوظة على قالب */
function masar_apply_layout( $sections, $key ) {
	$saved = get_option( 'masar_layout_' . $key );
	if ( ! is_array( $saved ) || ! $saved ) { return $sections; }
	$specs = masar_section_specs();
	$out   = array();
	$used  = array();
	foreach ( $saved as $row ) {
		$i = isset( $row['idx'] ) ? (int) $row['idx'] : -1;
		if ( ! isset( $sections[ $i ] ) || isset( $used[ $i ] ) ) { continue; }
		$used[ $i ] = true;
		if ( empty( $row['on'] ) ) { continue; }
		$name = $sections[ $i ][0];
		$args = isset( $sections[ $i ][1] ) ? $sections[ $i ][1] : array();
		if ( ! empty( $row['args'] ) && is_array( $row['args'] ) ) {
			foreach ( $row['args'] as $k => $v ) { if ( '' !== $v ) { $args[ $k ] = $v; } }
		}
		if ( ! empty( $row['items'] ) && isset( $specs[ $name ]['items'] ) ) {
			$args['items'] = masar_items_from_text( $row['items'], $specs[ $name ]['items'] );
		}
		$out[] = array( $name, $args );
	}
	foreach ( $sections as $i => $s ) { if ( ! isset( $used[ $i ] ) ) { $out[] = $s; } }
	return $out;
}
add_filter( 'masar_preset_sections', 'masar_apply_layout', 10, 2 );

/* ====================== واجهة لوحة التحكم ====================== */
if ( is_admin() ) {

	add_action( 'admin_menu', function () {
		add_theme_page( 'استوديو مسار التميز', '✨ استوديو مسار', 'manage_options', 'masar-studio', 'masar_studio_page' );
	} );

	/** حفظ ترتيب وتعديلات السكاشن */
	add_action( 'admin_post_masar_save_layout', function () {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'غير مسموح' ); }
		check_admin_referer( 'masar_layout' );
		$presets = masar_presets();
		$key     = isset( $_POST['preset'] ) ? sanitize_key( wp_unslash( $_POST['preset'] ) ) : '';
		if ( ! isset( $presets[ $key ] ) ) { wp_die( 'قالب غير معروف' ); }
		$specs   = masar_section_specs();
		$defaults = $presets[ $key ]['sections'];
		$order   = isset( $_POST['order'] ) ? array_map( 'intval', (array) wp_unslash( $_POST['order'] ) ) : array();
		$rows    = isset( $_POST['layout'] ) ? (array) wp_unslash( $_POST['layout'] ) : array();
		$saved   = array();
		foreach ( $order as $i ) {
			if ( ! isset( $defaults[ $i ], $rows[ $i ] ) ) { continue; }
			$name = $defaults[ $i ][0];
			$r    = (array) $rows[ $i ];
			$args = array();
			if ( ! empty( $specs[ $name ]['fields'] ) && ! empty( $r['args'] ) ) {
				foreach ( $specs[ $name ]['fields'] as $fk => $fl ) {
					if ( ! isset( $r['args'][ $fk ] ) ) { continue; }
					$v = (string) $r['args'][ $fk ];
					if ( in_array( $fk, array( 'text' ), true ) ) { $v = sanitize_textarea_field( $v ); }
					elseif ( false !== strpos( $fk, 'url' ) || 'image' === $fk ) { $v = esc_url_raw( $v ); }
					elseif ( 'count' === $fk ) { $v = $v === '' ? '' : (string) max( 1, min( 24, (int) $v ) ); }
					else { $v = sanitize_text_field( $v ); }
					if ( '' !== $v ) { $args[ $fk ] = $v; }
				}
			}
			$items = '';
			if ( isset( $specs[ $name ]['items'], $r['items'] ) ) {
				$items = sanitize_textarea_field( (string) $r['items'] );
				$orig  = isset( $defaults[ $i ][1]['items'] ) ? $defaults[ $i ][1]['items'] : ( isset( $specs[ $name ]['default_items'] ) ? masar_faq_defaults() : array() );
				if ( trim( $items ) === trim( masar_items_to_text( $orig, $specs[ $name ]['items'] ) ) ) { $items = ''; }
			}
			$saved[] = array( 'idx' => $i, 'on' => empty( $r['on'] ) ? 0 : 1, 'args' => $args, 'items' => $items );
		}
		update_option( 'masar_layout_' . $key, $saved, false );
		wp_safe_redirect( admin_url( 'themes.php?page=masar-studio&preset=' . $key . '&msg=saved' ) );
		exit;
	} );

	add_action( 'admin_post_masar_reset_layout', function () {
		if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'غير مسموح' ); }
		check_admin_referer( 'masar_layout' );
		$key = isset( $_POST['preset'] ) ? sanitize_key( wp_unslash( $_POST['preset'] ) ) : '';
		delete_option( 'masar_layout_' . $key );
		wp_safe_redirect( admin_url( 'themes.php?page=masar-studio&preset=' . $key . '&msg=reset' ) );
		exit;
	} );

	/** صفحة الاستوديو */
	function masar_studio_page() {
		if ( ! current_user_can( 'manage_options' ) ) { return; }
		$presets = masar_presets();
		$key     = isset( $_GET['preset'] ) ? sanitize_key( wp_unslash( $_GET['preset'] ) ) : get_theme_mod( 'masar_home_preset', 'fashion' ); // phpcs:ignore WordPress.Security.NonceVerification
		if ( ! isset( $presets[ $key ] ) ) { $key = 'fashion'; }
		$tab   = ( isset( $_GET['tab'] ) && 'demo' === $_GET['tab'] ) ? 'demo' : 'layout'; // phpcs:ignore WordPress.Security.NonceVerification
		$msg   = isset( $_GET['msg'] ) ? sanitize_key( wp_unslash( $_GET['msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		$base  = admin_url( 'themes.php?page=masar-studio' );
		$notes = array( 'saved' => 'تم حفظ التعديلات ✅', 'reset' => 'رجّعنا القالب لوضعه الأصلي ✅', 'imported' => 'تم استيراد المحتوى التجريبي ✅', 'removed' => 'تم حذف المحتوى التجريبي ✅', 'exists' => 'المحتوى التجريبي مستورد بالفعل.' );
		echo '<div class="wrap masar-studio" dir="rtl"><h1>✨ استوديو مسار التميز</h1>';
		if ( isset( $notes[ $msg ] ) ) { echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $notes[ $msg ] ) . '</p></div>'; }
		echo '<h2 class="nav-tab-wrapper"><a class="nav-tab ' . ( 'layout' === $tab ? 'nav-tab-active' : '' ) . '" href="' . esc_url( add_query_arg( 'preset', $key, $base ) ) . '">تعديل السكاشن</a><a class="nav-tab ' . ( 'demo' === $tab ? 'nav-tab-active' : '' ) . '" href="' . esc_url( add_query_arg( 'tab', 'demo', $base ) ) . '">محتوى تجريبي</a></h2>';
		echo '<style>.masar-studio .mrow{background:#fff;border:1px solid #dcdcde;border-radius:8px;margin:10px 0;padding:0}.masar-studio .mhead{display:flex;gap:10px;align-items:center;padding:10px 14px;background:#f6f7f7;border-radius:8px 8px 0 0}.masar-studio .mhead b{flex:1}.masar-studio .mbody{padding:12px 14px;display:grid;grid-template-columns:1fr 1fr;gap:10px 16px}.masar-studio .mbody label{display:block;font-size:12px;color:#50575e;margin-bottom:3px}.masar-studio .mbody input[type=text],.masar-studio .mbody textarea{width:100%}.masar-studio .mfull{grid-column:1/-1}.masar-studio .off .mbody{opacity:.45}.masar-studio .hint{color:#787c82;font-size:12px}</style>';
		if ( 'demo' === $tab ) { masar_studio_demo_tab(); } else { masar_studio_layout_tab( $key, $presets, $base ); }
		echo '</div>';
	}

	function masar_studio_layout_tab( $key, $presets, $base ) {
		$specs    = masar_section_specs();
		$defaults = $presets[ $key ]['sections'];
		$saved    = get_option( 'masar_layout_' . $key );
		$rows     = array();
		if ( is_array( $saved ) && $saved ) {
			$seen = array();
			foreach ( $saved as $s ) { if ( isset( $defaults[ (int) $s['idx'] ] ) ) { $rows[] = $s; $seen[ (int) $s['idx'] ] = 1; } }
			foreach ( $defaults as $i => $d ) { if ( ! isset( $seen[ $i ] ) ) { $rows[] = array( 'idx' => $i, 'on' => 1, 'args' => array(), 'items' => '' ); } }
		} else {
			foreach ( $defaults as $i => $d ) { $rows[] = array( 'idx' => $i, 'on' => 1, 'args' => array(), 'items' => '' ); }
		}
		echo '<form method="get" action="' . esc_url( admin_url( 'themes.php' ) ) . '" style="margin:14px 0"><input type="hidden" name="page" value="masar-studio"><label>القالب: <select name="preset" onchange="this.form.submit()">';
		foreach ( $presets as $k => $p ) { echo '<option value="' . esc_attr( $k ) . '"' . selected( $k, $key, false ) . '>' . esc_html( $p['label'] ) . '</option>'; }
		echo '</select></label> <span class="hint">كل تعديل هنا بيتطبق على القالب ده سواء كرئيسية أو كصفحة بقالب.</span></form>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" id="masar-layout-form">';
		wp_nonce_field( 'masar_layout' );
		echo '<input type="hidden" name="action" value="masar_save_layout"><input type="hidden" name="preset" value="' . esc_attr( $key ) . '"><div id="masar-rows">';
		foreach ( $rows as $r ) {
			$i    = (int) $r['idx'];
			$name = $defaults[ $i ][0];
			$dargs = isset( $defaults[ $i ][1] ) ? $defaults[ $i ][1] : array();
			$spec = isset( $specs[ $name ] ) ? $specs[ $name ] : array( 'label' => $name, 'fields' => array() );
			echo '<div class="mrow' . ( empty( $r['on'] ) ? ' off' : '' ) . '" data-i="' . (int) $i . '"><input type="hidden" name="order[]" value="' . (int) $i . '">';
			echo '<div class="mhead"><label><input type="hidden" name="layout[' . (int) $i . '][on]" value="0"><input type="checkbox" class="mon" name="layout[' . (int) $i . '][on]" value="1"' . checked( ! empty( $r['on'] ), true, false ) . '> إظهار</label><b>' . esc_html( $spec['label'] ) . '</b><button type="button" class="button mup">▲</button><button type="button" class="button mdn">▼</button></div>';
			echo '<div class="mbody">';
			foreach ( $spec['fields'] as $fk => $fl ) {
				$val = isset( $r['args'][ $fk ] ) ? $r['args'][ $fk ] : '';
				$ph  = isset( $dargs[ $fk ] ) ? $dargs[ $fk ] : '';
				$full = in_array( $fk, array( 'subtitle', 'text' ), true ) ? ' mfull' : '';
				echo '<div class="' . esc_attr( trim( $full ) ) . '"><label>' . esc_html( $fl ) . '</label>';
				if ( 'text' === $fk ) { echo '<textarea rows="3" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" placeholder="' . esc_attr( $ph ) . '">' . esc_textarea( $val ) . '</textarea>'; }
				else { echo '<input type="text" name="layout[' . (int) $i . '][args][' . esc_attr( $fk ) . ']" value="' . esc_attr( $val ) . '" placeholder="' . esc_attr( $ph ) . '">'; }
				echo '</div>';
			}
			if ( isset( $spec['items'] ) ) {
				$orig = isset( $dargs['items'] ) ? $dargs['items'] : ( isset( $spec['default_items'] ) ? masar_faq_defaults() : array() );
				$txt  = ! empty( $r['items'] ) ? $r['items'] : masar_items_to_text( $orig, $spec['items'] );
				echo '<div class="mfull"><label>العناصر — سطر لكل عنصر: <span class="hint">' . esc_html( $spec['items']['hint'] ) . '</span></label><textarea rows="5" name="layout[' . (int) $i . '][items]">' . esc_textarea( $txt ) . '</textarea></div>';
			}
			if ( ! $spec['fields'] && ! isset( $spec['items'] ) ) { echo '<p class="hint mfull">السكشن ده محتواه تلقائي، تقدري تظهريه/تخفيه وترتبيه بس.</p>'; }
			echo '</div></div>';
		}
		echo '</div><p><button class="button button-primary button-large">💾 حفظ التعديلات</button> ';
		echo '<button class="button" type="submit" name="action" value="masar_reset_layout" onclick="return confirm(\'ترجيع القالب للوضع الأصلي؟\')">↩️ رجوع للأصل</button></p></form>';
		echo '<script>(function(){var box=document.getElementById("masar-rows");box.addEventListener("click",function(e){var r=e.target.closest(".mrow");if(!r)return;if(e.target.classList.contains("mup")&&r.previousElementSibling){box.insertBefore(r,r.previousElementSibling)}if(e.target.classList.contains("mdn")&&r.nextElementSibling){box.insertBefore(r.nextElementSibling,r)}});box.addEventListener("change",function(e){if(e.target.classList.contains("mon")){e.target.closest(".mrow").classList.toggle("off",!e.target.checked)}});})();</script>';
	}
}
